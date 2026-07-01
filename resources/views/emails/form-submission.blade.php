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
            background: linear-gradient(to right, #6DAA44, #007B9A);
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
            <img src="data:image/png;base64,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" alt="The Sprout Academy" class="email-logo">
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

