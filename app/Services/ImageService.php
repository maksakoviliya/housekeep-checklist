<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;

final class ImageService
{
    public function storeImage(UploadedFile $image = null, string $directory = 'images'): ?string
    {
        return $image?->store($directory, 'public');
    }
}