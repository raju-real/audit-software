<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $form->title ?? 'Form Submission' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #212529;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* PDF Header on Every Page */
        @page {
            margin: 100px 15px 30px 15px;
            /* top, right, bottom, left */
        }

        @page {
            margin: 100px 15px 30px 15px;
            /* top, right, bottom, left */
        }

        .pdf-header {
            position: fixed;
            top: -100px;
            /* same as negative of top margin */
            left: 0;
            right: 0;
            height: 80px;
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .pdf-header .left {
            float: left;
        }

        .pdf-header .right {
            float: right;
            text-align: right;
            font-size: 12px;
            line-height: 1.4;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 3px 3px;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .field-card {
            margin-bottom: 3px;
            padding: 8px 8px;
            background: #fafafa;
            border-radius: 6px;
        }

        .field-label {
            font-weight: 600;
            margin-bottom: 3px;
            color: #495057;
        }

        .field-value {
            font-size: 14px;
            color: #212529;
            white-space: pre-wrap;
            line-height: 1.5;
        }

        .file-preview img,
        .signature-image {
            max-height: 200px;
            max-width: 300px;
            border-radius: 6px;
            margin-top: 5px;
        }

        .file-preview img,
        .regular-image {
            height: 150px;
            max-width: 150px;
            border-radius: 6px;
            margin-top: 5px;
        }

        .badge-multi {
            display: inline-block;
            padding: 2px 6px;
            font-size: 12px;
            background: #e9ecef;
            border-radius: 4px;
            margin: 0 2px 2px 0;
        }

        .field-row {
            display: flex;
            justify-content: flex-start;
            align-items: baseline;
            gap: 10px;
        }

        .field-label-inline {
            font-weight: 600;
            color: #495057;
            white-space: nowrap;
        }

        .field-value-inline {
            color: #212529;
            font-size: 14px;
            line-height: 1.5;
        }


        /* Clear floats */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="pdf-header">
        <table width="100%">
            <tr>
                <td style="width:50%; vertical-align: middle;">
                    <img src="{{ asset(siteSettings()['logo']) }}" alt="Company Logo" style="height:60px;">
                </td>
                <td style="width:50%; text-align:right; font-size:12px; line-height:1.4;">
                    <strong>{{ siteSettings()['company_name'] ?? '' }}</strong><br>
                    <address>{{ siteSettings()['address'] ?? '' }} </address>
                    <p>Email: {{ siteSettings()['company_email'] ?? '' }}</p>
                    <p>Phone: {{ siteSettings()['company_phone'] ?? '' }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="container">
        <h1>{{ $form->title ?? 'Form Submission' }}</h1>

        @foreach ($formStructure as $field)
            @php
                $fieldKey = $field->name ?? null;
                $type = $field->type ?? 'text';
                $label = $field->label ?? ucfirst($fieldKey);
                $value = $responses[$fieldKey] ?? null;
            @endphp

            <div class="field-card">
                {{-- Paragraph Type --}}
                @if ($type === 'paragraph')
                    <div class="field-value">{!! nl2br(e($value ?? strip_tags($label))) !!}</div>

                    {{-- Array (checkboxes / multi-select) --}}
                @elseif (is_array($value) && $type !== 'file')
                    <div class="field-label">{{ $label }}</div>
                    <div class="field-value">
                        @foreach ($value as $v)
                            <span class="badge-multi">{{ $v }}</span>
                        @endforeach
                    </div>

                    {{-- File Upload --}}
                @elseif ($type === 'file' && $value)
                    <div class="field-label">{{ $label }}</div>

                    <div class="data-value file-preview">
                        @php
                            $files = is_array($value) ? $value : [$value]; // Normalize to array
                        @endphp

                        @foreach ($files as $file)
                            @php
                                $mimeType = file_exists($file) ? mime_content_type($file) : null;
                                $isImage = $mimeType && Str::startsWith($mimeType, 'image/');
                                $isPdf = $mimeType && Str::endsWith($mimeType, 'pdf');
                            @endphp

                            @if ($isImage)
                                <img src="{{ asset($file) }}" alt="Uploaded File" class="regular-image">
                            @endif
                        @endforeach
                    </div>
                    {{-- Signature --}}
                @elseif ($type === 'signature' && $value)
                    <div class="field-label">{{ $label }}</div>
                    <div class="field-value">
                        <img class="signature-image" src="{{ asset($value) }}" alt="Signature">
                    </div>

                    {{-- Normal Text/Number/Date etc → Inline --}}
                @else
                    <div class="field-row">
                        <span class="field-label-inline"><strong>{{ $label }}</strong>:</span>
                        <span class="field-value-inline">{!! nl2br(e($value ?? 'N/A')) !!}</span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

</body>

</html>
