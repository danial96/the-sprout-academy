<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        /* Reset styles */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            outline: none;
            text-decoration: none;
        }

        /* Main styles */
        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            height: 100% !important;
            background-color: #f5f5f5;
            font-family: 'Nunito Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: #333333;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }

        .email-header {
            background: linear-gradient(143deg, #6daa44 20%, #ed9b04 100%);
            padding: 30px 20px;
            text-align: center;
        }

        .email-logo {
            max-width: 200px;
            height: auto;
            margin: 0 auto;
        }

        .email-body {
            padding: 40px 30px;
        }

        .email-title {
            font-family: 'Rubik', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: #0a2239;
            margin: 0 0 30px 0;
            line-height: 1.3;
        }

        .form-data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .form-data-table tr {
            border-bottom: 1px solid #e8e8e8;
        }

        .form-data-table tr:last-child {
            border-bottom: none;
        }

        .form-data-table td {
            padding: 15px 20px;
            vertical-align: top;
        }

        .form-data-label {
            font-weight: 600;
            color: #0a2239;
            width: 40%;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-data-value {
            color: #333333;
            font-size: 15px;
            word-wrap: break-word;
        }

        .form-data-value strong {
            color: #0a2239;
        }

        .submission-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            text-align: center;
            border-left: 4px solid #6daa44;
        }

        .submission-info p {
            margin: 5px 0;
            color: #666666;
            font-size: 14px;
        }

        .email-footer {
            background-color: #0a2239;
            padding: 30px 20px;
            text-align: center;
            color: #ffffff;
        }

        .email-footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #cccccc;
        }

        .email-footer a {
            color: #6daa44;
            text-decoration: none;
        }

        .divider {
            height: 1px;
            background-color: #e8e8e8;
            margin: 30px 0;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 30px 20px;
            }

            .email-title {
                font-size: 20px;
            }

            .form-data-table td {
                padding: 12px 15px;
                display: block;
                width: 100% !important;
            }

            .form-data-label {
                width: 100%;
                margin-bottom: 5px;
                font-size: 12px;
            }

            .form-data-value {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header with Logo -->
        <div class="email-header">
            <img src="{{ $message->embed(public_path('frontend/assets/home_page_images/email-logo-white.png')) }}" alt="The Sprout Academy" class="email-logo">
        </div>

        <!-- Body -->
        <div class="email-body">
            <h1 class="email-title">{{ $title }}</h1>

            <p style="margin: 0 0 20px 0; color: #666666;">A new form submission has been received. Please find the details below:</p>

            <!-- Form Data Table -->
            <table class="form-data-table">
                @foreach($formData as $label => $value)
                    @if($value !== null && $value !== '')
                        <tr>
                            <td class="form-data-label">{{ $label }}</td>
                            <td class="form-data-value">
                                @if(is_array($value))
                                    {{ implode(', ', array_filter($value)) }}
                                @elseif(is_bool($value))
                                    {{ $value ? 'Yes' : 'No' }}
                                @else
                                    {{ $value }}
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>

            <!-- Submission Info -->
            <div class="submission-info">
                <p><strong>Submitted:</strong> {{ $submittedAt }}</p>
                <p><strong>Form Type:</strong> {{ ucwords(str_replace('_', ' ', $formType)) }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>The Sprout Academy</strong></p>
            <p>Childcare and Early Education</p>
            <p style="margin-top: 15px;">
                <a href="{{ route('frontend.home') }}">Visit Our Website</a>
            </p>
            <p style="margin-top: 20px; font-size: 12px; color: #999999;">
                This is an automated email. Please do not reply to this message.
            </p>
        </div>
    </div>
</body>
</html>

