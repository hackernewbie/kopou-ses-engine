<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Drifft SES Engine</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f7fafc;
        }

        .top-right {
            position: fixed;
            top: 0;
            right: 0;
            padding: 1rem 1.5rem;
        }

        .top-right a {
            font-size: 0.875rem;
            color: #718096;
            text-decoration: underline;
            margin-left: 1rem;
        }

        .btn {
            padding: 0.75rem 2.25rem;
            background-color: #1a202c;
            color: #fff;
            font-family: 'Nunito', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: background-color 0.2s, box-shadow 0.2s, transform 0.1s;
        }

        .btn:hover {
            background-color: #2d3748;
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.15), 0 3px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .logo {
            position: fixed;
            top: 0;
            left: 0;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            text-decoration: none;
        }

        .logo-icon {
            width: 37px;
            height: 37px;
            background: linear-gradient(135deg, #2d3748, #1a202c);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18);
        }

        .logo-icon svg {
            width: 21px;
            height: 21px;
        }

        .logo-text {
            font-size: 1.09rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            color: #1a202c;
            line-height: 1;
        }

        .logo-text span {
            color: #a0aec0;
            font-weight: 400;
        }
    </style>
</head>

<body>
    <a href="/">
        <div class="logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    style="width:21px;height:21px;">
                    <path d="M13 2L4.5 13.5H11L10 22L19.5 10.5H13L13 2Z" fill="url(#bolt-gold)"
                        stroke="url(#bolt-gold-stroke)" stroke-width="0.5" stroke-linejoin="round" />
                    <defs>
                        <linearGradient id="bolt-gold" x1="4.5" y1="2" x2="19.5" y2="22"
                            gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#FFE066" />
                            <stop offset="50%" stop-color="#F6C90E" />
                            <stop offset="100%" stop-color="#D4A017" />
                        </linearGradient>
                        <linearGradient id="bolt-gold-stroke" x1="4.5" y1="2" x2="19.5"
                            y2="22" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#FFE88A" />
                            <stop offset="100%" stop-color="#B8860B" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="logo-text">Kopou<span>SES</span>Engine</div>
        </div>
    </a>

    @if (Route::has('login'))
        <div class="top-right">
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <a href="{{ route('test-ses') }}" class="btn" title="Click to send a test email">Send Test Email</a>

</body>

</html>
