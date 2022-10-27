<?php

namespace App\Services\FileManager;

use Illuminate\Support\Collection;

interface FileManagerInterface
{
    public function read();

    public function convertToJson(Collection $data);

    public function getPath();
}