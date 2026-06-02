<!DOCTYPE html>
<html @if(session('locale') == 'ar') lang="ar" dir="rtl" @else lang="en" dir="ltr" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('logo.png') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f8fdf8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* ── Header ── */
        .site-header {
            background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .site-logo img { height: 48px; display: block; }

        /* ── Language Switcher ── */
        .lang-switcher { position: relative; }
        .lang-btn {
            background: #f1f8f2;
            border: 1px solid #c8e6c9;
            border-radius: 0.4rem;
            padding: 0.4rem 0.9rem;
            cursor: pointer;
            font-size: 0.9rem;
            color: #2d7a3a;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-family: inherit;
        }
        .lang-btn:hover { background: #e8f5e9; }
        .lang-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 0.4rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            min-width: 140px;
            z-index: 200;
        }
        [dir="rtl"] .lang-dropdown { left: 0; }
        [dir="ltr"] .lang-dropdown { right: 0; }
        .lang-switcher:hover .lang-dropdown,
        .lang-switcher:focus-within .lang-dropdown { display: block; }
        .lang-dropdown a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            text-decoration: none;
            color: #333;
            font-size: 0.88rem;
            transition: background 0.15s;
        }
        .lang-dropdown a:hover { background: #f1f8f2; color: #2d7a3a; }

        /* ── Main ── */
        main { flex: 1; padding: 2.5rem 1rem; }
        .content-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 2.5rem 2.5rem;
            max-width: 860px;
            margin: 0 auto;
        }
        .content-card h1,
        .content-card h2,
        .content-card h3 { color: #2d7a3a; margin-bottom: 0.6rem; }
        .content-card h1 { font-size: 1.8rem; margin-bottom: 1rem; }
        .content-card h2 { font-size: 1.3rem; margin-top: 1.5rem; }
        .content-card h3 { font-size: 1.1rem; margin-top: 1.2rem; }
        .content-card p  { line-height: 1.8; color: #444; margin-bottom: 0.75rem; }
        .content-card ul,
        .content-card ol { padding-inline-start: 1.5rem; margin-bottom: 0.75rem; }
        .content-card li { line-height: 1.8; color: #444; }
        .content-card a  { color: #2d7a3a; }

        /* ── Footer ── */
        .site-footer {
            background: #1f5c2a;
            color: #d4edda;
            padding: 1.75rem 1rem;
            text-align: center;
        }
        .site-footer .footer-logo img {
            height: 48px;
            border-radius: 0.4rem;
            margin-bottom: 0.75rem;
        }
        .site-footer .copyright {
            font-size: 0.82rem;
            color: #81c784;
            margin-top: 0.5rem;
        }

        @media (max-width: 600px) {
            .content-card { padding: 1.5rem 1rem; }
        }
    </style>
</head>
<body>

<header class="site-header">
    <a href="{{ url('/dashboard') }}" class="site-logo">
        <img src="{{ asset('logo-no-bg.png') }}" alt="Logo">
    </a>
    <div class="lang-switcher" tabindex="0">
        @if(session('locale') == 'en')
            <button class="lang-btn">&#127468;&#127463; English &#9662;</button>
        @else
            <button class="lang-btn">&#127465;&#127487; &#1575;&#1604;&#1593;&#1585;&#1576;&#1610;&#1577; &#9662;</button>
        @endif
        <div class="lang-dropdown">
            <a href="{{ url('lang/en') }}">&#127468;&#127463; English</a>
            <a href="{{ url('lang/ar') }}">&#127465;&#127487; &#1575;&#1604;&#1593;&#1585;&#1576;&#1610;&#1577;</a>
        </div>
    </div>
</header>

<main>
    <div class="content-card">
        {!! $data !!}
    </div>
</main>

<footer class="site-footer">
    <div class="footer-logo">
        <img src="{{ asset('logo.png') }}" alt="Logo">
    </div>
    <div class="copyright">
        {{ __('Copyright') }} &copy; {{ date('Y') }} &mdash; {{ __('All rights reserved') }}
    </div>
</footer>

</body>
</html>
