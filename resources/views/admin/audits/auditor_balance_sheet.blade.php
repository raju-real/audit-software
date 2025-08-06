@extends('admin.layouts.app')
@section('title', 'Balance Sheet')

@push('css')
    <style>
        /* Optional style to improve Excel table look */
        .table-container table {
            width: 100% !important;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table-container table,
        .table-container th,
        .table-container td {
            border: 1px solid #dee2e6;
        }

        .table-container th,
        .table-container td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .table-container tr:nth-child(even) {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Balance Sheet</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Upload Form --}}
                    <form action="{{ route('admin.auditor-upload-balance-sheet', $audit->id) }}" method="POST"
                        id="prevent-form" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-flex align-items-center justify-content-between">
                                        <span>Balance Sheet (xls, xlsx) {!! starSign() !!}</span>
                                        <button type="button" id="preview-trigger"
                                            class="btn btn-sm btn-outline-primary ms-2 d-none">Preview</button>
                                    </label>
                                    <input type="file" name="balance_sheet" id="balance_sheet_input"
                                        class="form-control {{ hasError('balance_sheet') }}" accept=".xls, .xlsx">
                                    @error('balance_sheet')
                                        {!! displayError($message) !!}
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div id="excel-preview" class="table-responsive mt-4 border rounded shadow-sm p-3 bg-light"
                                    style="display: none;">
                                    <h5 class="mb-3">Excel Preview:</h5>
                                    <div id="excel-table-container"></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <x-submit-button></x-submit-button>
                        </div>
                    </form>

                    {{-- Divider --}}
                    <hr>

                    {{-- Display Excel HTML --}}
                    <table class="table table-striped">
                        <tr>
                            <th>Last Updated At</th>
                            <td>:</td>
                            <td>{{ date('d M, y', strtotime($audit->balance_sheet->created_at)) }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated By</th>
                            <td>:</td>
                            <td>{{ $audit->balance_sheet->user->name ?? '' }}</td>
                        </tr>
                    </table>
                    <div class="table-responsive border rounded shadow-sm p-3 bg-white"
                        style="max-width: 100%; overflow-x: auto;">
                        <div class="table-container" style="min-width: 100%;">


                            {!! $audit->balance_sheet->balance_sheet ?? '<p class="text-muted">No balance sheet uploaded.</p>' !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectedFile = null;

            // Show preview button when file is selected
            $('#balance_sheet_input').on('change', function(e) {
                const file = e.target.files[0];
                selectedFile = file;

                // Hide preview if no file
                if (!file) {
                    $('#preview-trigger').addClass('d-none');
                    $('#excel-preview').hide();
                    $('#excel-table-container').html('');
                    return;
                }

                $('#preview-trigger').removeClass('d-none');
                $('#excel-preview').hide();
                $('#excel-table-container').html('');
            });

            // Preview the selected Excel file
            $('#preview-trigger').on('click', function() {
                if (!selectedFile) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: 'array'
                    });

                    let html = '';
                    workbook.SheetNames.forEach(function(sheetName) {
                        const worksheet = workbook.Sheets[sheetName];
                        html += `<h6 class="text-primary">${sheetName}</h6>`;
                        html += XLSX.utils.sheet_to_html(worksheet);
                    });

                    $('#excel-table-container').html(html);
                    $('#excel-preview').fadeIn();
                };
                reader.readAsArrayBuffer(selectedFile);
            });
        });
    </script>
@endpush
