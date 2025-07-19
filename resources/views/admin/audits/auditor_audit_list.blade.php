@extends('admin.layouts.app')
@section('title', 'Audit List')

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
                                    <th>Audit Steps</th>
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
                                        <td>
                                            @foreach ($audit->audit_steps as $index => $audit_step)
                                                <ul class="list-group">
                                                    <li
                                                        class="list-group-item {{isStepActive($audit->audit_steps, $index) ? 'active' : 'disabled text-muted' }}">
                                                        @if (isStepActive($audit->audit_steps, $index))
                                                            <a href=""
                                                                class="text-decoration-none text-white">
                                                                {{ $audit_step->step_no }} -
                                                                {{ $audit_step->audit_step_info->title }}
                                                            </a>
                                                        @else
                                                            <span>
                                                                {{ $audit_step->step_no }} -
                                                                {{ $audit_step->audit_step_info->title }}
                                                            </span>
                                                        @endif
                                                    </li>
                                                </ul>
                                            @endforeach
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
