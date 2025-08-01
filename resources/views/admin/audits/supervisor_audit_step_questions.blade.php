@extends('admin.layouts.app')
@section('title', 'Review Step')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Review Step</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.supervisor-audit-steps', encrypt_decrypt($step_info->audit_id, 'encrypt')) }}"
                        class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-arrow-circle-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <th>Audit No.</th>
                                    <td>:</td>
                                    <td>{{ $step_info->audit_info->audit_number ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Organization</th>
                                    <td>:</td>
                                    <td>{{ $step_info->audit_info->organization->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Step No.</th>
                                    <td>:</td>
                                    <td>{{ $step_info->audit_step_info->short_title ?? '' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <th>Title</th>
                                    <td>:</td>
                                    <td>{{ $step_info->audit_info->title ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Financial Year</th>
                                    <td>:</td>
                                    <td>{{ $step_info->audit_info->financial_year->financial_year ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Step</th>
                                    <td>:</td>
                                    <td>{{ $step_info->audit_step_info->title ?? '' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <th class="width-20">Returned/Rejected For</th>
                                    <td>:</td>
                                    <td>
                                        @if ($step_info->status === 'returned')
                                            {{ $step_info->returned_for ?? 'N/A' }}
                                        @elseif($step_info->status === 'rejected')
                                            {{ $step_info->rejected_for ?? 'N/A' }}
                                        @else
                                            {{ 'N/A' }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <span>Review Step as - </span>
                    <div class="btn-group btn-group-sm">

                        @if ($step_info->status !== 'draft')
                            @if ($step_info->status !== 'approved')
                                @if ($step_info->status !== 'rejected')
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#reject-for-modal"
                                        class="btn btn-danger">
                                        Reject
                                    </a>
                                @endif
                                @if ($step_info->status !== 'returned')
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#return-for-modal"
                                        class="btn btn-warning">
                                        Send Back
                                    </a>
                                @endif
                                {{-- @if ($step_info->status !== 'reviewed')
                                <a href="{{ route('admin.supervised-step-status', ['step_id' => encrypt_decrypt($step_info->id, 'encrypt'), 'status' => 'reviewed']) }}"
                                    class="btn btn-primary">
                                    Reviewed
                                </a>
                            @endif --}}
                                @if ($step_info->status !== 'approved')
                                    <a href="{{ route('admin.supervised-step-status', ['step_id' => encrypt_decrypt($step_info->id, 'encrypt'), 'status' => 'approved']) }}"
                                        class="btn btn-success">
                                        Approved
                                    </a>
                                @endif
                            @else
                                <span>Approved</span>
                            @endif
                        @else
                            <span>Waiting for auditor submit</span>
                        @endif

                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-responsive-md w-100">
                            <colgroup>
                                <col class="width-5">
                                <col class="width-30">
                                <col class="width-20">
                                <col class="width-30">
                                <col class="width-10">
                            </colgroup>
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Sl.no</th>
                                    <th>Question/Particulars</th>
                                    <th>Closed-Ended</th>
                                    <th>Text Answer</th>
                                    <th class="text-center">Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($step_info->audit_step_questions as $index => $step_question)
                                    <tr>
                                        <td class="text-center">{{ $step_question->sorting_serial ?? '' }}</td>
                                        <td>{{ $step_question->question->question ?? 'Question ?' }}</td>
                                        <td>{{ strtoupper($step_question->closed_ended_answer) }}</td>
                                        <td>{{ $step_question->text_answer ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            @if ($step_question->documents && file_exists($step_question->documents))
                                                <a target="_blank" href="{{ asset($step_question->documents) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fa fa-file"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <x-no-data-found></x-no-data-found>
                                @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="return-for-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Back Audit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.supervisor-return-audit', $step_info->id) }}" id="return-audit-form"
                        method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="col-form-label">Returned For (5000 chars) {!! starSign() !!}</label>
                            <textarea name="returned_for" cols="30" rows="10" placeholder="Returned For"
                                class="form-control returned-form-input" maxlength="5000" required></textarea>
                            <span id="return_for_error" class="text-danger font-weight-500"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary dynamic-submit-btn"
                        data-form-id="return-audit-form">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reject-for-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reject Audit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.supervisor-reject-audit', $step_info->id) }}" id="reject-audit-form"
                        method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="col-12 mb-3">
                            <label class="col-form-label">Rejected For (5000 chars) {!! starSign() !!}</label>
                            <textarea name="rejected_for" cols="30" rows="10" placeholder="Rejected For"
                                class="form-control rejected-form-input" maxlength="5000" required></textarea>
                            <span id="reject_for_error" class="text-danger font-weight-500"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary dynamic-submit-btn"
                        data-form-id="reject-audit-form">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/supervisor_review_audit.js') }}"></script>
@endpush
