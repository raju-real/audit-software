@extends('admin.layouts.app')
@section('title','Question Add/Edit')
@push('css') @endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Add/Edit Question/Particulars on {{ $audit_step->short_title }}
                    : {{ $audit_step->title ?? '' }}</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.question-list', $audit_step->slug) }}"
                       class="btn btn-sm btn-outline-primary">
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
                    <form action="{{ $route }}" method="POST" id="prevent-form">
                        <input type="hidden" id="method_mode" value="{{ isset($question) ? 'PUT' : 'POST' }}">
                        <input type="hidden" name="audit_step_id" value="{{ $audit_step->id }}">
                        @error('audit_step_id')
                        <p class="alert alert-danger">{{ $message }}</p>
                        @enderror
                        @csrf
                        @isset($question)
                            @method('PUT')
                        @endisset
                        <div class="row">
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label class="form-label">Question/Particulars {!! starSign() !!}</label>
                                    <input type="text" name="question"
                                           value="{{ old('question') ?? $question->question ?? '' }}"
                                           class="form-control {{ hasError('question') }}"
                                           placeholder="Question/Particulars">
                                    @error('question')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Status {!! starSign() !!}</label>
                                    <select name="status"
                                            class="form-select select2-search-disable {{ hasError('status') }}">
                                        @foreach(getStatus() as $status)
                                            <option
                                                value="{{ $status->value }}" {{ (old('status') === $status->value || (isset($question) && $question->status === $status->value && empty(old('status')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    {!! displayError($message) !!}
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mt-1">
                                <table class="table table-bordered table-striped table-responsive-md w-100">
                                    <colgroup>
                                        <col
                                            class="width-70"> {{-- Adjust this percentage as needed for your titles --}}
                                        <col class="width-30"> {{-- This will be for your select fields --}}
                                    </colgroup>
                                    <thead class="table-light">
                                    <tr>
                                        <td>Requirement Title {!! starSign() !!}</td>
                                        <td>Requirement Status {!! starSign() !!}</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            Is this a closed-ended question (Yes,No or N/A)?
                                            <br>
                                            @error('is_closed_ended')
                                            {!! displayError($message) !!}
                                            @enderror
                                        </td>
                                        <td>
                                            <select name="is_closed_ended" class="form-select select2-search-disable">
                                                @foreach(getSureStatus() as $status)
                                                    <option
                                                        value="{{ $status->value }}" {{ (old('is_closed_ended') === $status->value || (isset($question) && $question->is_closed_ended === $status->value && empty(old('is_closed_ended')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Is answering the closed-ended question mandatory?
                                            <br>
                                            @error('is_boolean_answer_required')
                                            {!! displayError($message) !!}
                                            @enderror
                                        </td>
                                        <td>
                                            <select name="is_boolean_answer_required"
                                                    class="form-select select2-search-disable">
                                                @foreach(getSureStatus() as $status)
                                                    <option
                                                        value="{{ $status->value }}" {{ (old('is_boolean_answer_required') === $status->value || (isset($question) && $question->is_boolean_answer_required === $status->value && empty(old('is_boolean_answer_required')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Does this question need a text answer?
                                            <br>
                                            @error('has_text_answer')
                                            {!! displayError($message) !!}
                                            @enderror</td>
                                        <td>
                                            <select name="has_text_answer"
                                                    class="form-select select2-search-disable">
                                                @foreach(getSureStatus() as $status)
                                                    <option
                                                        value="{{ $status->value }}" {{ (old('has_text_answer') === $status->value || (isset($question) && $question->has_text_answer === $status->value && empty(old('has_text_answer')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Is the text answer mandatory?
                                            <br>
                                            @error('is_text_answer_required')
                                            {!! displayError($message) !!}
                                            @enderror</td>
                                        <td>
                                            <select name="is_text_answer_required"
                                                    class="form-select select2-search-disable">
                                                @foreach(getSureStatus() as $status)
                                                    <option
                                                        value="{{ $status->value }}" {{ (old('is_text_answer_required') === $status->value || (isset($question) && $question->is_text_answer_required === $status->value && empty(old('is_text_answer_required')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Does this question need a document upload?
                                            <br>
                                            @error('has_document')
                                            {!! displayError($message) !!}
                                            @enderror</td>
                                        <td>
                                            <select name="has_document"
                                                    class="form-select select2-search-disable">
                                                @foreach(getSureStatus() as $status)
                                                    <option
                                                        value="{{ $status->value }}" {{ (old('has_document') === $status->value || (isset($question) && $question->has_document === $status->value && empty(old('has_document')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Is the document upload mandatory?
                                            <br>
                                            @error('is_document_required')
                                            {!! displayError($message) !!}
                                            @enderror
                                        </td>
                                        <td>
                                            <select name="is_document_required"
                                                    class="form-select select2-search-disable">
                                                @foreach(getSureStatus() as $status)
                                                    <option
                                                        value="{{ $status->value }}" {{ (old('is_document_required') === $status->value || (isset($question) && $question->is_document_required === $status->value && empty(old('is_document_required')))) ? 'selected' : '' }}>{{ $status->title }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
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

@endpush
