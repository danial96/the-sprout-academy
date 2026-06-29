@extends('frontend.partials.master')

@section('title', 'Supply Order Form')

@section('content')
    {{-- Form Header - Full Width --}}
    @include('frontend.components.form_header', [
        'title' => 'SUPPLY ORDER FORM',
    ])

    {{-- Form Section --}}
    <section class="form-section form-section-gradient">
        <div class="container">
            <div class="site_form site_form_supply_order">
                <form id="supplyOrderForm" method="POST" action="{{ route('form.supplyOrder') }}" novalidate>
                    @csrf

                    {{-- Choose Your Center - Full Width --}}
                    @if (isset($formFields['number_inputs']['right_column']))
                        @foreach ($formFields['number_inputs']['right_column'] as $key => $field)
                            @if (isset($field['type']) && $field['type'] == 'select')
                                <div class="form-field form-field-full-width">
                                    <label for="{{ $key }}">{{ $field['label'] }}*</label>
                                    <select id="{{ $key }}" name="{{ $key }}" class="form-select"
                                        @if ($field['required']) required @endif>
                                        @foreach ($field['options'] as $optionKey => $optionValue)
                                            <option value="{{ $optionKey }}"
                                                @if (isset($field['default']) && $field['default'] == $optionKey) selected @endif>
                                                {{ $optionValue }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    <div class="form-wrapper form-wrapper-supply-order">
                        {{-- Left Column --}}
                        <div class="form-left form-left-supply-order">
                            {{-- Left Column Number Inputs --}}
                            @if (isset($formFields['number_inputs']['left_column']))
                                @foreach ($formFields['number_inputs']['left_column'] as $key => $field)
                                    @if ($key !== 'color_printer_ink')
                                        <div class="form-field">
                                            <label for="{{ $key }}">{{ $field['label'] }}*</label>
                                            <input type="number" id="{{ $key }}" name="{{ $key }}"
                                                class="form-input" placeholder="Type A Number"
                                                @if ($field['required']) required @endif min="0">
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        {{-- Right Column --}}
                        <div class="form-right form-right-supply-order">
                            {{-- Right Column Number Inputs (excluding dropdown) --}}
                            @if (isset($formFields['number_inputs']['right_column']))
                                @foreach ($formFields['number_inputs']['right_column'] as $key => $field)
                                    @if (!isset($field['type']) || $field['type'] != 'select')
                                        <div class="form-field">
                                            <label for="{{ $key }}">{{ $field['label'] }}*</label>
                                            <input type="number" id="{{ $key }}" name="{{ $key }}"
                                                class="form-input" placeholder="Type A Number"
                                                @if ($field['required']) required @endif min="0">
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- Color Printer Ink - Full Width --}}
                    @if (isset($formFields['number_inputs']['left_column']['color_printer_ink']))
                        @php
                            $field = $formFields['number_inputs']['left_column']['color_printer_ink'];
                        @endphp
                        <div class="form-field form-field-full-width mt-3">
                            <label for="color_printer_ink">{{ $field['label'] }}*</label>
                            <input type="number" id="color_printer_ink" name="color_printer_ink"
                                class="form-input" placeholder="Type A Number"
                                @if ($field['required']) required @endif min="0">
                        </div>
                    @endif

                    {{-- Other Textarea Field - Full Width --}}
                    @if (isset($formFields['textarea']))
                        @foreach ($formFields['textarea'] as $key => $field)
                            <div class="form-field form-field-full-width mt-3">
                                <label for="{{ $key }}">{{ $field['label'] }}</label>
                                <div class="textarea-wrapper">
                                    <textarea id="{{ $key }}" name="{{ $key }}" class="form-textarea"
                                        placeholder="{{ $field['placeholder'] ?? 'Type here' }}" @if ($field['required']) required @endif></textarea>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- Submit Button - Full Width --}}
                    <button type="submit" class="submit-btn submit-btn-full-width" id="submitBtn">Submit Now</button>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Form validation
                const form = document.getElementById('supplyOrderForm');
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            });
        </script>
    @endpush
@endsection
