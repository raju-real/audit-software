@extends('admin.layouts.app')
@section('title',$audit_step->title .' Question List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $audit_step->short_title . ': '.$audit_step->title .' Question List' }}</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.audit-steps.create') }}" class="btn btn-sm btn-primary">
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
                                <th class="text-center">Step no.</th>
                                <th>Title</th>
                                <th>ISA Reference</th>
                                <th class="text-center">Question Count</th>
                                <th class="text-center">Active Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody class="sort_section">
                            @forelse($questions as $step)
                                <tr>
                                    <td class="text-center sorting-serial handle">{{ $step->step_no }}</td>
                                    <td class="handle">{{ $step->title ?? '' }}</td>
                                    <td class="handle">{{ textLimit($step->isa_reference) ?? '' }}</td>
                                    <td class="text-center handle">{{ $step?->questions?->count() ?? 0 }}</td>
                                    <td class="text-center">
                                        <input type="checkbox" id="step-{{ $loop->index + 1 }}" class="step-status"
                                               data-id="{{ $step->id }}"
                                               switch="bool" {{ isActive($step->status) ? 'checked' : '' }} />
                                        <label for="step-{{ $loop->index + 1 }}" data-on-label="Yes"
                                               data-off-label="No"></label>
                                    </td>
                                    <td class="text-center">
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                           href="{{ route('admin.audit-steps.edit',$step->slug) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i></a>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                           class="btn btn-sm btn-soft-danger delete-data"
                                           data-id="{{ 'delete-step-'.$step->id }}"
                                           href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-step-{{ $step->id }}"
                                              action="{{ route('admin.audit-steps.destroy',$step->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
    <script src="{{ asset('assets/admin/js/custom/question_list.js') }}"></script>
@endpush
