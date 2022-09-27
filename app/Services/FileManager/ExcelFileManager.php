<?php

namespace App\Services\FileManager;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
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

    public function convertToJson(Collection $data)
    {
        $this->save($data->toJson());
    }

    private function save(string $json)
    {
        $newPath = preg_replace('/\..+$/', '.'.'json', $this->path);
        File::put($newPath, $json);
        File::delete($this->path);
    }
}