{{-- Masonry Gallery Component --}}
@php
    // Get location name (e.g., 'seminole', 'pinellas-park', etc.)
    $locationName = $locationName ?? 'seminole';

    // Normalize location name for folder path
    $locationFolder = strtolower($locationName);
    $locationFolderMap = [
        'seminole' => 'seminole',
        'pinellas-park' => 'pinellas-park',
        'montessori' => 'montessori',
        'largo' => 'largo',
        'st-petersburg' => 'st-petersburg',
    ];

    $folderName = $locationFolderMap[$locationFolder] ?? $locationFolder;

    // For subdirectory deployment: frontend folder is at root level (not in public/)
    // Try base_path first (for subdirectory), then public_path (for local)
    $imagesPath = base_path("frontend/assets/home_page_images/locations/{$folderName}");
    // Fallback to public_path if base_path doesn't exist (local development)
    if (!is_dir($imagesPath)) {
        $imagesPath = public_path("frontend/assets/home_page_images/locations/{$folderName}");
    }

    // Get all images from the location folder
    $images = [];
    if (is_dir($imagesPath)) {
        $files = glob($imagesPath . '/*.{png,jpg,jpeg,gif,webp}', GLOB_BRACE);

        // If glob with brace doesn't work, try individual extensions
        if (empty($files)) {
            $files = array_merge(
                glob($imagesPath . '/*.png'),
                glob($imagesPath . '/*.jpg'),
                glob($imagesPath . '/*.jpeg'),
                glob($imagesPath . '/*.gif'),
                glob($imagesPath . '/*.webp')
            );
        }

        sort($files); // Sort alphabetically

        foreach ($files as $file) {
            $filename = basename($file);
            // Use asset() helper which handles subdirectory automatically
            $images[] = [
                'src' => asset("frontend/assets/home_page_images/locations/{$folderName}/{$filename}"),
                'alt' => ucfirst($locationName) . ' Location - ' . pathinfo($filename, PATHINFO_FILENAME),
            ];
        }
    }

    // If images array is explicitly provided, use that instead
    if (isset($imagesArray) && is_array($imagesArray) && count($imagesArray) > 0) {
        $images = $imagesArray;
    }

    $galleryId = $galleryId ?? 'masonry-gallery-' . uniqid();
@endphp

<section class="masonry-gallery-section" id="{{ $galleryId }}">
    <div class="container">
        <simple-masonry class="masonry-gallery-masonry" data-use-column-count="true" data-dense-placement="true"
            data-animate-on-resize="true" data-gap-horizontal="--grid-gap-horizontal"
            data-gap-vertical="--grid-gap-vertical">
            @foreach ($images as $index => $image)
                <div class="grid-item masonry-gallery-item" data-index="{{ $index }}" tabindex="0"
                    role="button" aria-label="View image {{ $index + 1 }}">
                    <div class="masonry-gallery-image-wrapper">
                        <img src="{{ $image['src'] ?? $image }}"
                            alt="{{ $image['alt'] ?? 'Gallery image ' . ($index + 1) }}" class="masonry-gallery-image"
                            loading="lazy" data-lightbox-src="{{ $image['lightbox'] ?? ($image['src'] ?? $image) }}">
                        <div class="masonry-gallery-overlay">
                            <div class="masonry-gallery-overlay-content">
                                <img src="{{ asset('frontend/assets/home_page_images/gallery-img-icon.png') }}"
                                    alt="View image" class="masonry-gallery-icon" aria-hidden="true">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </simple-masonry>
    </div>

    {{-- Lightbox Modal --}}
    <div class="masonry-lightbox" id="lightbox-{{ $galleryId }}" role="dialog" aria-modal="false"
        aria-label="Image gallery lightbox">
        <div class="masonry-lightbox-backdrop"></div>
        <div class="masonry-lightbox-container">
            <button type="button" class="masonry-lightbox-close" aria-label="Close lightbox">
                <i class="fas fa-times"></i>
            </button>
            <button type="button" class="masonry-lightbox-prev" aria-label="Previous image">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button type="button" class="masonry-lightbox-next" aria-label="Next image">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="masonry-lightbox-content">
                <img class="masonry-lightbox-image" src="" alt="" style="opacity: 0;">
                <div class="masonry-lightbox-caption"></div>
            </div>
        </div>
    </div>
</section>
