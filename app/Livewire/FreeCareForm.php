<?php

namespace App\Livewire;

use App\Mail\EnquirySubmittedMail;
use App\Models\Appointment;
use App\Models\Service;
use App\Support\SiteSettings;
use App\Support\SupportContact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Throwable;

class FreeCareForm extends Component
{
    public string $fullName = '';
    public string $phone = '';
    public string $email = '';
    public string $serviceId = '';
    public string $honeypot = '';

    /** Ad tracking values read from the landing URL; locked so the browser can't edit them. */
    #[Locked]
    public array $tracking = [];

    public function mount(): void
    {
        // Livewire's later requests don't carry the page's query string, so
        // capture it once here and keep it until the form is submitted.
        $keys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term', 'utm_id', 'fbclid', 'gclid', 'fbc_id', 'h_ad_id'];

        $this->tracking = collect($keys)
            ->mapWithKeys(fn (string $key): array => [$key => request()->query($key)])
            ->filter(fn ($value): bool => is_string($value) && $value !== '')
            ->map(fn (string $value): string => mb_substr($value, 0, 255))
            ->all();

        $this->tracking['landing_url'] = mb_substr(request()->fullUrl(), 0, 500);
        $this->tracking['referrer'] = mb_substr((string) request()->headers->get('referer'), 0, 500);
    }

    public function submit()
    {
        $data = $this->validate([
            'fullName' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:7', 'max:50'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'serviceId' => ['nullable', Rule::in($this->services()->pluck('id')->map(fn ($id) => (string) $id)->all())],
            'honeypot' => ['nullable', 'max:0'],
        ], [], [
            'fullName' => 'full name',
            'serviceId' => 'service',
        ]);

        if ($this->honeypot !== '') {
            return $this->redirectRoute('landing.free-care.thanks');
        }

        // Save the lead first. Nothing after this point may show the visitor an error.
        try {
            $lead = Appointment::query()->create([
                'full_name' => $data['fullName'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'service_id' => $data['serviceId'] ?: null,
                'message' => "I'd like to claim the 2 weeks free offer.",
                'source' => 'landing_free_care',
                'status' => Appointment::STATUS_NEW,
                'meta' => [
                    'form' => 'landing.free-care',
                    'offer' => 'free_two_weeks',
                    'tracking' => $this->tracking,
                    'ip' => request()->ip(),
                    'user_agent' => mb_substr((string) request()->userAgent(), 0, 500),
                ],
            ]);
        } catch (Throwable $e) {
            report($e);
            $this->addError('submit', 'Something went wrong and your request was not saved. Please try again or call us.');

            return null;
        }

        // Confirmation email is best-effort: a mail failure must never undo or hide a saved lead.
        try {
            $mailable = new EnquirySubmittedMail($lead);
            $from = SiteSettings::enquiriesEmail();

            if (filled($from)) {
                $mailable->from($from, SiteSettings::fromName());
            }

            $mail = Mail::to($lead->email);
            $support = SupportContact::email();

            if ($support && strcasecmp($support, $lead->email) !== 0) {
                $mail->cc($support);
            }

            $mail->send($mailable);
        } catch (Throwable $e) {
            report($e);
        }

        session()->flash('free_care_submitted', true);

        return $this->redirectRoute('landing.free-care.thanks');
    }

    protected function services()
    {
        try {
            return Service::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')->get(['id', 'name']);
        } catch (Throwable) {
            return collect();
        }
    }

    public function render()
    {
        return view('livewire.free-care-form', ['services' => $this->services()]);
    }
}
