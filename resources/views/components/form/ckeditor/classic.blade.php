@props(['id' => 'editor', 'class' => ''])
<div wire:ignore class="{{ $class }}">
    <textarea {{ $attributes }} id="{{ $id }}"></textarea>
    <script>
        ClassicEditor
            .create( document.querySelector( '#{{ $id }}' ) )
            @if ($attributes->has('wire:model'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('{{ $attributes->get('wire:model') }}', editor.getData());
                    })
                })
            @endif
            .catch( error => {
                console.error( error );
            } );
    </script>
</div>
