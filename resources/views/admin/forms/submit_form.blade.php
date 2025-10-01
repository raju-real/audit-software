@extends('admin.layouts.app')
@section('title', $form->title ?? 'Form')
@push('css')
    <style>
        .signature-pad {
            border: 1px solid #ccc;
            width: 100%;
            height: 150px;
        }
        .signature-wrapper {
            position: relative;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4>{{ $form->title ?? 'Dynamic Form' }}</h4>
                <form method="POST" action="{{ route('admin.dynamic-form-submit', $form->id) }}" class="needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @foreach(json_decode($form->form_json) as $field)
                            <div class="{{ $field->column ?? 'col-md-12' }} mb-3">
                                {!! formBuilderRender($field) !!}
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
<script src="{{ asset('assets/admin/js/custom/dynamic_form_submit.js') }}"></script>
@endpush
