<?php

namespace App\Modules\Order\app\Http\Controllers;

use App\Events\OrderDeliveredEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\User;
use App\Modules\Order\app\Models\Order;
use App\Services\AuthService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index', [
            'orders' => Order::with('user')->latest()->get(),
        ]);
    }

    public function show(Order $order): View
    {
        // check permission of current user
        isAuthorized('order show');

        $order->load(['user', 'orderDetails', 'orderDetails.product']);
        return view('admin.order.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        // check permission of current user
        isAuthorized('order edit');

        $order->load('user');
        return view('admin.order.edit', compact('order'));
    }

    public function update(OrderUpdateRequest $request, Order $order): RedirectResponse
    {
        // check permission of current user
        isAuthorized('order update');

        $validated = $request->validated();

        if($request->order_status == 1) {
            $order->order_status = 1;
            $order->phone = $validated['phone'];
            $order->delivery_address = $validated['delivery_address'];
            $order->save();

            return redirect('/orders')->with('success', 'Order updated successful.');

        } elseif($request->order_status == 2) {
            $order->order_status = 2;
            $order->delivery_at = now();

            if($order->payment_type == 0) {
                $order->payment_status = 1;
                $order->paid_at = now();
            }

            $order->save();

            // event fires when delivery done
            event(new OrderDeliveredEvent($order));

            return redirect('/orders')->with('success', 'Order delivered successful.');
        } elseif($request->order_status == 3) {
            $order->order_status = 3;
            $order->payment_status = 0;

            $order->save();
            return redirect('/orders')->with('warning', 'Order canceled');
        } else {
            return redirect('/orders')->with('warning', 'Nothing changed.');
        }
    }

    public function destroy(Order $order): RedirectResponse
    {
        // check permission of current user
        isAuthorized('order destroy');

        try {
            $order->delete();

            return back()->with('success', 'Order deleted successfully');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function invoice(Order $order): Response
    {
        // check permission of current user
        isAuthorized('order invoice download');

        $order->load(['user', 'orderDetails','orderDetails.product']);
        $pdf = Pdf::loadView('admin.order.order-invoice', compact('order'));
        return $pdf->download('invoice-'.$order->id.'.pdf');
    }
    /**
     * @throws \Throwable
     */
    public function placeOrder(
        OrderRequest $request,
        AuthService $authService,
        OrderService $orderService,
        PaymentService $paymentService,
    ) {
        $data = $request->validated();

        $authResponse = null;

        // authentication
        if(empty($data['user_id'])) {
            $user = User::where('email', $data['email'])->first();

            // register if user not exists
            if(!$user) {
                $userCredential = [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' =>$data['password'],
                    'phone' => $data['phone'],
                ];

                // register
                $user = $authService->register($userCredential);

                $userId = $user->id;

                // set auth response type as register
                $authResponse['type'] = 'registered';
                $authResponse['message'] = 'Registered successfully. Check your email for verify your email address';

            } else {
                // login if exists user
                $existsUser = [
                  'email' => $data['email'],
                  'password' => $data['password'],
                  'phone' => $data['phone'],
                ];

                if (!Hash::check($data['password'], $user->password)) {
                    return response()->json([
                        'status' => false,
                        'message' => "You're already register user. Login then order again",
                    ], 400);
                }

                // user login
                $response = $authService->login($existsUser);

                if(!isset($response['payload'])) {
                    return response()->json($response);
                }

                $userId = $response['payload']['user']['id'];

                // set auth response type as register
                $authResponse['type'] = 'login';
                $authResponse['message'] = 'You was registered user. Login successfully';
                $authResponse['data'] = $response['payload'];
            }
        } else {
            $userId = $data['user_id'];
            $user = User::find($userId);

            if(!$user->phone) {
                $user->update(['phone' => $data['phone']]);
            }
        }

        // create initiate order
        $order = $orderService->createOrder($userId, $data);

        // if online payment or include delivery charge then payment url will be generated
        if($order->payment_type || ($order->delivery_charge > 0)) {
            $paymentUrl = $paymentService->initiatePayment($order);
        }

        // final response
        $response = [
            'success' => true,
            'message' => 'Order placed successfully',
            'data' => [
                'auth_response' => $authResponse,
                'payment_url' => $paymentUrl ?? null,
                'token' => $paymentToken ?? $order->slug,
            ],
        ];

        return response()->json($response, 201);
    }

    public function verifyOrder(string $slug)
    {
        $order = Order::with('payment')->where('slug', $slug)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid order.'
            ]);
        }

        if($order->payment && $order->payment?->status == '1') {
            return response()->json([
                'success' => true,
                'message' => 'Your order has been placed successfully. We’ve received your payment and your order is now being processed. You can track your order status from your dashboard.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Your order has been placed successfully. But payment is still pending. You can retry the payment from your dashboard to complete your order."
        ]);
    }

    public function getOrders()
    {
        $user = request()->user();

        $cacheKey = "user_orders:$user->id";

        $orders = Cache::remember($cacheKey, 3600, function () use ($user) {
            return $user->orders()->with(['payment' => function ($q) {
                $q->select('id', 'order_id', 'bank_type');
            },'orderDetails', 'orderDetails.product'])->latest()->get();
        });

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }
}
