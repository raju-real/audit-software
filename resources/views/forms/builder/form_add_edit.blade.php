@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3>{{ isset($form) ? 'Edit Form' : 'Create Form' }}</h3>

    <form id="form-builder" method="POST" 
          action="{{ isset($form) ? route('admin.form-builders.update', $form->id) : route('admin.form-builders.store') }}">
        @csrf
        @if(isset($form))
            @method('PUT')
        @endif

        <div class="mb-3">
            <input type="text" name="title" class="form-control" 
                   value="{{ old('title', $form->title ?? '') }}" placeholder="Form title" required>
        </div>

        <div class="mb-3">
            <textarea name="description" class="form-control" placeholder="Form description">{{ old('description', $form->description ?? '') }}</textarea>
        </div>

        {{-- ===== Field Add Section ===== --}}
        <div class="row">
            <div class="col-md-4">
                {{-- ⚡ NO nested form here --}}
                <div id="add-field-box">
                    <div class="mb-2">
                        <label>Field Title</label>
                        <input type="text" id="field-label" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Type</label>
                        <select id="field-type" class="form-control">
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

                    <div class="mb-2" id="options-wrapper" style="display:none;">
                        <label>Options (comma separated)</label>
                        <input type="text" id="field-options" class="form-control">
                    </div>

                    <div class="mb-2" id="multiple-wrapper" style="display:none;">
                        <label><input type="checkbox" id="field-multiple"> Allow multiple files</label>
                    </div>

                    <div class="mb-2" id="paragraph-wrapper" style="display:none;">
                        <label>Paragraph Text</label>
                        <textarea id="field-paragraph" class="form-control"></textarea>
                    </div>

                    <div class="mb-2">
                        <label><input type="checkbox" id="field-required"> Required</label>
                    </div>

                    <button type="button" id="add-field-btn" class="btn btn-success w-100">+ Add Field</button>
                </div>
            </div>

            <div class="col-md-8">
                <h5>Form Fields</h5>
                <div id="builder-area" class="border p-3 rounded bg-light">
                    <!-- Fields will render here -->
                </div>
                <input type="hidden" id="fields-json" name="fields">
            </div>
        </div>
        {{-- ===== End Field Add Section ===== --}}

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                {{ isset($form) ? 'Update Form' : 'Save Form' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('js')
    @if(isset($form))
        <script>
            // Pass PHP fields into JS
            window.existingFields = @json($form->fields);
        </script>
    @endif
    <script src="{{ asset('assets/admin/js/custom/form_builder_create.js') }}"></script>
@endpush
