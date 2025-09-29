@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h3>{{ $form->title }}</h3>
    <p>{{ $form->description }}</p>

    <div class="mt-4">
        @foreach($form->fields->sortBy('order') as $field)
            <div class="mb-3 p-3 border rounded">
                {{-- Paragraph --}}
                @if($field->type === 'paragraph')
                    <p class="fw-bold">{{ $field->label }}</p>
                    <p>{{ $field->paragraph }}</p>
                @else
                    <p class="fw-bold">{{ $field->label }}</p>

                    @php
                        $value = $submission->data[$field->id] ?? null;
                    @endphp

                    @if($field->type === 'checkbox')
                        @if(is_array($value))
                            <ul>
                                @foreach($value as $val)
                                    <li>{{ $val }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>{{ $value }}</p>
                        @endif
                    @elseif($field->type === 'file')
                        @if($value && is_array($value))
                            @foreach($value as $file)
                                <div>
                                    <a href="{{ asset('storage/'.$file) }}" target="_blank">{{ basename($file) }}</a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No file uploaded</p>
                        @endif
                    @elseif($field->type === 'signature')
                        @if($value)
                            <img src="{{ asset('storage/'.$value) }}" alt="Signature" style="max-width:400px; border:1px solid #ccc;">
                        @else
                            <p class="text-muted">No signature provided</p>
                        @endif
                    @else
                        <p>{{ is_array($value) ? implode(', ', $value) : $value }}</p>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
