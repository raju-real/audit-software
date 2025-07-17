@extends('admin.layouts.app')
@section('title','Company Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Add/Edit Company</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.companies.index') }}"
                       class="btn btn-sm btn-outline-primary">
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
                        <input type="hidden" id="method_mode" value="{{ isset($company) ? 'PUT' : 'POST' }}">
                        @csrf
                        @isset($company)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Name {!! starSign() !!}</label>
                                    <input type="text" name="name"
                                           value="{{ old('name') ?? $company->name ?? '' }}"
                                           class="form-control {{ hasError('name') }}"
                                           placeholder="Name">
                                    @error('name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Email {!! starSign() !!}</label>
                                    <input type="text" name="email"
                                           value="{{ old('email') ?? $company->email ?? '' }}"
                                           class="form-control {{ hasError('email') }}"
                                           placeholder="Email">
                                    @error('email')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Mobile {!! starSign() !!}</label>
                                    <input type="text" name="mobile"
                                           value="{{ old('mobile') ?? $company->mobile ?? '' }}"
                                           class="form-control {{ hasError('mobile') }}"
                                           placeholder="Mobile">
                                    @error('mobile')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone"
                                           value="{{ old('phone') ?? $company->phone ?? '' }}"
                                           class="form-control {{ hasError('phone') }}"
                                           placeholder="Phone">
                                    @error('phone')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Contact Person Name {!! starSign() !!}</label>
                                    <input type="text" name="contact_person_name"
                                           value="{{ old('contact_person_name') ?? $company->contact_person_name ?? '' }}"
                                           class="form-control {{ hasError('contact_person_name') }}"
                                           placeholder="Contact Person Name">
                                    @error('contact_person_name')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Contact Person Mobile {!! starSign() !!}</label>
                                    <input type="text" name="contact_person_mobile"
                                           value="{{ old('contact_person_mobile') ?? $company->contact_person_mobile ?? '' }}"
                                           class="form-control {{ hasError('contact_person_mobile') }}"
                                           placeholder="Contact Person Mobile">
                                    @error('contact_person_mobile')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Address {!! starSign() !!}</label>
                                    <textarea name="address" class="form-control {{ hasError('address') }}" placeholder="Address">{{ old('address') ?? $company->address ?? '' }}</textarea>
                                    @error('address')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control {{ hasError('description') }}" placeholder="Description">{{ old('description') ?? $company->description ?? '' }}</textarea>
                                    @error('description')
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
                                                value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($company) && $company->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
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
