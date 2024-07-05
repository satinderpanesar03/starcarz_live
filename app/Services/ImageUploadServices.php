<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class ImageUploadService
{
    public function uploadImage(UploadedFile $file, $platform = 'local', $path = 'images')
    {
        // Generate a unique filename
        $filename = $this->generateUniqueFilename($file);
        // Store the image file in the specified path
        if($platform == 'local'){
            $filePath = $file->storeAs($path, $filename, 'public');
        }else if ($platform == 's3'){
            $filePath = $file->storeAs($path, $filename,'s3');
            Log::info('image upload', [$filePath]);
        }

        return $data = [
            'filepath' => $filePath,
            'filename' => $filename
        ];

    }

    private function generateUniqueFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();

        $filename = time() . '_' . Str::random(10) . '.' . $extension;
        return $filename;
    }

}
