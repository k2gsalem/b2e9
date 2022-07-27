<div class="min-h-screen py-8 ">
    <div class="pg-container">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($posts as $post)
                <a href="{{ route('post', $post) }}" class="bg-white">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image) }}" class="w-full h-60 object-cover" />
                    <div class="p-4 space-y-4">
                        <div class="text-md font-bold line-clamp-1">{{ $post->title }}</div>
                        <div>{{ $post->publish_date->format('d M, Y') }}</div>
                        <div class="text-xs line-clamp-5">{{ $post->summary }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
