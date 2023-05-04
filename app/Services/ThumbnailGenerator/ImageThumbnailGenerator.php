<?php

namespace App\Services\ThumbnailGenerator;

use Intervention\Image\Image;
use Intervention\Image\Facades\Image as ImageFacade;

class ImageThumbnailGenerator
{
    protected int $minHeight = 5;
    protected int $minWidth = 5;
    /**
     * @param mixed $image
     *
     * @return \Intervention\Image\Image
     */
    public function makeImage(mixed $image): Image
    {
        return ImageFacade::make($image);
    }

    /**
     * @param int                       $width
     * @param int                       $height
     * @param \Intervention\Image\Image $image
     *
     * @return void
     */
    public function imageResizer(int $width, int $height, Image $image): void
    {
        if ($width < $this->minWidth) {
            $width = $this->minWidth;
        }

        if ($height < $this->minHeight) {
            $height = $this->minHeight;
        }

        $image->resize($width, $height);
    }
}