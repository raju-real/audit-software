@extends('admin.layouts.app')
@section('title','Audit Step Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Audit Step Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.question-list', $audit_step->slug) }}" class="btn btn-sm btn-outline-primary">
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
                        <input type="hidden" id="method_mode" value="{{ isset($step) ? 'PUT' : 'POST' }}">
                        @csrf
                        @isset($step)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Title {!! starSign() !!}</label>
                                    <input type="text" name="title" value="{{ old('title') ?? $step->title ?? '' }}"
                                           class="form-control {{ hasError('title') }}"
                                           placeholder="Title">
                                    @error('title')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">ISA Reference {!! starSign() !!}</label>
                                    <input type="text" name="isa_reference"
                                           value="{{ old('isa_reference') ?? $step->isa_reference ?? '' }}"
                                           class="form-control {{ hasError('isa_reference') }}"
                                           placeholder="ISA Reference">
                                    @error('isa_reference')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status {!! starSign() !!}</label>
                                    <select name="status"
                                            class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach(getStatus() as $status)
                                            <option
                                                value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($step) && $step->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description"
                                              id="description">{{ old('description') ?? $step->description ?? '' }}</textarea>
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

@push('js')

@endpush
