<?php

declare(strict_types=1);

namespace App\Services;

final class ImageService
{
    public function storeImage($image, string $directory = 'images'): string
    {
        return $image->store($directory, 'public');
    }
}