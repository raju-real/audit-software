@extends('admin.layouts.app')
@section('title', 'Audit List')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Audit List</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.audits.create') }}" class="btn btn-sm btn-primary">
                        <i class="fa fa-plus-circle"></i> Add New
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Accordion for Search -->
            <div class="accordion mb-3" id="accordionSearch">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSearch">
                        <button class="accordion-button {{ request()->query() ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseSearch"
                            aria-expanded="{{ request()->query() ? 'true' : 'false' }}" aria-controls="collapseSearch">
                            Search
                        </button>
                    </h2>
                    <div id="collapseSearch" class="accordion-collapse collapse {{ request()->query() ? 'show' : '' }}"
                        aria-labelledby="headingSearch" data-bs-parent="#accordionSearch">
                        <div class="accordion-body">
                            <form method="GET" action="{{ route('admin.audits.index') }}">
                                <div class="row">
                                    <div class="col-md-4 pb-4">
                                        <div class="form-group">
                                            <input type="search" name="search" class="form-control"
                                                placeholder="Search by Audit Number, Title"
                                                value="{{ request('search') ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="financial_year" class="form-control slim-select">
                                                <option value=""
                                                    {{ !isset(request()->financial_year) ? 'selected' : '' }}>Financial Year
                                                </option>
                                                @foreach (financialYears() as $financial_year)
                                                    <option value="{{ $financial_year->financial_year }}"
                                                        {{ request('financial_year') === $financial_year->financial_year ? 'selected' : '' }}>
                                                        {{ $financial_year->financial_year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="organization" class="form-control slim-select">
                                                <option value=""
                                                    {{ !isset(request()->organization) ? 'selected' : '' }}>Organization
                                                </option>
                                                @foreach (activeOrganizations() as $organization)
                                                    <option value="{{ $organization->slug }}"
                                                        {{ request('organization') === $organization->slug ? 'selected' : '' }}>
                                                        {{ $organization->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="workflow_status" class="form-select">
                                                <option value=""
                                                    {{ !isset(request()->workflow_status) ? 'selected' : '' }}>Workflow
                                                    Status</option>
                                                @foreach (getWorkFlowStatus() as $status)
                                                    <option value="{{ $status->value }}"
                                                        {{ request('workflow_status') === $status->value ? 'selected' : '' }}>
                                                        {{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="step_status" class="form-select">
                                                <option value=""
                                                    {{ !isset(request()->step_status) ? 'selected' : '' }}>Step Status
                                                </option>
                                                @foreach (getAuditStepStatus() as $status)
                                                    <option value="{{ $status->value }}"
                                                        {{ request('step_status') === $status->value ? 'selected' : '' }}>
                                                        {{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-0">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0 text-nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Audit no.</th>
                                    <th>Title</th>
                                    <th class="text-center">F.Y</th>
                                    <th>Organization</th>
                                    <th>Current Status</th>
                                    <th class="text-center">Active Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($audits as $audit)
                                    <tr>
                                        <td class="text-center">{{ $audit->audit_number }}</td>
                                        <td>{{ $audit->title ?? '' }}</td>
                                        <td class="text-center">{{ $audit->financial_year->financial_year ?? '' }}</td>
                                        <td>{{ $audit->organization->name ?? '' }}</td>
                                        <td>{{ ucFirst($audit->workflow_status) ?? '' }}</td>
                                        <td class="text-center">
                                            <input type="checkbox" id="audit-{{ $loop->index + 1 }}" class="audit-status"
                                                data-id="{{ $audit->id }}" switch="bool"
                                                {{ isActive($audit->status) ? 'checked' : '' }} />
                                            <label class="custom-label-margin" for="audit-{{ $loop->index + 1 }}"
                                                data-on-label="Yes" data-off-label="No"></label>
                                        </td>
                                        <td class="text-center">
                                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Show Details"
                                                href="{{ route('admin.audits.show', $audit->slug) }}"
                                                class="btn btn-sm btn-soft-info"><i class="fa fa-eye"></i></a>
                                            @if ($audit->workflow_status === 'draft')
                                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                                    href="{{ route('admin.audits.edit', $audit->slug) }}"
                                                    class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i></a>
                                            @endif
                                            <a target="_blank" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Balance Sheet"
                                                href="{{ route('admin.audit-wise-balance-sheet', encrypt_decrypt($audit->id, 'encrypt')) }}"
                                                class="btn btn-sm btn-success"><i class="fa fa-credit-card"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <x-no-data-found></x-no-data-found>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/audit_list.js') }}"></script>
@endpush
