<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Service\ImageUploader;
use App\Service\MultipartDecoder;
use App\Repository\BurgerRepository;
use App\Repository\BoissonRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\UploadedFileDenormalizer;
use App\Repository\PortionFriteRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class MenuPersister implements DataPersisterInterface {
    private $decoder;
    private $uploader;
    private $em;
    private $security;
    private $burgerRepo;
    private $friteRepo;
    private $boissonRepo;

    public function __construct(
        RequestStack $requestStack,
        ImageUploader $uploader,
        EntityManagerInterface $entityManagerInterface,
        Security $security,
        BurgerRepository $burgerRepository,
        PortionFriteRepository $portionFriteRepository,
        BoissonRepository $boissonRepository
    ) {
        $this->decoder = new MultipartDecoder($requestStack);
        $this->request = $requestStack;
        $this->uploader = $uploader;
        $this->em = $entityManagerInterface;
        $this->security = $security;
        $this->burgerRepo = $burgerRepository;
        $this->friteRepo = $portionFriteRepository;
        $this->boissonRepo = $boissonRepository;
    }

    public function supports($data): bool {
        return $data instanceof Menu;
    }

    public function persist($data) {
        $body = $this->decoder->decode($data::class, $this->decoder::FORMAT);
        $data->setNom($body['nom']);
        $data->setPrix((int)$body['prix']);
        $data->setImage($this->uploader->upload($body['image']));
        foreach ($body['burgers'] as $element) {
            $burgers = $this->burgerRepo->findBy(['id' => $element['id']]);
            foreach ($burgers as $burger) {
                $data->addBurger($burger);
            }
        }
        foreach ($body['frites'] as $element) {
            $frites = $this->friteRepo->findBy(['id' => $element['id']]);
            foreach ($frites as $frite) {
                $data->addFrite($frite);
            }
        }
        foreach ($body['boissons'] as $element) {
            $boissons = $this->boissonRepo->findBy(['id' => $element['id']]);
            foreach ($boissons as $boisson) {
                $data->addBoisson($boisson);
            }
        }
        $data->setGestionnaire($this->security->getUser());
        // dd($data);
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data) {
    }
}
