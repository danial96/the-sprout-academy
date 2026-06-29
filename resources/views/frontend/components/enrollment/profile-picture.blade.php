@php
    $imageUrl = $imageUrl ?? asset('frontend/assets/images/default-profile.png');
    $name = $name ?? '';
    $fieldName = $fieldName ?? 'profile_image';
    $showChangeButton = $showChangeButton ?? true;
    $nameParts = $name ? explode(' ', trim($name)) : [];
    $firstName = $nameParts[0] ?? '';
    $lastName = implode(' ', array_slice($nameParts, 1)) ?? '';

    // Unique DOM id: names like child_profile_image[] repeat on the page — duplicate ids break getElementById / Change Image
    $fileInputId = $fileInputId ?? (
        str_contains($fieldName, '[')
            ? 'enrollment_pp_' . preg_replace('/[^a-zA-Z0-9]/', '_', $fieldName) . '_' . uniqid('')
            : preg_replace('/[^a-zA-Z0-9_-]/', '_', $fieldName)
    );
    $previewElementId = $previewElementId ?? (
        ($fieldName === 'profile_image')
            ? 'profilePicturePreview'
            : ($fileInputId . '_preview')
    );
@endphp

<div class="profile-picture-wrapper">
    <div class="profile-picture-container">
        <img src="{{ $imageUrl }}" alt="{{ $name }}" class="profile-picture" id="{{ $previewElementId }}">
        <input type="file" name="{{ $fieldName }}" id="{{ $fileInputId }}" accept="image/*" class="profile-picture-input" style="display: none;">
    </div>
    @if ($name)
        <div class="profile-name">
            <div class="profile-first-name">{{ $firstName }}</div>
            <div class="profile-last-name">{{ $lastName }}</div>
        </div>
    @endif
    @if ($showChangeButton)
        <button type="button" class="btn-change-image"
            onclick="document.getElementById('{{ $fileInputId }}').click()">
            Change Image
        </button>
    @endif
</div>

