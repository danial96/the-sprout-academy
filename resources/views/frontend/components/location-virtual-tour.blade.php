@php
    $staticImagesMap = [
        'seminole'      => ['image' => 'vr1.png', 'label' => 'FRONT OFFICE'],
        'pinellas-park' => ['image' => 'vr3.png', 'label' => 'FRONT DOOR'],
        'montessori'    => ['image' => 'vr4.png', 'label' => 'ENTRY DOOR'],
        'largo'         => ['image' => 'vr5.png', 'label' => 'FRONT DOOR'],
        'st-petersburg' => ['image' => 'vr3.png', 'label' => 'FRONT OFFICE'],
    ];
    $staticImage = $staticImagesMap[$locationSlug] ?? null;
    $hasPanorama = !empty($panoramaImages);
@endphp

@if ($hasPanorama || $staticImage)
    <section class="virtual-tour-locations location-single-vt">
        <div class="container">
            <div class="vt-location-viewer vt-full-width-viewer">
                <div class="vt-viewer-container">
                    @if ($hasPanorama)
                        <div id="panorama-{{ $locationSlug }}" class="vt-panorama-viewer"
                            data-location="{{ $locationSlug }}"></div>

                        <div class="vt-panorama-overlay" aria-label="{{ $locationSlug }} tour thumbnails">
                            <button type="button" class="vt-panorama-arrow vt-panorama-arrow-left"
                                aria-label="Previous view" data-location="{{ $locationSlug }}">
                                <i class="fas fa-chevron-left"></i>
                            </button>

                            <div class="vt-panorama-thumbs" data-location="{{ $locationSlug }}">
                                @foreach ($panoramaImages as $imgIndex => $image)
                                    <button type="button"
                                        class="vt-panorama-thumb {{ $imgIndex === 0 ? 'is-active' : '' }}"
                                        data-location="{{ $locationSlug }}"
                                        data-scene-index="{{ $imgIndex }}"
                                        aria-label="{{ $image['label'] }}">
                                        <img src="{{ $image['url'] }}" alt="{{ $image['label'] }}" loading="lazy">
                                        <span class="vt-panorama-thumb-title">{{ $image['label'] }}</span>
                                    </button>
                                @endforeach
                            </div>

                            <button type="button" class="vt-panorama-arrow vt-panorama-arrow-right"
                                aria-label="Next view" data-location="{{ $locationSlug }}">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <div class="vt-panorama-scene-title" id="vt-scene-title-{{ $locationSlug }}">
                            {{ $panoramaImages[0]['label'] ?? '360° View' }}
                        </div>
                    @else
                        <div class="vt-viewer-label">{{ $staticImage['label'] }}</div>
                        <div class="vt-viewer-controls">
                            <button class="vt-control-btn" aria-label="Zoom in"><i class="fas fa-plus"></i></button>
                            <button class="vt-control-btn" aria-label="Zoom out"><i class="fas fa-minus"></i></button>
                            <button class="vt-control-btn" aria-label="Fullscreen"><i class="fas fa-expand"></i></button>
                        </div>
                        <img src="{{ asset('frontend/assets/home_page_images/' . $staticImage['image']) }}"
                            alt="Virtual Tour" class="vt-viewer-image">
                    @endif
                </div>
            </div>
        </div>
    </section>

    @if ($hasPanorama)
        @push('styles')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
        @endpush

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof pannellum === 'undefined' || !pannellum.viewer) return;

                    const panoramaImages = @json($panoramaImages);
                    const locationSlug   = '{{ $locationSlug }}';

                    const scenes = {};
                    panoramaImages.forEach((img, idx) => {
                        scenes[`s${idx}`] = {
                            title: img.label || `View ${idx + 1}`,
                            type: 'equirectangular',
                            panorama: img.url,
                        };
                    });

                    const sceneIds = Object.keys(scenes);
                    if (!sceneIds.length) return;

                    const viewer = pannellum.viewer(`panorama-${locationSlug}`, {
                        default: { firstScene: sceneIds[0], sceneFadeDuration: 250, autoLoad: true },
                        showControls: true,
                        mouseZoom: false,
                        keyboardZoom: false,
                        scenes,
                    });

                    const titleEl  = document.getElementById(`vt-scene-title-${locationSlug}`);
                    const thumbs   = Array.from(document.querySelectorAll(`.vt-panorama-thumb[data-location="${locationSlug}"]`));
                    const leftBtn  = document.querySelector(`.vt-panorama-arrow-left[data-location="${locationSlug}"]`);
                    const rightBtn = document.querySelector(`.vt-panorama-arrow-right[data-location="${locationSlug}"]`);

                    function setActiveIndex(idx) {
                        const safeIdx = (idx + thumbs.length) % thumbs.length;
                        thumbs.forEach((btn, i) => btn.classList.toggle('is-active', i === safeIdx));
                        const sceneId = `s${safeIdx}`;
                        if (titleEl) titleEl.textContent = scenes[sceneId]?.title || '360° View';
                        try { viewer.loadScene(sceneId); } catch (e) {}
                    }

                    thumbs.forEach(btn => {
                        btn.addEventListener('click', () => setActiveIndex(Number(btn.dataset.sceneIndex || 0)));
                    });

                    function currentIndex() {
                        const idx = thumbs.findIndex(b => b.classList.contains('is-active'));
                        return idx >= 0 ? idx : 0;
                    }

                    if (leftBtn)  leftBtn.addEventListener('click',  () => setActiveIndex(currentIndex() - 1));
                    if (rightBtn) rightBtn.addEventListener('click', () => setActiveIndex(currentIndex() + 1));

                    setActiveIndex(0);
                });
            </script>
        @endpush
    @endif
@endif
