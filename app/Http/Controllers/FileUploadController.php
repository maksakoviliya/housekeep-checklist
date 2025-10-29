<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Livewire\Features\SupportFileUploads\FileUploadConfiguration;

class FileUploadController extends \Livewire\Features\SupportFileUploads\FileUploadController
{
    public function handle(): array
    {
        // abort_unless(request()->hasValidSignature(), 401);

        $disk = FileUploadConfiguration::disk();

        $filePaths = $this->validateAndStore(request('files'), $disk);

        return ['paths' => $filePaths];
    }
}
