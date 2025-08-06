@extends('admin.layouts.app')
@section('title', 'Balance Sheet')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/pages/balance_sheet.css') }}">
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
                        <div class="d-none" id="preview-wrapper" style="width: 100%; overflow-x: auto;">
                            <div id="html-preview"></div>
                            <br>
                        </div>

                        <div>
                            <x-submit-button></x-submit-button>
                        </div>
                    </form>

                    {{-- Divider --}}
                    <hr>

                    {{-- Display Saved Balance Sheet --}}
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
                        <div class="table-container" style="width: 100%;">
                            {!! $audit->balance_sheet->balance_sheet ?? '<p class="text-muted">No balance sheet uploaded.</p>' !!}
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
