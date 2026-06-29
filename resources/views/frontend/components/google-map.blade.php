{{-- Google Map Component --}}
@php
    // Encode the address for URL
    $encodedAddress = urlencode($address ?? '');
    // Default zoom level is 15, but can be overridden
    $zoom = $zoom ?? 15;
@endphp

<div class="vt-location-viewer">
    <div class="vt-viewer-container">
        <iframe
            src="https://www.google.com/maps?q={{ $encodedAddress }}&output=embed&z={{ $zoom }}"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            class="location-map-iframe"
            title="Google Maps - {{ $address ?? 'Location' }}">
        </iframe>
    </div>
</div>

