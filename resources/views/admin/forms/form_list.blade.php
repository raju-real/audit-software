@extends('admin.layouts.app')
@section('title', 'Form List List')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Form List List</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.dynamic-forms.create') }}" class="btn btn-sm btn-primary">
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
                                    <th>Audit Step</th>
                                    <th>Question</th>
                                    <th>Title</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="sort_section">
                                @forelse($forms as $form)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td>{{ $form->audit_step->short_title }}: {{ $form->audit_step->title }}</td>
                                        <td>{{ $form->question->question ?? '' }}</td>
                                        <td data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $form->title }}">
                                            {{ textLimit($form->title, 30) }}</td>
                                        
                                        <td class="text-center">
                                            <a {!! tooltip("Submit") !!}
                                                href="{{ route('admin.submit-dynamic-form', $form->id) }}"
                                                class="btn btn-sm btn-soft-info"><i class="fa fa-check"></i></a>

                                            <a {!! tooltip("Show Submitted Form") !!}
                                                href="{{ route('admin.dynamic-forms.show', $form->id) }}"
                                                class="btn btn-sm btn-soft-info"><i class="fa fa-eye"></i></a>

                                            <a {!! tooltip("Edit") !!}
                                                href="{{ route('admin.dynamic-forms.edit', $form->id) }}"
                                                class="btn btn-sm btn-soft-success"><i class="fa fa-edit"></i></a>

                                            <a {!! tooltip("Delete Form") !!}
                                                class="btn btn-sm btn-soft-danger delete-data"
                                                data-id="{{ 'delete-form-' . $form->id }}" href="javascript:void(0);">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <form id="delete-form-{{ $form->id }}"
                                                action="{{ route('admin.dynamic-forms.destroy', $form->id) }}"
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
@endpush
