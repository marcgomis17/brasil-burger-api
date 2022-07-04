<?php

namespace App\DataPersister;

use App\Entity\Produit;
use App\Service\ImageUploader;
use App\Service\MultipartDecoder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Repository\TailleBoissonRepository;
use Symfony\Component\Security\Core\Security;

final class ProduitPersister implements DataPersisterInterface {
    private $decoder;
    private $uploader;
    private $em;
    private $security;
    private $tailleRepo;

    public function __construct(RequestStack $request, ImageUploader $uploader, EntityManagerInterface $entityManagerInterface, Security $security, TailleBoissonRepository $tailleBoissonRepository) {
        $this->decoder = new MultipartDecoder($request);
        $this->uploader = $uploader;
        $this->em = $entityManagerInterface;
        $this->security = $security;
        $this->tailleRepo = $tailleBoissonRepository;
    }

    public function supports($data): bool {
        return $data instanceof Produit;
    }

    public function persist($data) {
        $body = $this->decoder->decode($data::class, $this->decoder::FORMAT);
        $data->setNom($body['nom']);
        $data->setPrix((int)$body['prix']);
        $data->setImage($this->uploader->upload($body['image']));
        $data->setGestionnaire($this->security->getUser());
        if (isset($body['taille'])) {
            $data->addTaille($this->tailleRepo->findOneBy(['libelle' => $body['taille']]));
        }
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data) {
        $data->setIsAvailable(false);
    }

    /*
    public function persist($data) {
        
    }

    public function remove($data) {
    } */
}
