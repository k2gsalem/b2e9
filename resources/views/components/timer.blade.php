@props(['value' => time(), 'reload' => "true"])
<div x-data="timer(new Date(Date.parse('{{ $value }}')), {!! $reload !!})" x-init="init();"
     {!! $attributes->merge(['class' => 'flex ']) !!}>
    <h1 x-show="time().days > 0" class="after:content-[':']" x-text="time().days"></h1>
    <h1 x-show="time().hours > 0 || time().days > 0" class="after:content-[':']" x-text="time().hours"></h1>
    <h1 x-show="time().minutes > 0 || time().hours > 0 || time().days > 0" class="after:content-[':']" x-text="time().minutes"></h1>
    <h1 x-text="time().seconds"></h1>
</div>
