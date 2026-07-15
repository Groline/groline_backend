<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{asset('logo.png')}}" />
    <link rel="apple-touch-icon" href="{{asset('logo.png')}}" />
    <link href="{{asset('pages/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <title>قريباً</title>
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #f8fdf8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }
        .placeholder-card {
            text-align: center;
            padding: 3rem 2rem;
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            max-width: 480px;
            width: 90%;
        }
        .placeholder-card img {
            max-height: 90px;
            margin-bottom: 1.5rem;
        }
        .placeholder-card h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #2d7a3a;
            margin-bottom: 0.75rem;
        }
        .placeholder-card p {
            color: #6c757d;
            font-size: 1.05rem;
            margin-bottom: 1.5rem;
        }
        .store-btn {
            display: inline-block;
            background: #2d7a3a;
            color: #fff;
            border-radius: 0.5rem;
            padding: 0.6rem 1.4rem;
            font-size: 0.95rem;
            text-decoration: none;
            margin: 0.25rem;
            transition: background 0.2s;
        }
        .store-btn:hover { background: #1f5c2a; color: #fff; }
        .footer-note {
            margin-top: 2rem;
            color: #adb5bd;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="placeholder-card">
        <img src="{{asset('logo.png')}}" alt="Logo" />
        <h1>قريباً</h1>
        <p>نعمل على تطوير التطبيق، سيكون متاحاً قريباً.</p>
        @if(!empty($android_link))
        <a href="{{ $android_link }}" class="store-btn" target="_blank" rel="noopener noreferrer">
            تحميل للأندرويد
        </a>
        @endif
        <p class="footer-note">&copy; {{ date('Y') }} &mdash; {{__('All rights reserved')}}</p>
    </div>
</body>
</html>