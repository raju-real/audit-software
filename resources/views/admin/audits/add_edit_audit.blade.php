@extends('admin.layouts.app')
@section('title', 'Audit Add/Edit')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Audit Add/Edit</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.audits.index') }}" class="btn btn-sm btn-outline-primary">
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
                    <form action="{{ $route }}" method="POST" id="prevent-form" enctype="multipart/form-data">
                        <input type="hidden" id="method_mode" value="{{ isset($audit) ? 'PUT' : 'POST' }}">
                        @csrf
                        @isset($audit)
                            @method('PUT')
                        @endisset
                        <div class="row">

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Title {!! starSign() !!}</label>
                                    <input type="text" name="title" value="{{ old('title') ?? ($audit->title ?? '') }}"
                                        class="form-control {{ hasError('title') }}" placeholder="Title">
                                    @error('title')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Financial Year {!! starSign() !!}</label>
                                    <select name="financial_year"
                                        class="form-control select2 {{ hasError('financial_year') }} ">
                                        <option value="">Select F.Y</option>
                                        @foreach (financialYears() as $financial_year)
                                            <option value="{{ $financial_year->id }}"
                                                {{ old('financial_year') == $financial_year->id || (isset($audit) && $audit->financial_year_id == $financial_year->id) ? 'selected' : '' }}>
                                                {{ $financial_year->financial_year ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('financial_year')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Organization {!! starSign() !!}</label>
                                    <select name="organization"
                                        class="form-control select2 {{ hasError('organization') }} ">
                                        <option value="">Select Organization</option>
                                        @foreach (activeOrganizations() as $organization)
                                            <option value="{{ $organization->id }}"
                                                {{ old('organization') == $organization->id || (isset($audit) && $audit->organization_id == $organization->id) ? 'selected' : '' }}>
                                                {{ $organization->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                    @error('organization')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Start Date {!! starSign() !!}</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="start_date" class="form-control datepicker"
                                                autocomplete="off"
                                                value="{{ old('start_date') ?? ($audit->start_date ?? '') }}"
                                                placeholder="Start Date" autocomplete="off" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-calendar"></i> </span>
                                            </div>

                                        </div>
                                        @error('start_date')
                                            {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>End Date</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="end_date" class="form-control datepicker"
                                                autocomplete="off"
                                                value="{{ old('end_date') ?? ($audit->end_date ?? '') }}"
                                                placeholder="End Date" autocomplete="off" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fa fa-calendar"></i> </span>
                                            </div>

                                        </div>
                                        @error('end_date')
                                            {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Priority {!! starSign() !!}</label>
                                    <select name="priority"
                                        class="form-select select2-search-disable {{ hasError('priority') }}">
                                        @foreach (getPriorityStatus() as $status)
                                            <option value="{{ $status->value }}"
                                                {{ old('priority') === $status->value || (isset($audit) && $audit->priority === $status->value && empty(old('priority'))) ? 'selected' : '' }}>
                                                {{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('priority')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Work Flow Status {!! starSign() !!}</label>
                                    <select name="workflow_status"
                                        class="form-select select2-search-disable {{ hasError('workflow_status') }}">
                                        @foreach (getWorkFlowStatus() as $status)
                                            <option value="{{ $status->value }}"
                                                {{ old('workflow_status') === $status->value || (isset($audit) && $audit->workflow_status === $status->value && empty(old('workflow_status'))) ? 'selected' : '' }}>
                                                {{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('workflow_status')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Reference Document(jpg,jpeg,png,pdf&Mx:5MB)</span>
                                        @if (isset($audit->reference_document) && file_exists($audit->reference_document))
                                            <a target="_blank" href="{{ asset($audit->reference_document) }}"
                                                class="custom-badge badge-info" title="View Document">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                    </label>
                                    <input type="file" name="reference_document"
                                        class="form-control {{ hasError('reference_document') }}"
                                        accept=".jpg, .jpeg, .png, .pdf">
                                    @error('reference_document')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Status {!! starSign() !!}</label>
                                    <select name="status"
                                        class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach (getStatus() as $status)
                                            <option value="{{ $status->value }}"
                                                {{ old('status') === $status->value || (isset($audit) && $audit->status === $status->value && empty(old('status'))) ? 'selected' : '' }}>
                                                {{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                @php
                                    $selectedAuditors = old(
                                        'auditors',
                                        isset($audit) ? auditAuditorsToArray($audit->id) : [],
                                    );
                                @endphp
                                <div class="mb-3">
                                    <label class="form-label">Auditors(Min one required) {!! starSign() !!}</label>
                                    <select name="auditors[]" class="form-control select2" multiple
                                        data-placeholder="Auditors ...">
                                        <option value="">Select Auditors</option>
                                        @foreach (getActiveAdmins() as $admin)
                                            <option value="{{ $admin->id }}"
                                                {{ in_array($admin->id, $selectedAuditors) ? 'selected' : '' }}>
                                                {{ $admin->name ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('auditors')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                @php
                                    $selectedSupervisors = old(
                                        'supervisors',
                                        isset($audit) ? auditSupervisorsToArray($audit->id) : [],
                                    );
                                @endphp
                                <div class="mb-3">
                                    <label class="form-label">Supervisor(Min one required) {!! starSign() !!}</label>
                                    <select name="supervisors[]" class="form-control select2" multiple="multiple"
                                        data-placeholder="Supervisors ...">
                                        <option value="">Select Supervisors</option>
                                        @foreach (getActiveAdmins() as $admin)
                                            <option value="{{ $admin->id }}"
                                                {{ in_array($admin->id, $selectedSupervisors) ? 'selected' : '' }}>
                                                {{ $admin->name ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supervisors')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description" id="description">{{ old('description') ?? ($audit->description ?? '') }}</textarea>
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
    <script>
        let config = {
            toolbar: [
                ['Bold', 'Italic', 'Strike', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'NumberedList',
                    'BulletedList', '-', 'Maximize'
                ], // 'Maximize' button added
            ]
        };

        CKEDITOR.config.allowedContent = true;
        CKEDITOR.replace('description', config);
    </script>
@endpush
