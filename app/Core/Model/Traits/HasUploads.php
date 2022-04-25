<?php

namespace App\Core\Model\Traits;

use Chumper\Zipper\Zipper;
use Storage;

trait HasUploads
{

    public function getAttributeUrl($key)
    {
        $value = $this->getAttribute($key);
        return $value ? Storage::url(static::MEDIA_PATH . $value) : false;
    }

    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value) {
            if(!empty($this->mediaFields) && in_array($key, $this->mediaFields)) {
                if(!empty($value['file']) && $value['file'] instanceof \Illuminate\Http\UploadedFile) {
                    $value = $this->_uploadFile($value['file']);
                    $attributes[$key] = $value;
                }
                // elseif(strpos($value, 'tmp/') === 0) {
                //     $value = $this->_moveFromTmp($value);
                //     $attributes[$key] = $value;
                // }
            }
        }
        return parent::fill($attributes);
    }

    protected function _uploadFile($file)
    {
        $path = 'public' . DIRECTORY_SEPARATOR . static::MEDIA_PATH;
        $fileName = $file->getClientOriginalName();
        $path .= substr($fileName, 0, 1) . DIRECTORY_SEPARATOR . substr($fileName, 1, 1) . DIRECTORY_SEPARATOR;
        if(Storage::disk('local')->exists($path . $fileName)) {
            $iterator = 1;
            while(Storage::disk('local')->exists($path . $fileName)) {
                $fileName = str_replace(
                    '.' . $file->getClientOriginalExtension(),
                    $iterator++ . '.' . $file->getClientOriginalExtension(),
                    $file->getClientOriginalName()
                );
            }
        }

        $file->storeAs($path, $fileName);
        return substr($fileName, 0, 1) . '/' . substr($fileName, 1, 1) . '/' . $fileName;
    }

    protected function _moveFromTmp($file)
    {
        $oldPath = 'public' . DIRECTORY_SEPARATOR;
        $newPath = 'public' . DIRECTORY_SEPARATOR . static::MEDIA_PATH;

        $file = trim($file, '|');
        if(strpos($file, '|') !== false) {
            $archiveName = 'tmp/' . time() . '.zip';
            $zipper = new Zipper();
            $zipper->zip(storage_path('app/') . $oldPath . $archiveName);
            $files = explode('|', $file);
            foreach($files as $fileName) {
                $zipper->add(storage_path('app/') .  $oldPath . trim($fileName));
            }

            $zipper->close();
            $file = $archiveName;

            foreach($files as $fileName) {
                Storage::delete($oldPath . $fileName);
            }
        }

        $fileName = explode('/', $file);
        $fileName = array_pop($fileName);
        $fileExtension = explode('.', $fileName);
        $fileExtension = array_pop($fileExtension);
        $newPath .= substr($fileName, 0, 1) . DIRECTORY_SEPARATOR . substr($fileName, 1, 1) . DIRECTORY_SEPARATOR;

        if(Storage::disk('local')->exists($newPath . $fileName)) {
            $iterator = 1;
            while(Storage::disk('local')->exists($newPath . $fileName)) {
                $fileName = str_replace(
                    '.' . $fileExtension,
                    $iterator++ . '.' . $fileExtension,
                    $fileName
                );
            }
        }
        Storage::move($oldPath . $file, $newPath . $fileName);
        return substr($fileName, 0, 1) . '/' . substr($fileName, 1, 1) . '/' . $fileName;
    }

    public function toArray()
    {
        $data = parent::toArray();
        foreach ($this->mediaFields as $key) {
            $data[$key . '_url'] = $this->getAttributeUrl($key);
        }
        return $data;

    }

}
