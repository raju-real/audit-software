@extends('admin.layouts.app')
@section('title', 'Balance Sheet')

@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/pages/balance_sheet.css') }}"> --}}
    <style>
        .table-container table {
            width: 100% !important;
            border-collapse: collapse;
            font-size: 14px;
            table-layout: fixed;
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
            word-wrap: break-word;
        }

        .table-container tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* New styles for preview width fix */
        #preview-wrapper {
            width: 100% !important;
            /* overflow-x: auto; */
        }

        #html-preview table {
            width: 100% !important;
            table-layout: fixed;
        }

        .custom-preview-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            font-size: 12px;
        }

        .custom-preview-table th,
        .custom-preview-table td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            border: 1px solid #dee2e6;
        }

        .custom-preview-table tr:nth-child(even) {
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
                    @if ($audit->balance_sheet == null)
                        {{-- Upload Form --}}
                        <form action="{{ route('admin.auditor-upload-balance-sheet', $audit->id) }}" method="POST"
                            id="prevent-form" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center justify-content-between">
                                            <span>Balance Sheet (xls, xlsx) {!! starSign() !!}</span>
                                            <div class="position-relative" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Choose a file first to preview">
                                                <button type="button" id="preview-trigger"
                                                    class="btn btn-sm btn-outline-primary" disabled>
                                                    Preview
                                                </button>
                                            </div>
                                        </label>

                                        <input type="file" name="balance_sheet" id="balance_sheet_input"
                                            class="form-control {{ hasError('balance_sheet') }}" accept=".xls, .xlsx">
                                        @error('balance_sheet')
                                            {!! displayError($message) !!}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Preview Section --}}
                            <div class="d-none" id="preview-wrapper" style="max-width: 100%;min-width: 100%">
                                <div id="html-preview" style="width: 100%"></div>
                                <br>
                            </div>

                            <div>
                                <x-submit-button></x-submit-button>
                            </div>
                        </form>

                        {{-- Divider --}}
                        <hr>
                    @endif
                    {{-- Display Saved Balance Sheet --}}
                    @if (isset($audit->balance_sheet))
                        <table class="table table-striped">
                            <tr>
                                <th>Action</th>
                                <td>:</td>
                                <td>
                                    {{-- <a data-bs-toggle="tooltip" data-bs-placement="top" title="Download Balance Sheet"
                                           href="{{ route('admin.download-balance-sheet', $audit->id) }}"
                                           class="btn btn-sm btn-soft-success" download=""><i class="fa fa-download"></i></a> --}}
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
                                        class="btn btn-sm btn-soft-danger delete-data"
                                        data-id="{{ 'delete-auditor-balance-sheet-' . $audit->balance_sheet->id }}"
                                        href="javascript:void(0);">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <form id="delete-auditor-balance-sheet-{{ $audit->balance_sheet->id }}"
                                        action="{{ route('admin.auditor-delete-balance-sheet', $audit->balance_sheet->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <th>Last Updated At</th>
                                <td>:</td>
                                <td>{{ date('d M, y', strtotime($audit->balance_sheet->created_at)) ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated By</th>
                                <td>:</td>
                                <td>{{ $audit->balance_sheet->user->name ?? '' }}</td>
                            </tr>
                        </table>
                    @endif

                    <div class="border rounded shadow-sm bg-white" style="max-width: 100%;">
                        <div class="table-container" style="width: 100%;">
                            {!! $audit->balance_sheet->balance_sheet ?? '<p class="alert alert-danger">No balance sheet uploaded.</p>' !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/auditor_balance_sheet.js') }}"></script>
@endpush
