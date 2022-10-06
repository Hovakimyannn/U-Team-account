<?php

namespace App\Services\FileManager;

use Illuminate\Support\Collection;

interface FileManagerInterface
{
    public function read();

    public function moveToJson(Collection $data);
}