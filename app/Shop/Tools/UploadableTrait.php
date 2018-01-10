<?php

namespace App\Shop\Tools;

use Illuminate\Http\UploadedFile;

trait UploadableTrait
{
    /**
     * Upload a single file in the server
     *
     * @param $file
     * @param null $folder
     * @param string $disk
     * @return false|string
     */
    public function uploadOne(UploadedFile $file, $folder = null, $disk = 'public')
    {
        return $file->storeAs($folder, str_random(25) . "." . $file->getClientOriginalExtension(), $disk);
    }
}