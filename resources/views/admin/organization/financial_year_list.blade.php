@extends('admin.layouts.app')
@section('title','Financial Year List')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Financial Year List</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.financial-years.create') }}" class="btn btn-sm btn-primary">
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
                            <thead>
                            <tr>
                                <th class="text-center">Sl.no</th>
                                <th>Financial Year</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($financial_years as $financial_year)
                                <tr>
                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                    <td>{{ $financial_year->financial_year ?? '' }}</td>
                                    <td>{{ textLimit($financial_year->description,40) ?? '' }}</td>
                                    <td class="text-center">
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="View/Edit" href="{{ route('admin.financial-years.edit',encrypt_decrypt($financial_year->id,'encrypt')) }}"
                                           class="btn btn-sm btn-soft-success" ><i class="fa fa-edit"></i></a>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                           class="btn btn-sm btn-soft-danger delete-data"
                                           data-id="{{ 'delete-financial_year-'.$financial_year->id }}"
                                           href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <form id="delete-financial_year-{{ $financial_year->id }}"
                                              action="{{ route('admin.financial-years.destroy',$financial_year->id) }}"
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
                <div class="d-flex justify-content-center">
                    {!! $financial_years->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js') @endpush
