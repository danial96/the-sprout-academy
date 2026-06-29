{{-- Right Image Full Width with Content Component --}}
@php
    $image = $image ?? '';
    $title = $title ?? '';
    $text = $text ?? '';
    $buttonText = $buttonText ?? 'Learn More';
    $buttonLink = $buttonLink ?? '#';
    $buttonClass = $buttonClass ?? 'btn btn-foundation';
    $icon = $icon ?? null;
@endphp

<section class="program-section program-image-right-section">
    <div class="program-grid-wrapper program-grid-reverse">
        <!-- Left Column - Content (Container Size) -->
        <div class="program-content-column program-content-left">
            <div class="container">
                <div class="program-content-inner">
                    @if($icon)
                        <div class="program-icon">
                            <img src="{{ $icon }}" alt="" class="program-icon-img">
                        </div>
                    @endif
                    <h2 class="program-title">{{ $title }}</h2>
                    <p class="program-text">{{ $text }}</p>
                    <a href="{{ $buttonLink }}" class="{{ $buttonClass }}">{{ $buttonText }}</a>
                </div>
            </div>
        </div>

        <!-- Right Column - Image (Full Width) -->
        <div class="program-image-column program-image-right">
            <img src="{{ $image }}" alt="{{ $title }}" loading="lazy" class="program-image">
        </div>
    </div>
</section>
