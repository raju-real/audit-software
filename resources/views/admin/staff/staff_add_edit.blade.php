@extends('admin.layouts.app')
@section('title','Staff Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Add/Edit Staff</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.staffs.index') }}"
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
                        <input type="hidden" id="method_mode" value="{{ isset($staff) ? 'PUT' : 'POST' }}">
                        @csrf
                        @isset($staff)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Designation {!! starSign() !!}</label>
                                    <select name="designation" class="form-control select2 {{ hasError('designation') }} ">
                                        <option value="">Select Designation</option>
                                        @foreach($designations as $designation)
                                            <option value="{{ $designation->id }}" {{ old('designation') == $designation->id || isset($staff) && $staff->designation_id == $designation->id ? 'selected' : '' }}>{{ $designation->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('designation')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Name {!! starSign() !!}</label>
                                    <input type="text" name="name"
                                           value="{{ old('name') ?? $staff->name ?? '' }}"
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
                                           value="{{ old('email') ?? $staff->email ?? '' }}"
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
                                           value="{{ old('mobile') ?? $staff->mobile ?? '' }}"
                                           class="form-control {{ hasError('mobile') }}"
                                           placeholder="Mobile">
                                    @error('mobile')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Password
                                        @if(!isset($staff))
                                            {!! starSign() !!}
                                        @endif
                                    </label>
                                    <input type="password" name="password"
                                           value=""
                                           class="form-control {{ hasError('password') }}"
                                           placeholder="Password" max="12">
                                    @error('password')
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
                                                value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($staff) && $staff->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
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
