@extends('admin.layouts.app')
@section('title','Organization Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Add/Edit Organization</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.organizations.index') }}"
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
                        <input type="hidden" id="method_mode" value="{{ isset($organization) ? 'PUT' : 'POST' }}">
                        @csrf
                        @isset($organization)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Name {!! starSign() !!}</label>
                                    <input type="text" name="name"
                                           value="{{ old('name') ?? $organization->name ?? '' }}"
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
                                           value="{{ old('email') ?? $organization->email ?? '' }}"
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
                                           value="{{ old('mobile') ?? $organization->mobile ?? '' }}"
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
                                           value="{{ old('phone') ?? $organization->phone ?? '' }}"
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
                                           value="{{ old('contact_person_name') ?? $organization->contact_person_name ?? '' }}"
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
                                           value="{{ old('contact_person_mobile') ?? $organization->contact_person_mobile ?? '' }}"
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
                                    <textarea name="address" class="form-control {{ hasError('address') }}" placeholder="Address">{{ old('address') ?? $organization->address ?? '' }}</textarea>
                                    @error('address')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control {{ hasError('description') }}" placeholder="Description">{{ old('description') ?? $organization->description ?? '' }}</textarea>
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
                                                value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($organization) && $organization->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
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
