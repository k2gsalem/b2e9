<div x-data="{ id: $id('faq-item') }" @click="toggle(id)"
     tabindex="0"
     class="bg-white shadow cursor-pointer">
    <div class="flex justify-between gap-4 text-xl p-4" :class="{ 'bg-secondary text-secondary-content': isActive(id) }">
        <span>{{ $title }}</span>
        <span x-text="isActive(id) ? '-' : '+'"></span>
    </div>
    <div x-show="isActive(id)" class="p-4">
        {{ $slot }}
    </div>
</div>
