<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader {
    private $denormalizer;

    public function __construct() {
        $this->denormalizer = new UploadedFileDenormalizer();
    }

    public function upload($image) {
        $this->denormalizer->denormalize($image, UploadedFile::class);
        $blob = file_get_contents(base64_encode($image));
        return $blob;
    }
}
