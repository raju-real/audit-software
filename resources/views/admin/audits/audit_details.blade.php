@extends('admin.layouts.app')
@section('title', 'Audit Details')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Audit Details</h4>
                <div class="page-title-right">
                    <a href="{{ route('admin.audits.index') }}" class="btn btn-sm btn-outline-primary">
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
                                    <td>{{ $audit->audit_number ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Organization</th>
                                    <td>:</td>
                                    <td>{{ $audit->organization->name ?? '' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <th>Title</th>
                                    <td>:</td>
                                    <td>{{ $audit->title ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Financial Year</th>
                                    <td>:</td>
                                    <td>{{ $audit->financial_year->financial_year ?? '' }}</td>
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
            @foreach ($audit->audit_steps as $audit_step)
                <div class="card">
                    <div class="card-body">
                        <div class="card-header bg-secondary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Step {{ $audit_step->step_no }} :
                                    {{ $audit_step->audit_step_info->title ?? '' }}</span>
                                <span><b>{{ ucFirst($audit_step->status) ?? '' }}</b></span>
                            </div>
                        </div>

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
                                        <th>Question</th>
                                        <th>Closed-Ended</th>
                                        <th>Text Answer</th>
                                        <th class="text-center">Attachment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($audit_step->audit_step_questions as $index => $step_question)
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
            @endforeach
        </div>
    </div>
@endsection
