@props(['seo' => []])
@php($phone = \App\Support\SiteSettings::contactPhone())
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $seo['title'] ?? 'WestHub Healthcare' }}</title>
    <meta name="description" content="{{ $seo['description'] ?? '' }}">
    {{-- Ad landing page: keep out of search results. Remove this line if the client wants it indexed. --}}
    <meta name="robots" content="noindex, follow">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&display=swap" rel="stylesheet">

    {{-- Tracking: Google Tag Manager (add every other pixel inside GTM). Set GTM_CONTAINER_ID in .env --}}
    @if($gtm = config('services.gtm_id'))
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ $gtm }}');</script>
    @endif

    {{-- Optional direct Meta Pixel. Use this OR a pixel inside GTM, not both. Set META_PIXEL_ID in .env --}}
    @if($pixel = config('services.meta_pixel_id'))
        <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src='https://connect.facebook.net/en_US/fbevents.js';s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script');fbq('init','{{ $pixel }}');fbq('track','PageView');</script>
    @endif

    {{-- Any other tag (TikTok, Google Ads, etc.) can be pushed from a view with @push('head') --}}
    @stack('head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased text-neutral-700 bg-white">
    @if($gtm)
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtm }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    <header class="border-b border-neutral-200">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
            <img src="{{ asset('assets/logo.svg') }}" alt="WestHub Healthcare" class="h-9 w-auto">
            @if($phone)
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="text-sm font-semibold text-teal-900 sm:text-base">Call {{ $phone }}</a>
            @endif
        </div>
    </header>

    <main>{{ $slot }}</main>

    <footer class="border-t border-neutral-200 py-6 text-center text-xs text-neutral-500">
        <a href="{{ route('privacy.policy') }}" class="underline">Privacy Policy</a>
        <span class="mx-2">|</span>
        &copy; {{ date('Y') }} WestHub Healthcare Services. Illinois state-licensed and CHAP-accredited.
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>
