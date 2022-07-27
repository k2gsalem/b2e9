<?php


namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasImage
{
    protected $defaultImageSize = '150';
    protected $defaultImageText = '';
    protected $defaultImageBgColor = '';
    protected $defaultImageTextColor = '';

    public function updateImage(UploadedFile $image)
    {
        tap($this->image_path, function ($previous) use ($image) {
            $this->forceFill([
                'image_path' => $image->storePublicly(
                    'images', ['disk' => $this->imageDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->imageDisk())->delete($previous);
            }
        });
    }

    public function deleteImage()
    {
        Storage::disk($this->imageDisk())->delete($this->image_path);

        $this->forceFill([
            'image_path' => null,
        ])->save();
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path
            ? Storage::disk($this->imageDisk())->url($this->image_path)
            : $this->defaultImageUrl();
    }

    protected function defaultImageUrl()
    {
        $url = 'https://via.placeholder.com/'.$this->defaultImageSize;
        if (!empty($this->defaultImageBgColor))
            $url .= '/'.$this->defaultImageBgColor;
        if (!empty($this->defaultImageTextColor))
            $url .= '/'.$this->defaultImageTextColor;
        if (!empty($this->defaultImageText()))
            $url .= '?text='.urlencode($this->defaultImageText());
//        return $url;
        return "https://picsum.photos/seed/".$this->id."/".$this->defaultImageSize;
//        return 'https://ui-avatars.com/api/?name='.urlencode($this->title).'&color=7F9CF5&background=EBF4FF';
    }

    protected function imageDisk()
    {
        return 'public';
    }

    protected function defaultImageText()
    {
        return $this->title ?: $this->defaultImageText;
    }
}
