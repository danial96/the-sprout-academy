@php
    $name = $name ?? 'toggle';
    $label = $label ?? '';
    $value = $value ?? false;
    $id = $id ?? 'toggle_' . uniqid();
@endphp

<div class="toggle-switch-wrapper">
    <label class="toggle-switch-label">{{ $label }}</label>
    <div class="toggle-switch">
        <input type="checkbox" name="{{ $name }}" id="{{ $id }}" value="1" {{ $value ? 'checked' : '' }} class="toggle-input">
        <label for="{{ $id }}" class="toggle-label">
            <span class="toggle-slider">
                <span class="toggle-text-yes">YES</span>
                <span class="toggle-text-no">NO</span>
            </span>
        </label>
    </div>
</div>


