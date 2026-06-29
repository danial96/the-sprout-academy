{{-- Accordion Section Component --}}
@php
    $sectionTitle = $sectionTitle ?? 'Section Title';
    $leftIcon = $leftIcon ?? null;
    $rightIcon = $rightIcon ?? null;
    $accordionItems = $accordionItems ?? [];
    $columns = $columns ?? 2; // Default 2 columns
@endphp

<section class="accordion-section">
    <div class="container">
        {{-- Section Header with Icons --}}
        <div class="accordion-header-wrapper">
            @if ($leftIcon)
                <img src="{{ $leftIcon }}" alt="Icon" class="accordion-icon-left">
            @endif

            <h2 class="accordion-section-title">{{ $sectionTitle }}</h2>

            @if ($rightIcon)
                <img src="{{ $rightIcon }}" alt="Icon" class="accordion-icon-right">
            @endif
        </div>

        {{-- Accordion Grid --}}
        <div class="accordion-two-column {{ $columns == 1 ? 'accordion-single-column' : '' }}">
            @if ($columns == 1)
                {{-- Single Column Layout --}}
                <div class="accordion-column">
                    @foreach ($accordionItems as $index => $item)
                        <div class="accordion-item">
                            <button class="accordion-button {{ $item['expanded'] ?? false ? 'active' : 'collapsed' }}"
                                type="button" data-bs-toggle="collapse" data-bs-target="#accordion-{{ $index }}"
                                aria-expanded="{{ $item['expanded'] ?? false ? 'true' : 'false' }}"
                                aria-controls="accordion-{{ $index }}">
                                <span class="accordion-question-icon">?</span>
                                <span class="accordion-title-text">{{ $item['title'] }}</span>
                                <span class="accordion-toggle-icon">
                                    <i class="fas fa-plus"></i>
                                    <i class="fas fa-minus"></i>
                                </span>
                            </button>
                            <div id="accordion-{{ $index }}"
                                class="accordion-collapse collapse {{ $item['expanded'] ?? false ? 'show' : '' }}">
                                <div class="accordion-body">
                                    @if (isset($item['content']) && is_array($item['content']))
                                        <ul class="accordion-list">
                                            @foreach ($item['content'] as $point)
                                                <li>{{ $point }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>{{ $item['content'] ?? '' }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Two Column Layout --}}
                {{-- Left Column --}}
                <div class="accordion-column">
                    @foreach ($accordionItems as $index => $item)
                        @if ($index % 2 == 0)
                            <div class="accordion-item">
                                <button
                                    class="accordion-button {{ $item['expanded'] ?? false ? 'active' : 'collapsed' }}"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-{{ $index }}"
                                    aria-expanded="{{ $item['expanded'] ?? false ? 'true' : 'false' }}"
                                    aria-controls="accordion-{{ $index }}">
                                    <span class="accordion-question-icon">?</span>
                                    <span class="accordion-title-text">{{ $item['title'] }}</span>
                                    <span class="accordion-toggle-icon">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus"></i>
                                    </span>
                                </button>
                                <div id="accordion-{{ $index }}"
                                    class="accordion-collapse collapse {{ $item['expanded'] ?? false ? 'show' : '' }}">
                                    <div class="accordion-body">
                                        @if (isset($item['content']) && is_array($item['content']))
                                            <ul class="accordion-list">
                                                @foreach ($item['content'] as $point)
                                                    <li>{{ $point }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>{{ $item['content'] ?? '' }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Right Column --}}
                <div class="accordion-column">
                    @foreach ($accordionItems as $index => $item)
                        @if ($index % 2 != 0)
                            <div class="accordion-item">
                                <button
                                    class="accordion-button {{ $item['expanded'] ?? false ? 'active' : 'collapsed' }}"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-{{ $index }}"
                                    aria-expanded="{{ $item['expanded'] ?? false ? 'true' : 'false' }}"
                                    aria-controls="accordion-{{ $index }}">
                                    <span class="accordion-question-icon">?</span>
                                    <span class="accordion-title-text">{{ $item['title'] }}</span>
                                    <span class="accordion-toggle-icon">
                                        <i class="fas fa-plus"></i>
                                        <i class="fas fa-minus"></i>
                                    </span>
                                </button>
                                <div id="accordion-{{ $index }}"
                                    class="accordion-collapse collapse {{ $item['expanded'] ?? false ? 'show' : '' }}">
                                    <div class="accordion-body">
                                        @if (isset($item['content']) && is_array($item['content']))
                                            <ul class="accordion-list">
                                                @foreach ($item['content'] as $point)
                                                    <li>{{ $point }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>{{ $item['content'] ?? '' }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
