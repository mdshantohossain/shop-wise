<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use App\Services\FaqService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FaqController extends Controller
{
    protected string $cacheKey = 'faqs.all', $activeCacheKey = 'faqs.active';

    public function index()
    {
        $faqs = Cache::remember($this->cacheKey, now()->addDays(10), function () {
            return Faq::latest()->get();
        });
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        isAuthorized('faq create');

        return view('admin.faqs.form');
    }

    public function store(FaqRequest $request, FaqService $faqService): RedirectResponse
    {
        isAuthorized('faq create');

        $faq = $faqService->createOrUpdate($request->validated());

        if(!$faq) {
            return back()->with('error', 'Failed to create FAQ');
        }

        $this->forgetCache();

        return redirect()->route('faqs.index')->with('success', 'FAQ created successfully');
    }

    public function edit(Faq $faq): View
    {
        isAuthorized('faq edit');
        return view('admin.faqs.form', compact('faq'));
    }

    public function update(FaqRequest $request, Faq $faq, FaqService $faqService): RedirectResponse
    {
        isAuthorized('faq edit');
        $storedFaq = $faqService->createOrUpdate($request->validated(), $faq);

        if(!$storedFaq) {
            return back()->with('error', 'Failed to update FAQ');
        }

        $this->forgetCache();

        return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        $this->forgetCache();

        return back()->with('success', 'FAQ has been deleted');
    }

    public function forgetCache(): void
    {
        Cache::forget($this->cacheKey);
        Cache::forget($this->activeCacheKey);
    }

    public function getAllFaqs()
    {
        $faqs = Cache::remember($this->activeCacheKey, now()->addDays(10), function () {
           return Faq::where('is_active', 1)->latest()->get();
        });

        return response()->json([
            'success' => true,
            'data' => $faqs
        ]);
    }
}
