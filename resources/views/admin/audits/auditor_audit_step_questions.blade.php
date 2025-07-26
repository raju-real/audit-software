@extends('admin.layouts.app')
@section('title', 'Submit Answer')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Submit Answer</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.auditor-audit-steps', encrypt_decrypt($step_info->audit_id, 'encrypt')) }}"
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
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form action="{{ route('admin.submit-answer', encrypt_decrypt($step_info->id, 'encrypt')) }}"
                            enctype="multipart/form-data" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')
                            <table class="table table-bordered table-striped table-responsive-md w-100">
                                <colgroup>
                                    <col class="width-5">
                                    <col class="width-30">
                                    <col class="width-20">
                                    <col class="width-30">
                                    <col class="width-20">
                                </colgroup>
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">Sl.no</th>
                                        <th>Question/Particulars</th>
                                        <th>Closed-Ended</th>
                                        <th>Text Answer</th>
                                        <th>Attachment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($step_info->audit_step_questions as $index => $step_question)
                                        <tr>
                                            <td class="text-center">
                                                <input type="hidden" name="step_question_id[]"
                                                    value="{{ $step_question->id }}" required>
                                                {{ $step_question->sorting_serial ?? '' }}
                                            </td>
                                            <td>{{ $step_question->question->question ?? 'Question ?' }}</td>
                                            {{-- Closed Ended Answer --}}
                                            <td>
                                                <select name="closed_ended_answer[]"
                                                    class="form-select select2-search-disable {{ hasError('closed_ended_answer.' . $index) }}" required>
                                                    @foreach (getClosedEnded() as $status)
                                                        <option value="{{ $status->value }}"
                                                            {{ (old('closed_ended_answer.' . $index) ?? $step_question->closed_ended_answer) == $status->value ? 'selected' : '' }}>
                                                            {{ $status->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('closed_ended_answer.' . $index)
                                                    {!! displayError($message) !!}
                                                @enderror
                                            </td>

                                            {{-- Text Answer --}}
                                            <td>
                                                <textarea name="text_answer[]" class="form-control" placeholder="Answer" {{ $step_question->question->is_text_answer_required == 'yes' ? 'required' : '' }}>{{ old('text_answer.' . $index) ?? ($step_question->text_answer ?? '') }}</textarea>
                                            </td>

                                            {{-- File Upload --}}
                                            <td>
                                                <input type="file" name="documents[]" class="form-control"
                                                    accept=".jpg,.jpeg,.png,.pdf" {{ $step_question->question->is_text_document_required == 'yes' ? 'required' : '' }}>
                                                @error('documents.' . $index)
                                                    {!! displayError($message) !!}
                                                @enderror
                                                {{-- @error('documents')
                                                    {!! displayError($message) !!}
                                                @enderror --}}
                                            </td>
                                        </tr>
                                    @empty
                                        <x-no-data-found></x-no-data-found>
                                    @endforelse

                                </tbody>
                            </table>

                            <div>
                                <x-submit-button></x-submit-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
