@extends('admin.layouts.app')
@section('title','Financial Year Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Financial Year Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.financial-years.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-arrow-circle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ $route }}" method="POST" id="prevent-form">
                        @csrf
                        @isset($financial_year)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Financial Year {!! starSign() !!}</label>
                                    <input type="text" name="financial_year" value="{{ old('financial_year') ?? $financial_year->financial_year ?? '' }}"
                                           class="form-control {{ hasError('financial_year') }}"
                                           placeholder="Financial Year. Ex: 2024-25">
                                    @error('financial_year')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control {{ hasError('description') }}" placeholder="Description">{{ old('description') ?? $financial_year->description ?? '' }}</textarea>
                                    @error('description')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div>
                            <x-submit-button></x-submit-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js') @endpush
