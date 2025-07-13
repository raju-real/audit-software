@extends('admin.layouts.app')
@section('title','Staff List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Staff List</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.staffs.create') }}" class="btn btn-sm btn-primary">
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
                                <th class="text-center">Sl. no.</th>
                                <th>Designation</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th class="text-center">Active Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($staffs as $staff)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td>{{ $staff->designation->name ?? '' }}</td>
                                    <td>{{ $staff->name ?? '' }}</td>
                                    <td>{{ $staff->email ?? '' }}</td>
                                    <td>{{ $staff->mobile ?? '' }}</td>
                                    <td class="text-center">
                                        <input type="checkbox" id="staff-{{ $loop->index + 1 }}" class="staff-status"
                                               data-id="{{ $staff->id }}"
                                               switch="bool" {{ isActive($staff->status) ? 'checked' : '' }} />
                                        <label class="custom-label-margin" for="staff-{{ $loop->index + 1 }}" data-on-label="Yes"
                                               data-off-label="No"></label>
                                    </td>
                                    <td class="text-center">
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="View/Edit"
                                           href="{{ route('admin.staffs.edit',$staff->id) }}"
                                           class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i></a>
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
    <script src="{{ asset('assets/admin/js/custom/staff_list.js') }}"></script>
@endpush
