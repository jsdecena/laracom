<?php

namespace App\Shop\Tools;

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
    public function uploadOne($file, $folder = null, $disk = 'uploads')
    {
        return request()->file('cover')->storeAs(
            $folder, str_random(25) . "." . $file->getClientOriginalExtension(), $disk
        );
    }
}