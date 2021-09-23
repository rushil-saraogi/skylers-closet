<?php

namespace App\Http\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public function storeImage($image)
    {
        $url = null;

        if (env('APP_ENV') == 'local') {
            $url = $this->uploadFile($image, 'public', 'local');
        } else {
            $url = $this->uploadFile($image);
        }

        return $url;
    }

    public function uploadFile(
        UploadedFile $uploadedFile,
        $folder = null,
        $disk = 's3',
        $filename = null
    )
    {
        $prefix = !is_null($filename) ? $filename : Str::random(25);
        $fileName = $prefix . '.' . $uploadedFile->getClientOriginalExtension();

        $file = $uploadedFile->storePubliclyAs($folder, $fileName, $disk);

        return $disk == 's3' 
            ? $this->getS3Url($file)
            : Storage::url($file);
    }

    private function getS3Url($fileName) {
        $bucket = env('AWS_BUCKET');
        $region = env('AWS_DEFAULT_REGION');

        return 'https://' . $bucket . '.s3-' . $region . '.amazonaws.com/' . $fileName;
    }
}
