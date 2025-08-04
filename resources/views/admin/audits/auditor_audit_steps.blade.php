@extends('admin.layouts.app')
@section('title', $audit->title ?? 'Audit')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Steps of
                    :- {{ $audit->audit_no }} {{ $audit->title ?? 'Audit Steps' }}</h4>
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
                                    <th class="text-center">Step</th>
                                    <th>Title</th>
                                    <th>ISA Reference</th>
                                    <th>Current Status</th>
                                    <th>Audit By</th>
                                    <th>Reviewed By</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($steps as $index => $step)
                                    <tr>
                                        <td class="text-center">{{ $step->audit_step_info->short_title ?? '' }}</td>
                                        <td>{{ $step->audit_step_info->title ?? '' }}</td>
                                        <td>{{ $step->audit_step_info->isa_reference ?? '' }}</td>
                                        <td>{{ ucFirst($step->status) ?? '' }}</td>
                                        <td>{{ $step->audit_user->name ?? '' }}</td>
                                        <td>{{ $step->supervisor_user->name ?? '' }}</td>
                                        <td class="text-center">
                                            @if (isStepActive($audit->audit_steps, $index))
                                                @if ($step->status !== 'draft')
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Show Details"
                                                        href="{{ route('admin.auditor-step-details', encrypt_decrypt($step->id, 'encrypt')) }}"
                                                        class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                                @endif
                                                @if ($step->status === 'draft' || $step->status === 'returned')
                                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Start Audit"
                                                        href="{{ route('admin.auditor-step-questions', encrypt_decrypt($step->id, 'encrypt')) }}"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"
                                                            aria-hidden="true"></i></a>

                                                    <a data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Preview and Final Submit"
                                                        href="{{ route('admin.auditor-preview-questions', encrypt_decrypt($step->id, 'encrypt')) }}"
                                                        class="btn btn-sm btn-success"><i
                                                            class="fa fa-check-square"></i></a>
                                                @endif
                                            @else
                                                <span class="btn btn-sm btn-soft-warning" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Waiting for previous approval.">
                                                    <i class="fa fa-arrow-up"></i>
                                                </span>
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
