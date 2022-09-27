<?php

namespace App\Services\FileManager;

class FileManagerVisitor
{
    public FileManagerInterface $visitor;

    public function __construct(FileManagerInterface $visitor)
    {
        $this->visitor = $visitor;
    }
}