<div class="min-h-screen py-8 ">
    <div class="pg-container max-w-4xl">
        <div class="bg-white">
            <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}" class="w-full h-80 object-contain" />
            <div class="p-4 space-y-4">
                <div class="text-md font-bold">{{ $post->title }}</div>
                <div class="text-primary">{{ $post->publish_date->format('d M, Y') }}</div>
                <div class="text-xs">{{ $post->summary }}</div>
                <div>{!! $post->content !!}</div>
            </div>
        </div>
    </div>
</div>
