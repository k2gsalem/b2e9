<div wire:ignore
     x-data
     x-init="() => {
        const fp = FilePond.create($refs.input);
        fp.setOptions({
            credits: null,
            allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
            allowImagePreview: {{ $attributes->has('allowImagePreview') ? 'true' : 'false' }},
            imagePreviewHeight: {{ $attributes->has('imagePreviewHeight') ? $attributes->get('imagePreviewHeight') : '250' }},
            allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
            acceptedFileTypes: {{ $attributes->has('acceptedFileTypes') ? $attributes->get('acceptedFileTypes') : '[]' }},
            allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
            maxFileSize: '{{ $attributes->has('maxFileSize') ? $attributes->get('maxFileSize') : '"1MB"' }}',
            maxTotalFileSize: '{{ $attributes->has('maxTotalFileSize') ? $attributes->get('maxTotalFileSize') : '"1MB"' }}',
            server: {
                process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes->whereStartsWith('wire:model')->first() }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes->whereStartsWith('wire:model')->first() }}', filename, load)
                },
            }
        });
     }"
>
    <input type="file" x-ref="input" />
    @error($attributes->whereStartsWith('wire:model')->first())
    <p class="mt-2 text-sm text-error">{{ $message }}</p>
    @enderror
</div>

@push('styles')
    @once
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    @endonce
@endpush

@push('scripts')
    @once
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script>
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginFileValidateSize);
            FilePond.registerPlugin(FilePondPluginImagePreview);
        </script>
    @endonce
@endpush
