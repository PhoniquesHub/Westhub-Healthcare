<x-landing-layout :seo="['title' => 'Request received | WestHub Healthcare']">
    @php($phone = \App\Support\SiteSettings::contactPhone())

    <section class="mx-auto max-w-2xl px-4 py-16">
        <h1 class="text-3xl font-bold text-neutral-900">We have your request</h1>
        <p class="mt-4 text-lg leading-relaxed">
            A care coordinator will call you within one business day to talk about your free 2 weeks.
            Please keep your phone nearby.
        </p>
        @if($phone)
            <p class="mt-4">Need us sooner? Call <a class="font-semibold text-teal-900 underline" href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}">{{ $phone }}</a>.</p>
        @endif
        <a href="{{ route('home') }}" class="mt-8 inline-block text-teal-900 underline">Visit our main website</a>
    </section>

    {{-- Conversion event: fires once, only right after a real submission. No personal or health data is sent. --}}
    @if($justSubmitted)
        @push('scripts')
            <script>
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({ event: 'generate_lead', lead_source: 'landing_free_care' });
                if (typeof fbq === 'function') { fbq('track', 'Lead'); }
            </script>
        @endpush
    @endif
</x-landing-layout>
