@component('mail::message')
@if($image)
![]({{ $image }})
@endif

@if($content)
{!! $content !!}
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
