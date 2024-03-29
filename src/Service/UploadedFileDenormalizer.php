<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class UploadedFileDenormalizer implements DenormalizerInterface {
    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool {
        return $data instanceof UploadedFile;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, string $type, string $format = null, array $context = []): UploadedFile {
        return $data;
    }
}
