<div class="pg-container max-w-4xl flex flex-col gap-8 items-center justify-center py-16">
    <img src="{{ asset('img/pg-auth.png') }}" class="w-96" />

    @php
    $referralLink = route('register').'?referral_code='.auth()->user()->referral_code;
    @endphp
    <div x-data="{referralLink: '{{ $referralLink }}'}" class="flex items-end gap-6 w-full">
        <x-form.text-input type="text" name="referral-link" x-model="referralLink" class="grow" readonly />
        <button type="button" @click="$clipboard(referralLink)" class="btn btn-primary">Copy Link</button>
    </div>

    <div>Share it through social media platform</div>
    <div class="flex justify-center gap-8">
        <a href="https://www.facebook.com/sharer.php?u={{ urlencode($referralLink) }}" target="_blank">
            <img src="{{ asset('img/icons/sm/40x40/facebook.png') }}" class="w-10 h-10" />
        </a>
        <a class="hidden" href="{{ urlencode($referralLink) }}" target="_blank">
            <img src="{{ asset('img/icons/sm/40x40/signal.png') }}" class="w-10 h-10" />
        </a>
        <a href="https://wa.me/?text={{ urlencode($referralLink) }}" target="_blank">
            <img src="{{ asset('img/icons/sm/40x40/whatsapp.png') }}" class="w-10 h-10" />
        </a>
        <a href="https://telegram.me/share/url?url={{ urlencode($referralLink) }}" target="_blank">
            <img src="{{ asset('img/icons/sm/40x40/telegram.png') }}" class="w-10 h-10" />
        </a>
        <a class="hidden" href="{{ urlencode($referralLink) }}" target="_blank">
            <img src="{{ asset('img/icons/sm/40x40/instagram.png') }}" class="w-10 h-10" />
        </a>
    </div>
    <div class="border-b border-gray-600 max-w-sm w-full"></div>
    @livewire('invite-sms-form')
    @livewire('invite-email-form')
</div>
