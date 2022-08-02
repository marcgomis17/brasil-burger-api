<?php

namespace App\Service;

use App\IService\IFileUploader;
use Symfony\Component\HttpFoundation\File\File;

class FileUploader implements IFileUploader {
    private $denormalizer;

    public function __construct() {
        $this->denormalizer = new UploadedFileDenormalizer();
    }

    public function upload($image) {
        $this->denormalizer->denormalize($image, File::class);
        $blob = base64_encode(file_get_contents($image));
        return $blob;
    }
}
