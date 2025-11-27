<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Add this import

class BrandService
{
    protected ImageManager $manager;

    public function __construct()
    {
        // Explicitly create manager with GD driver — fully type-safe
        $this->manager = new ImageManager(new Driver());
    }

    public function handleImage(UploadedFile $image, ?string $oldImagePath = null, int $width = 100, int $height = 90): string
    {
        $name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $path = 'upload/brand/' . $name;

        $img = $this->manager->read($image);
        $img->resize($width, $height);
        $img->save(public_path($path));

        // Delete old image if exists
        if ($oldImagePath && file_exists(public_path($oldImagePath))) {
            @unlink(public_path($oldImagePath));
        }

        return $path;
    }
}