@extends('admin.layouts.app')
@section('title', 'Form Add/Edit')
@push('css')
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
                    <form action="{{ $route }}" method="POST" id="prevent-form" novalidate class="needs-validation">
                        @csrf
                        @if (isset($form))
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Form Title {!! starSign() !!}</label>
                                    <input type="text" name="title" value="{{ $form->title ?? '' }}"
                                        class="form-control" placeholder="Form Title" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control {{ hasError('description') }}" placeholder="Description">{{ old('description') ?? ($financial_year->description ?? '') }}</textarea>
                                    @error('description')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Field Title {!! starSign() !!}</label>
                                        <input type="text" id="field-label" class="form-control"
                                            placeholder="Field Title">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Field Type {!! starSign() !!}</label>
                                        <select id="field-type" class="form-select select2-search-disable">
                                            <option value="text">Text</option>
                                            <option value="number">Number</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="select">Select</option>
                                            <option value="checkbox">Checkbox</option>
                                            <option value="radio">Radio</option>
                                            <option value="file">File</option>
                                            <option value="signature">Signature</option>
                                            <option value="paragraph">Paragraph</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3" id="options-wrapper" style="display:none;">
                                        <label>Options (Comma Separated) {!! starSign() !!}</label>
                                        <input type="text" id="field-options" class="form-control" placeholder="Option1,Option2,Option3">
                                    </div>

                                    <div class="mb-3" id="multiple-wrapper" style="display:none;">
                                        <label><input type="checkbox" id="field-multiple"> Allow multiple files</label>
                                    </div>

                                    <div class="mb-3" id="paragraph-wrapper" style="display:none;">
                                        <label>Paragraph Text {!! starSign() !!}</label>
                                        <textarea id="field-paragraph" class="form-control" placeholder="Paragraph Text"></textarea>
                                    </div>

                                    <div class="mb-3 mt-2">
                                        <label><input type="checkbox" id="field-required"> Is Required ?</label>
                                    </div>

                                    <button type="button" id="add-field-btn" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Add Field</button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5>Form Fields</h5>
                                <div id="builder-area" class="border p-3 rounded bg-light">
                                </div>
                                <input type="hidden" id="fields-json" name="fields">
                            </div>
                        </div>

                        <div>
                            <x-submit-button></x-submit-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @if (isset($form))
        <script>
            // Pass PHP fields into JS
            window.existingFields = @json($form->fields);
        </script>
    @endif
    <script src="{{ asset('assets/admin/js/custom/form_builder_create.js') }}"></script>
@endpush
