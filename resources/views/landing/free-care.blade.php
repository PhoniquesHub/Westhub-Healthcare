{{-- Change the offer end date here if the promotion changes. --}}
@php($offerEnds = '16 December 2026')

<x-landing-layout :seo="[
    'title' => 'Your first 2 weeks of home care are free | WestHub Healthcare',
    'description' => 'Home care, nursing or therapy in Illinois from a licensed, CHAP-accredited agency. New clients get their first 2 weeks free.',
]">
    <section class="bg-teal-50/60">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 py-10 sm:py-16 lg:grid-cols-[1.1fr_0.9fr] lg:items-start">
            <div>
                <p class="text-sm font-medium text-teal-900">For new clients in Cook, DuPage, Lake, Will, Kendall, Grundy and Kankakee counties</p>
                <h1 class="mt-3 max-w-xl text-4xl font-bold leading-tight tracking-tight text-neutral-900 sm:text-5xl">
                    Care for someone you love at home, with the first 2 weeks free
                </h1>
                <p class="mt-5 max-w-xl text-lg leading-relaxed text-neutral-700">
                    Tell us who needs care and we'll call you within one business day to talk through what would help.
                    No pressure and nothing to prepare.
                </p>
                <ul class="mt-6 space-y-3 text-neutral-800">
                    <li>Home care: help with meals, errands, personal care and companionship</li>
                    <li>Nursing: CNAs, LPNs and RNs, including vital signs monitoring and trach care</li>
                    <li>Therapy: physical, speech and occupational therapy at home</li>
                </ul>
                <p class="mt-6 text-sm text-neutral-500">
                    Offer ends {{ $offerEnds }}. New clients only, one redemption per household. Full terms apply.
                </p>
            </div>

            <div class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-neutral-200 sm:p-8">
                <h2 class="text-xl font-bold text-neutral-900">Claim your free 2 weeks</h2>
                <p class="mb-5 mt-1 text-sm text-neutral-600">It takes about a minute. A care coordinator will call you.</p>
                <livewire:free-care-form />
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-12">
        <p class="max-w-2xl text-lg text-neutral-800">
            WestHub Healthcare is an Illinois state-licensed and CHAP-accredited agency. Our supervisors stay in touch with every family by phone and in person to make sure needs are being met.
        </p>

        <dl class="mt-10 divide-y divide-neutral-200 border-y border-neutral-200">
            <div class="grid gap-2 py-6 sm:grid-cols-[14rem_1fr]">
                <dt class="font-semibold text-neutral-900">Care that fits your home</dt>
                <dd>Hourly or live-in help, from a few hours a week to round-the-clock support, after a hospital stay or for the long term.</dd>
            </div>
            <div class="grid gap-2 py-6 sm:grid-cols-[14rem_1fr]">
                <dt class="font-semibold text-neutral-900">Qualified, vetted caregivers</dt>
                <dd>Certified nursing assistants, licensed practical nurses and registered nurses, matched to the person's needs.</dd>
            </div>
            <div class="grid gap-2 py-6 sm:grid-cols-[14rem_1fr]">
                <dt class="font-semibold text-neutral-900">A real person to call</dt>
                <dd>Your care coordinator calls within one business day, and supervisors check in with you after care begins.</dd>
            </div>
        </dl>

        {{-- Add 2 or 3 real, approved client testimonials here before the ads go live. --}}

        <div class="mt-10">
            <a href="#claim" class="inline-block rounded-lg bg-teal-800 px-6 py-3.5 font-semibold text-white hover:bg-teal-900 focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-300">
                Claim my free 2 weeks
            </a>
        </div>
    </section>
</x-landing-layout>
