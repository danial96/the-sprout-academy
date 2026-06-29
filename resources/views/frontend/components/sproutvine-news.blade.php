{{-- Sproutvine NEWS Section - Pixel Perfect Figma Match --}}
@php
    $viewAllUrl = $viewAllUrl ?? 'https://sproutvine.com/';
    $featured = $featured ?? [
        'image' => asset('frontend/assets/home_page_images/blog-img-1.png'),
        'date' => 'February 18, 2026',
        'title' => 'WHY KIDS FEEL MORE ANXIOUS TODAY – AND HOW PARENTS CAN HELP',
        'excerpt' => "Anxiety in children isn't new, but the way it's showing up today feels different. More parents are noticing worry, overwhelm,",
        'comments' => 76,
        'views' => 145,
    ];
    $sideArticles = $sideArticles ?? [
        [
            'image' => asset('frontend/assets/home_page_images/blog-img-3.png'),
            'date' => 'February 18, 2026',
            'title' => "DADS & SPORTS: MORE THAN GAMES, IT'S CONNECTION",
            'comments' => 76,
            'views' => 145,
        ],
        [
            'image' => asset('frontend/assets/home_page_images/blog-img-4.png'),
            'date' => 'February 13, 2026',
            'title' => 'THE IMPORTANCE OF BEING FINANCIALLY READY FOR RETIREMENT',
            'comments' => 76,
            'views' => 145,
        ],
        [
            'image' => asset('frontend/assets/home_page_images/blog-img-2.png'),
            'date' => 'February 18, 2026',
            'title' => 'MARRIAGE: BUILDING A PARTNERSHIP THAT LASTS THROUGH EVERY SEASON',
            'comments' => 76,
            'views' => 145,
        ],
    ];
@endphp

<section class="sproutvine-news-section" aria-labelledby="sproutvine-news-heading">
    <div class="container">

        {{-- Header --}}
        <div class="sproutvine-news-header">
            <div class="sproutvine-news-brand">
                {{-- Full Sproutvine logo (image handles both icon + wordmark) --}}
                <img
                    src="{{ asset('frontend/assets/home_page_images/SproutVine-logo-3.png') }}"
                    alt="Sproutvine"
                    class="sproutvine-news-logo"
                    loading="lazy"
                >
                <h2 id="sproutvine-news-heading" class="sproutvine-news-title">NEWS</h2>
            </div>
            <div class="sproutvine-news-header-actions">
                <a
                    href="{{ $viewAllUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn btn-sproutvine-news"
                >
                    View All Latest News
                </a>
            </div>
        </div>

        {{-- Two columns: featured (left) + side articles (right) --}}
        <div class="sproutvine-news-grid">

            {{-- Featured Article (Left) — full image with dark gradient overlay --}}
            <article class="sproutvine-news-featured">
                <a
                    href="{{ $viewAllUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="sproutvine-news-featured-link"
                >
                    <div class="sproutvine-news-featured-image-wrap">
                        <img
                            src="{{ $featured['image'] }}"
                            alt="{{ $featured['title'] }}"
                            class="sproutvine-news-featured-image"
                            loading="lazy"
                        >

                        {{-- Green date pill overlaid on image --}}
                        <span class="sproutvine-news-date-pill sproutvine-news-date-pill--overlay">
                            <i class="far fa-clock" aria-hidden="true"></i>
                            {{ $featured['date'] }}
                        </span>

                        {{-- Title / excerpt / meta — overlaid on gradient at bottom --}}
                        <div class="sproutvine-news-featured-body">
                            <span class="sproutvine-news-date-pill">
                                <i class="far fa-clock" aria-hidden="true"></i> {{ $featured['date'] }}
                            </span>
                            <h3 class="sproutvine-news-featured-title">{{ $featured['title'] }}</h3>
                            <p class="sproutvine-news-featured-excerpt">{{ $featured['excerpt'] }}</p>
                            <div class="sproutvine-news-meta">
                                <span>
                                    <i class="far fa-comment" aria-hidden="true"></i>
                                    Comments ({{ $featured['comments'] }})
                                </span>
                                <span>
                                    <i class="far fa-eye" aria-hidden="true"></i>
                                    Views ({{ $featured['views'] }})
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </article>

            {{-- Side Articles (Right) — white cards, image left + content right --}}
            <div class="sproutvine-news-side">
                @foreach ($sideArticles as $article)
                    <article class="sproutvine-news-side-card">
                        <a
                            href="{{ $viewAllUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="sproutvine-news-side-link"
                        >
                            {{-- Rounded thumbnail --}}
                            <div class="sproutvine-news-side-image-wrap">
                                <img
                                    src="{{ $article['image'] }}"
                                    alt="{{ $article['title'] }}"
                                    class="sproutvine-news-side-image"
                                    loading="lazy"
                                >
                            </div>

                            {{-- Date pill + title + meta --}}
                            <div class="sproutvine-news-side-body">
                                <div class="sproutvine-news-side-body-content">
                                    <span class="sproutvine-news-date-pill">
                                        <i class="far fa-clock" aria-hidden="true"></i>
                                        {{ $article['date'] }}
                                    </span>
                                    <h4 class="sproutvine-news-side-title">{{ $article['title'] }}</h4>
                                </div>
                                <div class="sproutvine-news-meta sproutvine-news-meta--light">
                                    <span>
                                        <i class="far fa-comment" aria-hidden="true"></i>
                                        Comments ({{ $article['comments'] }})
                                    </span>
                                    <span>
                                        <i class="far fa-eye" aria-hidden="true"></i>
                                        Views ({{ $article['views'] }})
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

        </div>
    </div>
</section>