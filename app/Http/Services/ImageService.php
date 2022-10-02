<?php

namespace App\Http\Services;

use App\Http\Requests\UploadImageRequest;
use App\Models\Image;
use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageService
{
    //
    /**
     * Upload Image
     *
     * @param Request $request
     */
    public function upload(UploadImageRequest $request)
    {
        $fileData = $this->uploadFile($request->file('image'));

        $image = Image::create([
            'filename' => $fileData['filename'],
            'url' => $fileData['url'],
            'user_id' => Auth::user()->id
        ]);

        return response()->json($image);
    }


    public function uploadFile(
        UploadedFile $uploadedFile
    )
    {
        $prefix = Str::random(15) . '_' . time();
        $fileName = $prefix . '.' . $uploadedFile->getClientOriginalExtension();
        $disk = config('filesystems.default');

        $file = $uploadedFile->storePubliclyAs('public', $fileName, $disk);
        $url = $disk === 's3' ? $this->getS3Url($file) : Storage::url($file);

        return [
            'filename' => $fileName,
            'url' => $url,
        ];
    }

    public function getS3Url($fileName) {
        $bucket = config('filesystems.disks.s3.bucket');
        $region = config('filesystems.disks.s3.region');

        return 'https://' . $bucket . '.s3-' . $region . '.amazonaws.com/' . $fileName;
    }

    public function addCustomImageToItem(Item $item, $image)
    {
        $fileData = $this->uploadFile($image);
        $item->image = $fileData['url'];
        $item->save();
    }
}
