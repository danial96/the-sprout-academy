{{-- Time Split Field Component (HH, MM, AM/PM with Time Picker) --}}
@php
    $fieldId = $fieldId ?? 'timeField';
    $label = $label ?? 'Time *';
    $required = $required ?? true;
    $autoFill = $autoFill ?? false; // Auto-fill current time
    $wrapperClass = $wrapperClass ?? 'form-field form-field-full';
@endphp

<div class="{{ $wrapperClass }}">
    <label for="{{ $fieldId }}">{{ $label }}{{ $required ? '*' : '' }}</label>
    <div class="time-split-wrapper" data-time-field="{{ $fieldId }}"
        data-autofill="{{ $autoFill ? 'true' : 'false' }}">
        <input type="text" id="{{ $fieldId }}Hour" class="form-input time-split-input" placeholder="HH"
            maxlength="2" readonly />
        <input type="text" id="{{ $fieldId }}Minute" class="form-input time-split-input" placeholder="MM"
            maxlength="2" readonly />
        <select id="{{ $fieldId }}Period" class="form-input time-split-select">
            <option value="AM">AM</option>
            <option value="PM">PM</option>
        </select>
        <div class="time-split-icon" data-time-trigger="{{ $fieldId }}" style="cursor: pointer;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        {{-- Custom Time Picker Dropdown --}}
        <div class="custom-time-picker" data-time-picker="{{ $fieldId }}" style="display: none;">
            <div class="time-picker-content">
                <div class="time-picker-row">
                    <select class="time-picker-select" data-time-hour="{{ $fieldId }}">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                        @endfor
                    </select>
                    <span class="time-separator">:</span>
                    <select class="time-picker-select" data-time-minute="{{ $fieldId }}">
                        @for ($i = 0; $i < 60; $i++)
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                        @endfor
                    </select>
                    <select class="time-picker-select" data-time-period="{{ $fieldId }}">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
