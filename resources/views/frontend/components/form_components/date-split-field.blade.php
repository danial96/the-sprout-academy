{{-- Date Split Field Component (MM, DD, YY with Calendar) --}}
@php
    $fieldId = $fieldId ?? 'dateField';
    $label = $label ?? 'Date *';
    $required = $required ?? true;
    $defaultDate = $defaultDate ?? null; // 'today' or null
    $minDate = $minDate ?? null; // 'today' or null
    $wrapperClass = $wrapperClass ?? 'form-field form-field-full';
@endphp

<div class="{{ $wrapperClass }}">
    <label for="{{ $fieldId }}">{{ $label }}{{ $required ? '*' : '' }}</label>
    <div class="date-split-wrapper" data-date-field="{{ $fieldId }}" data-default-date="{{ $defaultDate }}"
        data-min-date="{{ $minDate }}">
        <input type="text" id="{{ $fieldId }}Month" class="form-input date-split-input" placeholder="MM"
            maxlength="2" />
        <input type="text" id="{{ $fieldId }}Day" class="form-input date-split-input" placeholder="DD"
            maxlength="2" />
        <input type="text" id="{{ $fieldId }}Year" class="form-input date-split-input" placeholder="YY"
            maxlength="2" />
        <input type="text" id="{{ $fieldId }}DatePicker" class="form-input date-picker-hidden"
            style="display: none;" />
        <div class="date-split-icon" id="{{ $fieldId }}CalendarIcon" data-date-trigger="{{ $fieldId }}"
            style="cursor: pointer;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </div>
    </div>
</div>
