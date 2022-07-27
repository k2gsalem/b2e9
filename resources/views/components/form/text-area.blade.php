@props(['label' => '', 'name' => '', 'class' => ''])
<div class="pt-5 {{ $class }}">
    <div class="relative">
        <textarea placeholder="{{ $label }}" class="peer w-full min-h-40 pl-3 py-2 text-lg rounded-lg border border-gray-300 text-gray-500 placeholder-transparent focus:outline-none focus:ring-transparent focus:border-2 focus:border-secondary"
               {!! $attributes !!}
        ></textarea>
        <label class="absolute left-3 -top-3.5 text-gray-600 text-base transition-all bg-white px-2 rounded-lg
                        peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-placeholder-shown:px-0
                        peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-base peer-focus:px-2">
            {{ $label }} @if($attributes->has('required')) <span class="text-error">*</span> @endif
        </label>
    </div>
    @error($name)<span class="text-error text-sm pl-2">{{ $message }}</span> @enderror
</div>
