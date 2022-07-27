<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProjectAttachment extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'file_name',
    ];

    protected $appends = [
        'file_url'
    ];

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    protected function storageDisk()
    {
        return 'public';
    }

    public function updateImage(UploadedFile $image)
    {
        tap($this->image_path, function ($previous) use ($image) {
            $this->forceFill([
                'file_path' => $image->storePublicly(
                    'project-attachments', ['disk' => $this->storageDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->storageDisk())->delete($previous);
            }
        });
    }

    public function deleteImage()
    {
        Storage::disk($this->storageDisk())->delete($this->image_path);

        $this->forceFill([
            'file_path' => null,
        ])->save();
    }

    public function getFileUrlAttribute()
    {
        return Storage::disk($this->storageDisk())->url($this->image_path);
    }
}
