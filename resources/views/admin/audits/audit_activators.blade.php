@extends('admin.layouts.app')
@section('title','Who is where')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Who is where</h4>
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
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseSearch"
                                aria-expanded="{{ request()->query() ? 'true' : 'false' }}"
                                aria-controls="collapseSearch">
                            Search
                        </button>
                    </h2>
                    <div id="collapseSearch" class="accordion-collapse collapse {{ request()->query() ? 'show' : '' }}"
                         aria-labelledby="headingSearch"
                         data-bs-parent="#accordionSearch">
                        <div class="accordion-body">
                            <form method="GET" action="{{ route('admin.audit-wise-activators') }}">
                                <div class="row">
                                    <div class="col-md-4 pb-4">
                                        <div class="form-group">
                                            <input type="search" name="search" class="form-control"
                                                   placeholder="Search by Audit Number, Title" value="{{ request('search') ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="financial_year" class="form-control slim-select">
                                                <option value="" {{ !isset(request()->financial_year) ? 'selected' : '' }}>Financial Year</option>
                                                @foreach(financialYears() as $financial_year)
                                                    <option
                                                        value="{{ $financial_year->financial_year }}" {{ request('financial_year') === $financial_year->financial_year ? 'selected' : '' }}>{{ $financial_year->financial_year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="organization" class="form-control slim-select">
                                                <option value="" {{ !isset(request()->organization) ? 'selected' : '' }}>Organization</option>
                                                @foreach(activeOrganizations() as $organization)
                                                    <option
                                                        value="{{ $organization->slug }}" {{ request('organization') === $organization->slug ? 'selected' : '' }}>{{ $organization->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="step_status" class="form-select">
                                                <option value="" {{ !isset(request()->step_status) ? 'selected' : '' }}>Workflow Status</option>
                                                @foreach(getAuditStepStatus() as $status)
                                                    <option
                                                        value="{{ $status->value }}" {{ request('step_status') === $status->value ? 'selected' : '' }}>{{ $status->title }}</option>
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
                                <th>Audit</th>
                                <th class="text-center">F.Y</th>
                                <th>Organization/Client</th>
                                <th>Workflow Status</th>
                                <th>Auditors</th>
                                <th>Supervisors</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($audits as $audit)
                                <tr>
                                    <td>{{ $audit->audit_number }} - {{ $audit->title ?? '' }}</td>
                                    <td class="text-center">{{ $audit->financial_year->financial_year ?? '' }}</td>
                                    <td>{{ $audit->organization->name ?? '' }}</td>
                                    <td>{{ ucFirst($audit->workflow_status) ?? '' }}</td>
                                    <td>{{ auditWiseAuditors($audit->id) }}</td>
                                    <td>{{ auditWiseSupervisors($audit->id) }}</td>
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


