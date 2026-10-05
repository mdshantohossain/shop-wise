@extends('admin.layouts.master')

@section('title', isset($faq) ? 'Edit FAQ' : 'Create FAQ')

@section('body')
    <div class="row">
        <div class="col-xl-8 mx-auto ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>{{ isset($faq) ? 'Edit FAQ' : 'Create FAQ' }}</h3>

                        <a href="{{ route('faqs.index') }}" class="btn btn-sm btn-secondary waves-effect waves-light btn-sm">
                            Back
                        </a>
                    </div>
                    <form method="POST" action="{{ isset($faq) ? route('faqs.update', $faq->id) : route('faqs.store') }}" >
                        @csrf
                        @if(isset($faq))
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label for="question" class="form-label">Question<span class="text-danger">*</span></label>
                            <input type="text" id="question" class="form-control" value="{{ old('question', $faq->question ?? '') }}" name="question" placeholder="e.g. How can I place an order?" />
                            @error('question')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="answer" class="form-label">Answer<span class="text-danger">*</span></label>
                            <textarea name="answer" id="answer" class="form-control" rows="5" placeholder="Provide a clear and helpful answer" >{{ old('answer', $faq->answer ?? '') }}</textarea>
                            @error('answer')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority<span class="text-danger">*</span></label>
                            <input type="number" id="priority" class="form-control" min="1" value="{{ old('priority', $faq->priority ?? '') }}" name="priority" placeholder="Lower number = higher priority (e.g. 1)" />
                            @error('priority')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="radio" class="form-check-input" {{ old('is_active',  $faq->is_active ?? 1) == 1 ? 'checked' : '' }} id="published" name="is_active" value="1" />
                                    <label for="published" class="form-check-label">Publish</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="radio" class="form-check-input" {{ old('is_active', $faq->is_active ?? 1) == 0 ? 'checked' : '' }} id="unpublished" name="is_active" value="0" />
                                    <label for="unpublished" class="form-check-label" >Unpublish</label>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary w-md">
                                {{ isset($faq) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection



