<form wire:submit="submit" id="claim" class="space-y-4" novalidate>
    <div style="position:absolute;left:-9999px" aria-hidden="true">
        <input type="text" wire:model="honeypot" tabindex="-1" autocomplete="off">
    </div>

    @php($field = 'mt-1 block w-full rounded-lg border-neutral-300 text-neutral-900 focus:border-teal-700 focus:ring-teal-700')

    <div>
        <label for="fc-name" class="block text-sm font-medium text-neutral-800">Full name</label>
        <input id="fc-name" type="text" wire:model="fullName" autocomplete="name" class="{{ $field }}">
        @error('fullName') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="fc-phone" class="block text-sm font-medium text-neutral-800">Phone number</label>
        <input id="fc-phone" type="tel" wire:model="phone" autocomplete="tel" inputmode="tel" class="{{ $field }}">
        @error('phone') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="fc-email" class="block text-sm font-medium text-neutral-800">Email address</label>
        <input id="fc-email" type="email" wire:model="email" autocomplete="email" class="{{ $field }}">
        @error('email') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
    </div>

    @if($services->isNotEmpty())
        <div>
            <label for="fc-service" class="block text-sm font-medium text-neutral-800">Service you need <span class="font-normal text-neutral-500">(optional)</span></label>
            <select id="fc-service" wire:model="serviceId" class="{{ $field }}">
                <option value="">Not sure yet</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
            @error('serviceId') <p class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
        </div>
    @endif

    @error('submit') <p class="rounded-lg bg-red-50 p-3 text-sm text-red-800">{{ $message }}</p> @enderror

    <button type="submit" wire:loading.attr="disabled" wire:target="submit"
            class="w-full rounded-lg bg-teal-800 px-5 py-3.5 text-base font-semibold text-white hover:bg-teal-900 focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-300 disabled:opacity-60">
        <span wire:loading.remove wire:target="submit">Claim my free 2 weeks</span>
        <span wire:loading wire:target="submit">Sending your request...</span>
    </button>

    <p class="text-xs leading-relaxed text-neutral-500">
        By submitting, you agree to be contacted about this offer and accept our
        <a href="{{ route('privacy.policy') }}" class="underline">Privacy Policy</a>.
        Please don't include health details in this form.
    </p>
</form>
