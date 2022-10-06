<?php

namespace App\Services\FileManager;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class ExcelFileManager implements FileManagerInterface
{
    public string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function read() : Collection
    {
        return (new FastExcel)->import($this->path);
    }

    public function moveToJson(Collection $data)
    {
        $jsonPath = preg_replace('/\..+$/', '.' . 'json', $this->path);

        File::move($this->path, $jsonPath);
        File::put($jsonPath, $data);
    }
}