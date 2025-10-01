@extends('admin.layouts.app')
@section('title', 'Form Add/Edit')
@push('css')
<link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet"/>
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
                    <form method="POST"
                        action="{{ $form ? route('admin.update-dynamic-forms', $form->id) : route('admin.dynamic-forms.store') }}">
                        @csrf
                        @if ($form)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label>Form Title</label>
                            <input type="text" name="title" value="{{ $form->title ?? '' }}" class="form-control"
                                required>
                        </div>

                        <div id="gjs" style="border: 2px solid #444; min-height: 500px;">
                            {!! $form->form_json ?? '' !!}
                        </div>
                        <input type="hidden" name="form_json" id="form_json">

                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/grapesjs"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    var editor = grapesjs.init({
        container: '#gjs',
        fromElement: true,
        height: '500px',
        storageManager: false,
        plugins: [],
        pluginsOpts: {}
    });

    // Add custom form input blocks
    var blockManager = editor.BlockManager;
    blockManager.add('input-text', {
        label: 'Text',
        content: '<input type="text" name="text_field" placeholder="Enter text"/>',
        category: 'Form Inputs'
    });
    blockManager.add('input-number', {
        label: 'Number',
        content: '<input type="number" name="number_field" placeholder="Enter number"/>',
        category: 'Form Inputs'
    });
    blockManager.add('input-checkbox', {
        label: 'Checkbox',
        content: '<label><input type="checkbox" name="checkbox_field"/> Checkbox</label>',
        category: 'Form Inputs'
    });
    blockManager.add('input-radio', {
        label: 'Radio',
        content: '<label><input type="radio" name="radio_field"/> Option</label>',
        category: 'Form Inputs'
    });
    blockManager.add('input-select', {
        label: 'Select',
        content: '<select name="select_field"><option>Option 1</option><option>Option 2</option></select>',
        category: 'Form Inputs'
    });
    blockManager.add('input-file', {
        label: 'File Upload',
        content: '<input type="file" name="file_field"/>',
        category: 'Form Inputs'
    });
    blockManager.add('textarea', {
        label: 'Textarea',
        content: '<textarea name="textarea_field" placeholder="Enter text"></textarea>',
        category: 'Form Inputs'
    });

    // On submit → save HTML in hidden input
    document.querySelector('form').addEventListener('submit', function () {
        document.getElementById('form_json').value = editor.getHtml();
    });
});
</script>
@endpush
