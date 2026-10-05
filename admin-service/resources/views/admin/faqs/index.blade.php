@extends('admin.layouts.master')

@section('title', 'FAQS')

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="">All FAQS</h3>
                        @can('category create')
                        <a href="{{ route('faqs.create') }}" class="btn btn-sm btn-primary waves-effect waves-light">
                            Add FAQ
                        </a>
                        @endcan
                    </div>

                    <div class="table-responsive">
                        <table id="datatable" class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="align-middle">Sl.</th>
                                <th class="align-middle">Question</th>
                                <th class="align-middle">Answer</th>
                                <th class="align-middle">Status</th>
                                @canany(['category edit', 'category destroy'])
                                <th class="align-middle">Action</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($faqs as $faq)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ substr($faq->question, 0, 30) }}
                                    </td>
                                    <td>
                                        {{ substr($faq->answer, 0, 30) }}
                                    </td>
                                    <td>
                                        {!! getStatus($faq->is_active) !!}
                                    </td>
                                    @canany(['faq edit', 'faq destroy'])
                                    <td>
                                        <div>
                                            @can('faq edit')
                                                <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-sm btn-primary" >
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('faq destroy')
                                                <a href="#" class="btn btn-sm btn-danger" onclick='confirmDelete(event, "deleteForm-{{ $faq->id }}")'>
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" id="deleteForm-{{ $faq->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                    @endcanany
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
