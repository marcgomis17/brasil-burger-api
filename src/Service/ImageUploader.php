<?php

namespace App\Service;

class ImageUploader {
    private $denormalizer;

    public function __construct() {
        $this->denormalizer = new UploadedFileDenormalizer();
    }

    public function upload($image) {
        $this->denormalizer->denormalize($image, String::class);
        $blob = base64_encode(file_get_contents($image));
        return $blob;
    }
}
