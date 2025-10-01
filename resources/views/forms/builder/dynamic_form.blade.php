@extends('admin.layouts.app')
@section('title', 'Form Add/Edit')
@push('css')
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Form</h4>
                <div class="page-title-right">
                    <a href="" class="btn btn-sm btn-outline-primary">
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
                    <div id="fb-editor"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
<script>
    jQuery(function($) {
        var options = { disableFields: ['autocomplete'] };
        var formBuilder = $('#fb-editor').formBuilder(options);
        
        $('#saveForm').click(function() {
            let formData = formBuilder.actions.getData('json');
            $.post("{{ route('admin.save-dynamic-form') }}", {
                _token: "{{ csrf_token() }}",
                title: $('#formTitle').val(),
                form_json: formData
            });
        });
    });
</script>
{{-- <div id="render-form"></div>
<script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
<script>
    let formData = @json($form->form_json);
    $('#render-form').formRender({ formData });
</script> --}}
@endpush
