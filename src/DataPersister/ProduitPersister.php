<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Produit;
use App\IService\ICalculPrix;
use App\IService\IFileUploader;
use App\Service\MultipartDecoder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProduitPersister implements DataPersisterInterface {
    private MultipartDecoder $decoder;
    private RequestStack $request;
    private IFileUploader $uploader;
    private EntityManagerInterface $em;
    private ICalculPrix $calcul;
    private TokenStorageInterface $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, IFileUploader $fileUploader, RequestStack $requestStack, ICalculPrix $calculator, TokenStorageInterface $tokenStorage) {
        $this->request = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->decoder = new MultipartDecoder($this->request);
        $this->uploader = $fileUploader;
        $this->calcul = $calculator;
        $this->em = $entityManager;
    }

    public function supports($data): bool {
        return $data instanceof Produit;
    }

    public function persist($data) {
        $body = $this->decoder->decode($data::class, $this->decoder::FORMAT);
        $data->setIsAvailable(true);
        $data->setGestionnaire($this->tokenStorage->getToken()->getUser());
        $data->setNom($body['nom']);
        $data->setImage($this->uploader->upload($body['image']));

        if (!($data instanceof Menu)) {
            $data->setPrix((int)$body['prix']);
        }

        if ($data instanceof Menu) {
            $data->setPrix($this->calcul->calculPrix($data));
        }
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data) {
        $data->setIsAvailable(false);
        $this->em->persist($data);
        $this->em->flush();
    }
}
