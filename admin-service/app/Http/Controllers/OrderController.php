<?php

namespace App\Http\Controllers;

use App\Enums\CacheKey;
use App\Events\OrderAcceptedEvent;
use App\Events\OrderCreatedEvent;
use App\Events\OrderDeliveryEvent;
use App\Events\OrderUpdatedEvent;
use App\Events\OrderWithdrawEvent;
use App\Http\Requests\CreateCustomOffer;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Jobs\ProcessOrderAttachmentJob;
use App\Models\Message;
use App\Models\Order;
use App\Models\Plan;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    const PAGINATION = 20;

    public function index()
    {
        $stats = [
            'active'    => Order::whereIn('status', [0, 1, 2])->count(),
            'completed' => Order::where('status', 5)->count(),
            'canceled'  => Order::where('status', 6)->count(),
        ];

        $page = request('page', 1);

        $cacheKey = CacheKey::Order_ALL->value. ':page:'. $page;

        $orders = Cache::tags([CacheKey::Order_ALL->value])->remember($cacheKey, now()->addDay(), function () {
            return Order::latest()->paginate(self::PAGINATION);
        });

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * @throws \Throwable
     */

    public function progressingOrders()
    {
        $page = request('page', 1);

        $cacheKey = CacheKey::PROGRESSING_ORDERS->value. ':page:'. $page;

        $orders = Cache::tags([CacheKey::PROGRESSING_ORDERS->value])->remember($cacheKey, now()->addDay(), function () {
            return Order::where('status', 2)->paginate(self::PAGINATION);
        });

        return view('admin.orders.orders', compact('orders'));
    }

    public function inCompleteOrders()
    {
        $page = request('page', 1);

        $cacheKey = CacheKey::IN_COMPLETE_ORDERS->value. ':page:'. $page;

        $orders = Cache::tags([CacheKey::IN_COMPLETE_ORDERS->value])->remember($cacheKey, now()->addDay(), function () {
            return Order::whereIn('status', [0, 1])->paginate(self::PAGINATION);
        });

        return view('admin.orders.orders', compact('orders'));
    }

    public function revisionOrders()
    {
        $page = request('page', 1);

        $cacheKey = CacheKey::REVISION_ORDERS->value. ':page:'. $page;

        $orders = Cache::tags([CacheKey::REVISION_ORDERS->value])->remember($cacheKey, now()->addDay(), function () {
            return Order::whereHas('revisionRequests')->paginate(self::PAGINATION);
        });

        return view('admin.orders.orders', compact('orders'));
    }

    public function store(OrderRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = $request->user();

            $plan = Plan::find($request->plan_id);

            $hasFiles = $request->hasFile('files');

            $isInComplete = filled($request->requirements) || $hasFiles || $request->requirement_external_url;

            $order = Order::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'unit_price' => $plan->price,
                'quantity' => $request->quantity,
                'total_amount' => $request->quantity * $plan->price,
                'revision_limit' => $plan->revision,
                'requirements' => $request->requirements,
                'requirement_external_url' => $request->requirement_external_url,
                'duration' => $plan->duration,
                'payment_status' => Order::PAYMENT_UNPAID,
                'status' => $isInComplete
                    ? Order::ORDER_IN_COMPLETED
                    : Order::ORDER_PENDING,
                'slug' => Str::random(44),
            ]);

            if($hasFiles){
                foreach ($request->file('files', []) as $file) {
                    $uniqueFolder = "tmp/order-requirements-files/" . uniqid() . '_' . time();

                    $tempPath = $file->storeAs(
                        $uniqueFolder,
                        $file->getClientOriginalName(),
                        'public'
                    );

                    ProcessOrderAttachmentJob::dispatch(
                        attachmentType: 'requirement',
                        orderId: $order->id,
                        tempPath: $tempPath,
                        originalName: $file->getClientOriginalName(),
                        mimeType: $file->getClientMimeType(),
                    );
                }
            }

            // event
            event(new OrderCreatedEvent($order));

            $this->invalidateCache();

            return response()->json([
                'success' => true,
                'data' => $order,
            ], 201);
        });
    }

    public function show(Order $order)
    {
//        return $order;
        $order->load([
            'user',
            'plan',
            'requirementFiles',
            'deliveryFiles',
            'revisionRequests',
            'revisionRequests.requirementFiles'
        ]);

        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load([
            'requirementFiles',
            'deliveryFiles',
            'revisionRequests',
            'revisionRequests.requirementFiles'
        ]);

        return view('admin.orders.edit', compact('order'));
    }

    public function update(OrderUpdateRequest $request, Order $order)
    {
        $payment_status = $request->payment_status;

        $hasDeliveryFilesUploaded = $request->hasFile('delivery_files');

        $isOrderDelivered = $hasDeliveryFilesUploaded || $request->delivery_external_url;

        //check is start order process
        $isOrderProcessStart = $order->requirements && ($order->requirementFiles()->exists() || $order->requirement_external_url) && $payment_status == 1;

        $inputs = [
            'payment_status' => $payment_status,
            'delivery_external_url' => $request->delivery_external_url,
            'payment_url' => $payment_status ? null : $request->payment_url,
        ];

        // if just payment against order make order status incompleted
        if($payment_status) {
            $inputs['status'] = Order::ORDER_IN_COMPLETED;
        }

        if($isOrderProcessStart) {
            $inputs['status'] = Order::ORDER_IN_PROGRESS;

            if (is_null($order->due_at)) {
                $inputs['due_at'] = now()->addDays($order->duration);
            }
        }

        if($request->status == 6) {
            $inputs['status'] = Order::ORDER_CANCELLED;
            $inputs['cancelled_at'] = now();
        }

        if($hasDeliveryFilesUploaded) {
            $previousFiles = $order->deliveryFiles()->get();

            foreach ($previousFiles as $file) {
                removeImage($file->getRawOriginal('file_path'));
                $file->delete();
            }

            foreach ($request->file('delivery_files') as $file) {
                $uniqueFolder = "tmp/order-requirements-files/" . uniqid() . '_' . time();

                $tempPath = $file->storeAs(
                    $uniqueFolder,
                    $file->getClientOriginalName(),
                    'public'
                );

                ProcessOrderAttachmentJob::dispatch(
                    attachmentType: 'delivery',
                    orderId: $order->id,
                    tempPath: $tempPath,
                    originalName: $file->getClientOriginalName(),
                    mimeType: $file->getClientMimeType(),
                );
            }
        }

        // order delivery
        if($isOrderDelivered)
        {
            $inputs['status'] = Order::ORDER_DELIVERED;
            $inputs['delivery_message'] = $request->delivery_message;
            $inputs['delivered_at'] = now();
        }

        $order->update($inputs);

        // event dispatch
        broadcast(new OrderUpdatedEvent($order));

        if($order->status == Order::ORDER_DELIVERED) {
            OrderDeliveryEvent::dispatch($order, "Your order was delivered.");

            // reset stats cache
            Cache::deleteMultiple([
                CacheKey::STATS_ORDER_COUNTER->value,
                CacheKey::STATS_FAKE_ORDER_COUNTER->value,
                CacheKey::STATS_MIX_ORDER_COUNTER->value,
            ]);
        }

        Cache::forget(CacheKey::USER_ORDERS->value. $order->user_id);
        $this->invalidateCache();

        return redirect()->route('orders.index')->with('success', 'Order updated');
    }

    public function destroy(Order $order)
    {
        $order->deliveryFiles()->get()->each(function ($file) {
            removeImage($file->getRawOriginal('file_path'));
            $file->delete();
        });

        $order->requirementFiles()->get()->each(function ($file) {
            removeImage($file->getRawOriginal('file_path'));
            $file->delete();
        });

        $order->revisionRequests()->get()->each(function ($request) {
            $request->files()->get()->each(function ($file) {
                removeImage($file->getRawOriginal('file_path'));
                $file->delete();
            });
        });

        Cache::forget(CacheKey::USER_ORDERS->value. $order->user_id);
        $this->invalidateCache();

        $deletedOrder = $order;

        $order->delete();

        // event dispatch
        broadcast(new OrderUpdatedEvent($deletedOrder));

        return back()->with('success', 'Order deleted');
    }

    public function orders(Request $request)
    {
        $user = $request->user();

        $cacheKey = CacheKey::USER_ORDERS->value. $user->id;

        $orders = Cache::remember($cacheKey, now()->addDay(), function () use($user) {
            return Order::with(['plan' => fn($q) => $q->select(['id', 'title'])])->where('user_id', $user->id)->latest()->get();
        });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    // order accepted
    public function acceptOrder(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->update([
            'status' => Order::ORDER_COMPLETED,
            'accepted_at' => now(),
        ]);

        Cache::forget(CacheKey::USER_ORDERS->value. $order->user_id);

        $this->invalidateCache();

        // event dispatch
        OrderAcceptedEvent::dispatch($order);

        return response()->json([
            'success' => true,
            'message' => 'Order accepted successfully.',
            'data' => $order,
        ]);
    }

    public function orderDetails(Order $order)
    {
        return response()->json([
            'success' => true,
            'data' => $order->load([
                'requirementFiles',
                'deliveryFiles',
                'revisionRequests',
                'revisionRequests.deliveryFiles'
            ])
        ]);
    }

    /**
     * @throws \Throwable
     */

    public function createCustomOffer(CreateCustomOffer $request, MessageService $messageService)
    {
        return DB::transaction(function () use ($request, $messageService) {

            // create custom order
            $order = Order::create([
                'user_id' => $request->user_id,
                'revision_limit' => $request->revisions,
                'quantity' => $request->quantity,
                'duration' => $request->duration,
                'total_amount' => $request->price,
                'requirements' => $request->requirements,
                'created_by' => 'admin',
                'slug' => Str::random(44),
                'order_status' => $request->requirements ? 1 : 0,
            ]);

            $messageInputs = [
                'conversation_id' => $request->conversation_id,
                'order_id' => $order->id,
                'sender_id' => auth()->id(),
            ];

            $messageService->sendMessage($messageInputs);

            $cacheKey = CacheKey::USER_ORDERS->value. $order->user_id;

            // invalid cache
            Cache::forget($cacheKey);
            $this->invalidateCache();

            return response()->json([
                'success' => true,
                'data' => $order
            ]);
        });
    }

    public function withdrawOrder(int $msgId)
    {
        $message = Message::with('order')
            ->where('id', $msgId)
            ->first();

        $messageId = $message->id;
        $conversationId = $message->conversation_id;

        $userId = null;

        if($message->order) {
            $userId = $message->order->user_id;

            $requirementFiles = $message->order->requirementFiles()->get();
            foreach ($requirementFiles as $file) {
                removeImage($file->getRawOriginal('file_path'));
            }

            $message->order->requirementFiles()->delete();

            $deliveryFiles = $message->order->deliveryFiles()->get();

            foreach ($deliveryFiles as $file) {
                removeImage($file->getRawOriginal('file_path'));
            }

            $message->order->deliveryFiles()->delete();

            $message->order->delete();

        }

        broadcast(new OrderWithdrawEvent($conversationId, $messageId));

        $message->delete();

        if($userId) {
            Cache::forget(CacheKey::USER_ORDERS->value. $userId);
        }

        $this->invalidateCache();

        return response()->json([
            'success' => true,
            'message' => 'Order withdrawn successful.',
        ]);
    }

    public function invalidateCache()
    {
        Cache::tags(CacheKey::Order_ALL->value)->flush();
        Cache::tags(CacheKey::PROGRESSING_ORDERS->value)->flush();
        Cache::tags(CacheKey::IN_COMPLETE_ORDERS->value)->flush();
        Cache::tags(CacheKey::REVISION_ORDERS->value)->flush();
    }
}
