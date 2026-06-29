{{-- Checkbox Group Component --}}
@php
    $fieldId = $fieldId ?? 'checkboxGroup';
    $label = $label ?? 'Check All That Apply';
    $required = $required ?? false;
    $options = $options ?? []; // Array of ['value' => 'label'] or ['value' => 'label', 'checked' => true]
    $columns = $columns ?? 4; // Number of columns (1-4)
    $wrapperClass = $wrapperClass ?? 'form-field form-field-full';
    $name = $name ?? $fieldId; // Form field name
@endphp

<div class="{{ $wrapperClass }}">
    <label class="checkbox-group-label">{{ $label }}{{ $required ? '*' : '' }}</label>
    <div class="checkbox-group-wrapper" data-checkbox-group="{{ $fieldId }}" data-columns="{{ $columns }}">
        @foreach ($options as $key => $option)
            @php
                $value = is_array($option) ? $option['value'] ?? $key : $key;
                $optionLabel = is_array($option) ? $option['label'] ?? ($option['value'] ?? $key) : $option;
                $checked = is_array($option) && isset($option['checked']) && $option['checked'] ? 'checked' : '';
                $checkboxId = $fieldId . '_' . str_replace([' ', '-', '_'], '', $value);
            @endphp
            <div class="checkbox-item">
                <input type="checkbox" id="{{ $checkboxId }}" name="{{ $name }}[]" value="{{ $value }}"
                    class="checkbox-input" {{ $checked }} />
                <label for="{{ $checkboxId }}" class="checkbox-label">{{ $optionLabel }}</label>
            </div>
        @endforeach
    </div>
</div>
