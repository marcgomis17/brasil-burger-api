<?php

namespace App\Service;

use App\IService\IFileUploader;

class FileUploader implements IFileUploader {
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
