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
            margin: 120px 30px 50px 30px;
            /* top, right, bottom, left */
        }

        @page {
            margin: 120px 30px 50px 30px;
            /* top, right, bottom, left */
        }

        .pdf-header {
            position: fixed;
            top: -100px;
            /* same as negative of top margin */
            left: 0;
            right: 0;
            height: 100px;
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
            width: 90%;
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .field-card {
            margin-bottom: 15px;
            padding: 10px 15px;
            background: #fafafa;
            border-radius: 6px;
        }

        .field-label {
            font-weight: 600;
            margin-bottom: 5px;
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
                    <strong>Company Name</strong><br>
                    123 Street, City, Country<br>
                    Phone: +123456789 | Email: info@company.com
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
                @if ($type !== 'paragraph')
                    <div class="field-label">{{ $label }}</div>
                @endif

                @if ($type === 'paragraph')
                    <div class="field-value">{!! nl2br(e($value ?? strip_tags($label))) !!}</div>
                @elseif (is_array($value))
                    <div class="field-value">
                        @foreach ($value as $v)
                            <span class="badge-multi">{{ $v }}</span>
                        @endforeach
                    </div>
                @elseif ($type === 'file' && $value)
                    @php
                        $mimeType = \File::mimeType($value);
                        $isImage = Str::startsWith($mimeType, 'image/');
                    @endphp
                    @if ($isImage)
                        <div class="field-value">
                            <img class="regular-image" src="{{ asset($value) }}" alt="Uploaded File">
                        </div>
                    @endif
                @elseif ($type === 'signature' && $value)
                    <div class="field-value">
                        <img class="signature-image" src="{{ asset($value) }}" alt="Signature">
                    </div>
                @else
                    <div class="field-value">{!! nl2br(e($value ?? 'N/A')) !!}</div>
                @endif
            </div>
        @endforeach

    </div>
</body>

</html>
