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
            margin-top: 10px;
        }

        textarea.readonly-paragraph {
            background: #f8f9fa;
            border: 1px solid #ddd;
            width: 100%;
            resize: none;
        }
    </style>
@endpush

@section('content')
<div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ $form->title ?? "Form" }}</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.dynamic-forms.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-arrow-circle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.dynamic-form-submit', $form->id) }}" class="needs-validation"
                        novalidate enctype="multipart/form-data">
                        @csrf

                        {{-- Placeholder for formRender --}}
                        <div id="rendered-form"></div>

                        <button type="submit" class="btn btn-primary mt-3 float-end">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>

    <script>
        window.formData = @json($form->form_json);
        window.responses = @json($responses ?? []);
    </script>
    <script src="{{ asset('assets/admin/js/custom/submit_render.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom/signature_pad.js') }}"></script>
@endpush
