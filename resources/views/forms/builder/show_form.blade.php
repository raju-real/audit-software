@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h3>{{ $form->title }}</h3>
        <p>{{ $form->description }}</p>

        <form method="POST" action="{{ $route }}" enctype="multipart/form-data">
            @csrf

            @foreach ($form->fields->sortBy('order') as $field)
                <div class="mb-3">
                    {{-- Paragraph should just display as text --}}
                    @if ($field->type === 'paragraph')
                        <p class="fw-bold">{{ $field->label }}</p>
                        <p>{{ $field->paragraph }}</p>
                    @else
                        <label class="form-label">{{ $field->label }}
                            @if ($field->required)
                                <span class="text-danger">*</span>
                            @endif
                        </label>

                        {{-- Render different field types --}}
                        @if ($field->type === 'text')
                            <input type="text" name="field_{{ $field->id }}" class="form-control"
                                placeholder="{{ $field->placeholder }}">
                        @elseif($field->type === 'number')
                            <input type="number" name="field_{{ $field->id }}" class="form-control">
                        @elseif($field->type === 'textarea')
                            <textarea name="field_{{ $field->id }}" class="form-control"></textarea>
                        @elseif($field->type === 'select')
                            <select name="field_{{ $field->id }}" class="form-control">
                                @foreach ($field->options ?? [] as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                        @elseif($field->type === 'checkbox')
                            @foreach ($field->options ?? [] as $opt)
                                <div>
                                    <label>
                                        <input type="checkbox" name="field_{{ $field->id }}[]"
                                            value="{{ $opt }}"> {{ $opt }}
                                    </label>
                                </div>
                            @endforeach
                        @elseif($field->type === 'radio')
                            @foreach ($field->options ?? [] as $opt)
                                <div>
                                    <label>
                                        <input type="radio" name="field_{{ $field->id }}"
                                            value="{{ $opt }}"> {{ $opt }}
                                    </label>
                                </div>
                            @endforeach
                        @elseif($field->type === 'file')
                            <input type="file" name="field_{{ $field->id }}{{ $field->multiple ? '[]' : '' }}"
                                class="form-control" {{ $field->multiple ? 'multiple' : '' }}>
                        @elseif($field->type === 'signature')
                            <div class="signature-wrapper">
                                <canvas id="sigpad_{{ $field->id }}" class="border rounded w-100"></canvas>
                                <input type="hidden" name="field_{{ $field->id }}_signature" id="siginput_{{ $field->id }}">
                                <button type="button" class="btn btn-sm btn-secondary mt-2 clear-signature"
                                    data-target="sigpad_{{ $field->id }}">Clear</button>
                            </div>
                        @endif

                        @error('field_' . $field->id)
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    @endif
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

@push('js')
    <script src="{{ asset('assets/admin/js/custom/form_submit.js') }}"></script>
@endpush
