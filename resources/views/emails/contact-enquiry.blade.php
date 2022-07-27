@component('mail::message')

@component('mail::table')
    |               |               |
    | ------------- |---------------|
    | Name          | {{ $enquiry->name }}      |
    | Company       | {{ $enquiry->company }}      |
    | Email         | {{ $enquiry->email }}      |
    | Phone         | {{ $enquiry->phone }}      |
    | Message       | {{ $enquiry->message }}      |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
