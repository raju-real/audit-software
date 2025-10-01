@extends('admin.layouts.app')
@section('title', $form->title ?? 'Form Submission Details')

@push('css')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: none !important;
            }

            body {
                background-color: #fff !important;
            }

            .content-page {
                padding: 0 !important;
            }

            .signature-image {
                border: 1px dashed #ccc;
            }
        }

        /* Card Layout for Fields */
        .field-card {
            border: 1px solid #e3e6ea;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease-in-out;
        }

        .field-card:hover {
            transform: translateY(-2px);
        }

        .data-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .data-value {
            color: #212529;
            font-size: 0.95rem;
        }

        .file-preview img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 0.5rem;
        }

        .file-link {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            border: 1px solid #e3e6ea;
            background: #f8f9fa;
            font-size: 0.9rem;
            text-decoration: none;
            color: #0056b3;
            transition: background 0.2s ease-in-out;
            margin-bottom: 0.5rem;
        }

        .file-link:hover {
            background: #e9ecef;
        }

        .signature-image {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 4px;
            background: #f8f9fa;
        }

        .badge-multi {
            display: inline-block;
            margin: 0 0.25rem 0.25rem 0;
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
            background: #f1f3f5;
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- PDF Download Button -->
                    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
                        <h4 class="card-title mb-0">{{ $form->title ?? 'Dynamic Form' }} Submission</h4>
                        <a href="{{ route('admin.download-dynamic-form', $form->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-download me-1"></i> Download PDF
                        </a>
                    </div>

                    <!-- Submission Fields -->
                    <div class="row">
                        @foreach ($formStructure as $field)
                            @php
                                $name = $field->name ?? null;
                                $label = $field->label ?? ucfirst($name);
                                $type = $field->type ?? 'text';
                                $value = $responses[$name] ?? null;
                            @endphp

                            <div class="col-md-12 col-lg-12">
                                <div class="field-card">
                                    @if ($type !== 'paragraph')
                                        <p class="data-label">{{ $label }}</p>
                                    @endif


                                    {{-- File Handling --}}
                                    @if ($type === 'file' && $value)
                                        @php
                                            $mimeType = \File::mimeType($value);
                                            $isImage = Str::startsWith($mimeType, 'image/');
                                            $isPdf = Str::endsWith($mimeType, 'pdf');
                                        @endphp

                                        <div class="data-value file-preview">
                                            @if ($isImage)
                                                <a href="{{ asset($value) }}" target="_blank">
                                                    <img src="{{ asset($value) }}" alt="Uploaded File">
                                                </a>
                                            @elseif ($isPdf)
                                                <embed src="{{ asset($value) }}" type="application/pdf" width="100%"
                                                    height="180px" />
                                                <div class="mt-2">
                                                    <a href="{{ asset($value) }}" target="_blank" class="file-link">
                                                        <i class="mdi mdi-file-pdf-box text-danger me-1"></i> View PDF
                                                    </a>
                                                </div>
                                            @else
                                                <a href="{{ asset($value) }}" target="_blank" class="file-link">
                                                    <i class="mdi mdi-file-document-outline me-1"></i>
                                                    {{ basename($value) }}
                                                </a>
                                            @endif
                                        </div>

                                        {{-- Signature --}}
                                    @elseif ($type === 'signature' && $value)
                                        <div class="data-value">
                                            <img class="signature-image" src="{{ asset($value) }}" alt="User Signature">
                                        </div>
                                    @elseif ($type === 'paragraph' && $label)
                                        <div class="data-value">
                                            {!! html_entity_decode(strip_tags($label)) !!}
                                        </div>

                                        {{-- Multi-select / Checkbox --}}
                                    @elseif (is_array($value))
                                        <div class="data-value">
                                            @foreach ($value as $val)
                                                <span class="badge-multi">{{ $val }}</span>
                                            @endforeach
                                        </div>

                                        {{-- Text / Textarea / HTML --}}
                                    @else
                                        <div class="data-value">
                                            {!! html_entity_decode(strip_tags($value)) !!}
                                        </div>
                                    @endif


                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
