{{-- Section Heading Component with Dashed Border and Rotation --}}
@php
    // Default values
    $text = $text ?? 'Section Title';
    $bgColor = $bgColor ?? '#6daa44'; // Olive green
    $borderColor = $borderColor ?? '#666666'; // Dark gray
    $rotation = $rotation ?? 'right'; // 'right' or 'left'
    $rotationDegree = $rotation === 'right' ? '4deg' : '-4deg';
@endphp

<div class="section-heading-wrapper" style="--rotation: {{ $rotationDegree }};">
    <div class="section-heading" style="background-color: {{ $bgColor }}; border-color: {{ $borderColor }};">
        <span class="section-heading-text">{{ $text }}</span>
    </div>
</div>
