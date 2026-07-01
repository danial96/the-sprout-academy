<?php

namespace App\Helpers;

class FormEmailHelper
{
    /**
     * Format form data for email display
     * Converts field names to readable labels and formats values
     */
    public static function formatFormData(array $data, array $fieldLabels = []): array
    {
        $formatted = [];

        foreach ($data as $key => $value) {
            // Skip system fields
            if (in_array($key, ['_token', 'csrf_token', 'submit'])) {
                continue;
            }

            // Get label from mapping or format the key
            $label = $fieldLabels[$key] ?? self::formatLabel($key);

            // Format the value
            $formattedValue = self::formatValue($value, $key);

            if ($formattedValue !== null && $formattedValue !== '') {
                $formatted[$label] = $formattedValue;
            }
        }

        return $formatted;
    }

    /**
     * Convert field name to readable label
     */
    private static function formatLabel(string $key): string
    {
        // Replace underscores and hyphens with spaces
        $label = str_replace(['_', '-'], ' ', $key);
        
        // Convert to title case
        $label = ucwords(strtolower($label));
        
        // Handle special cases
        $replacements = [
            'Id' => 'ID',
            'Url' => 'URL',
            'Email' => 'Email',
            'Phone' => 'Phone',
            'Fax' => 'Fax',
            'Dob' => 'Date of Birth',
            'Dob' => 'Date of Birth',
            'Start Date' => 'Start Date',
            'End Date' => 'End Date',
            'Todays Date' => 'Today\'s Date',
            'Completion Date' => 'Completion Date',
            'Paid Unpaid' => 'Type',
            'Area Repair' => 'Area of Repair',
            'Clock In Time' => 'Clock In Time',
            'Clock Out Time' => 'Clock Out Time',
            'Clock Out For Lunch' => 'Clock Out for Lunch',
            'Clock In From Lunch' => 'Clock In from Lunch',
            'Reason For Change' => 'Reason for Change',
            'Supervisor First Name' => 'Supervisor First Name',
            'Supervisor Last Name' => 'Supervisor Last Name',
            'Choose Your Center' => 'Center',
            'Other' => 'Other Notes',
            'Special Instructions' => 'Special Instructions',
            'Profile Image' => 'Profile Image',
            'Attach File' => 'Attached File',
            'Resume' => 'Resume',
            'File Path' => 'File',
        ];

        foreach ($replacements as $search => $replace) {
            if (stripos($label, $search) !== false) {
                $label = str_ireplace($search, $replace, $label);
            }
        }

        return $label;
    }

    /**
     * Format value for display
     */
    private static function formatValue($value, string $key): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Handle arrays
        if (is_array($value)) {
            // If it's an associative array with numeric keys, it might be a list
            if (array_keys($value) === range(0, count($value) - 1)) {
                return implode(', ', array_filter($value));
            }
            
            // For associative arrays, format as key-value pairs
            $formatted = [];
            foreach ($value as $k => $v) {
                if ($v !== null && $v !== '' && $v !== 0) {
                    $formatted[] = self::formatLabel($k) . ': ' . self::formatValue($v, $k);
                }
            }
            return implode("\n", $formatted);
        }

        // Handle booleans
        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }

        // Handle dates (YYYY-MM-DD or MM/DD/YYYY)
        if (preg_match('/^\d{4}-\d{2}-\d{2}/', $value) || preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
            try {
                $date = \Carbon\Carbon::parse($value);
                return $date->format('M d, Y');
            } catch (\Exception $e) {
                // Not a valid date, return as is
            }
        }

        // Handle times
        if (preg_match('/^\d{2}:\d{2}/', $value)) {
            try {
                $time = \Carbon\Carbon::createFromFormat('H:i', $value);
                return $time->format('g:i A');
            } catch (\Exception $e) {
                // Not a valid time, return as is
            }
        }

        // Handle file paths - show as link if it's a URL
        if (str_contains($key, 'file') || str_contains($key, 'image') || str_contains($key, 'resume')) {
            if (str_starts_with($value, 'http') || str_starts_with($value, '/storage')) {
                return 'File attached (see admin panel for download)';
            }
            return $value;
        }

        // Handle location values
        if (str_contains($key, 'location') || str_contains($key, 'center')) {
            return ucwords(str_replace(['_', '-'], ' ', $value));
        }

        // Default: return as string
        return (string) $value;
    }

    /**
     * Get admin email from config or env
     */
    public static function getAdminEmail(): string
    {
        return 'info@the-sprout-academy.com';
    }

    /**
     * Get email for a specific form type
     */
    public static function getFormEmail(string $formType): string
    {
        $map = [
            'contact'    => env('MAIL_CONTACT', 'info@the-sprout-academy.com'),
            'newsletter' => env('MAIL_NEWSLETTER', 'info@the-sprout-academy.com'),
            'employment' => env('MAIL_EMPLOYMENT', 'info@the-sprout-academy.com'),
        ];

        return $map[$formType] ?? self::getAdminEmail();
    }

    /**
     * Get enrollment email for a specific location
     */
    public static function getEnrollmentEmail(string $location): string
    {
        $location = strtolower(str_replace(['_', ' '], '-', $location));

        $map = [
            'seminole'      => 'alicia@the-sprout-academy.com',
            'st-petersburg' => 'crystal@the-sprout-academy.com',
            'pinellas-park' => 'yessica@the-sprout-academy.com',
            'pinellas_park' => 'yessica@the-sprout-academy.com',
            'montessori'    => 'cierra@the-sprout-academy.com',
            'largo'         => 'tessa@the-sprout-academy.com',
        ];

        return $map[$location] ?? self::getAdminEmail();
    }
}

