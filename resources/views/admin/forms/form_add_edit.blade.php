@extends('admin.layouts.app')
@section('title', 'Form Add/Edit')
@push('css')
    <style>
        .save-template {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ isset($form) ? 'Edit Form' : 'Create Form' }}</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.form-builders.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-arrow-circle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ $route }}" class="needs-validation" novalidate>
                        @csrf
                        @if ($form)
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Form Title {!! starSign() !!}</label>
                                    <input type="text" name="title" value="{{ $form->title ?? '' }}"
                                        class="form-control {{ hasError('title') }}" placeholder="Form Title" required>
                                    @error('title')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Audit Step {!! starSign() !!}</label>
                                    <select name="audit_step" class="form-control select2 required-checker" id="audit_step"
                                        required>
                                        <option value="">Select Audit Step </option>
                                        @foreach ($audit_steps as $audit_step)
                                            <option value="{{ $audit_step->id }}"
                                                {{ isset($form) && $form->audit_step_id == $audit_step->id ? 'selected' : '' }}>
                                                {{ $audit_step->short_title }} : {{ $audit_step->title ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('audit_step')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Question {!! starSign() !!}</label>
                                    <select name="question" id="question" class="form-control select2 required-checker" data-old-value="{{ $form->question_id ?? '' }}" required >
                                        <option value="">Select Question</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div id="fb-editor"></div>
                                <input type="hidden" name="form_json" id="form_json">
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary mt-3 float-end">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- FormBuilder library -->
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>

    <!-- Pass PHP form data to JS -->
    <script>
        window.formData = @json($form->form_json ?? []);
    </script>

    <!-- Your external JS -->
    <script src="{{ asset('assets/admin/js/custom/dynamic_form_builder.js') }}"></script>
@endpush
