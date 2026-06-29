{{--
    Inner Page Header Component

    Usage:
    @include('frontend.partials.header_inner', [
        'bgImage' => 'path/to/image.jpg',
        'title' => 'Page Title',
        'subtitle' => 'Optional subtitle',
        'showButton' => true/false,
        'buttonText' => 'Button Text',
        'buttonLink' => '#link'
    ])
--}}

<section class="inner-page-header"
    style="background-image: url('{{ $bgImage ?? asset('frontend/assets/home_page_images/hero-img.png') }}');"
    aria-label="Page header">
    <div class="container">
        <div class="inner-header-content">
            @if (isset($subtitle) && $subtitle)
                @include('frontend.components.section-heading', [
                    'text' => $subtitle,
                    'bgColor' => '#ed9b04',
                    'borderColor' => '#fff',
                    'rotation' => 'right',
                ])
            @endif

            <h1 class="inner-header-title">{{ $title ?? 'VIRTUAL TOURS' }}</h1>
            @if (isset($text) && $text)
                <p class="inner-header-text">{{ $text ?? 'Explore Our Academy' }}</p>
            @endif
            @if (isset($showButton) && $showButton)
                <a href="{{ $buttonLink ?? '#' }}" class="btn btn-foundation btn-lg inner-header-btn">
                    {{ $buttonText ?? 'Explore Our Academy' }}
                </a>
            @endif
        </div>
    </div>
</section>
