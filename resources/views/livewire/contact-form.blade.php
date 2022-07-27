<form wire:submit.prevent="getInTouch" class="bg-white shadow rounded p-4">
    <x-form.text-input wire:model.defer="contact_enquiry.name" name="contact_enquiry.name" label="Full Name" required />
    <x-form.text-input wire:model.defer="contact_enquiry.company" name="contact_enquiry.company" label="Company" required />
    <x-form.text-input type="email" wire:model.defer="contact_enquiry.email" name="contact_enquiry.email" label="Email Address" required />
    <x-form.text-input type="tel" wire:model.defer="contact_enquiry.phone" name="contact_enquiry.phone" label="Phone Number" required />
    <x-form.text-area wire:model.defer="contact_enquiry.message" name="contact_enquiry.message" label="Tell Us More" required />
    <button type="submit" class="btn btn-primary btn-block mt-4">Get In Touch</button>
</form>
