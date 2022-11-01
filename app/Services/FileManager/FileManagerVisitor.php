<?php

namespace App\Services\FileManager;

class FileManagerVisitor
{
    public FileManagerInterface $visit;

    public function __construct(FileManagerInterface $visit)
    {
        $this->visit = $visit;
    }
}
