<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\MenuBurger;
use App\IService\ICalculPrix;
use App\Service\ImageUploader;
use App\Service\MultipartDecoder;
use App\Repository\BoissonRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PortionFriteRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\MenuPortionFrite;
use App\Entity\MenuTailleBoisson;
use App\Repository\BurgerRepository;
use App\Repository\TailleBoissonRepository;
use App\Service\FileUploader;

class MenuPersister implements DataPersisterInterface {
    private $decoder;
    private $uploader;
    private $em;
    private $security;
    private $burgerRepo;
    private $friteRepo;
    private $tailleRepo;
    private $calcul;

    public function __construct(
        RequestStack $requestStack,
        FileUploader $fileUploader,
        EntityManagerInterface $entityManagerInterface,
        Security $security,
        BurgerRepository $burgerRepo,
        PortionFriteRepository $portionFriteRepository,
        TailleBoissonRepository $tailleBoissonRepository,
        ICalculPrix $calcul
    ) {
        $this->decoder = new MultipartDecoder($requestStack);
        $this->request = $requestStack;
        $this->uploader = $fileUploader;
        $this->em = $entityManagerInterface;
        $this->security = $security;
        $this->burgerRepo = $burgerRepo;
        $this->friteRepo = $portionFriteRepository;
        $this->tailleRepo = $tailleBoissonRepository;
        $this->calcul = $calcul;
    }

    public function supports($data): bool {
        return $data instanceof Menu;
    }

    public function persist($data) {
        // dd($this->calcul->calculPrix($data));
        $body = $this->decoder->decode($data::class, $this->decoder::FORMAT);
        $menuBurger = new MenuBurger();
        $menuTaille = new MenuTailleBoisson();
        $menuFrite = new MenuPortionFrite();
        $data->setNom($body['nom']);
        $data->setImage($this->uploader->upload($body['image']));
        foreach ($body['menuBurgers'] as $burger) {
            $menuBurger->setQuantite($burger['quantite']);
            foreach ($burger['burgers'] as $id) {
                $menuBurger->setBurgers($this->burgerRepo->findOneBy(['id' => $id]));
            }
        }
        foreach ($body['menuTailleBoisson'] as $taille) {
            $menuTaille->setQuantite($taille['quantite']);
            foreach ($taille['tailles'] as $id) {
                $menuTaille->setTailles($this->tailleRepo->findOneBy(['id' => $id]));
            }
        }
        foreach ($body['menuPortionFrite'] as $frite) {
            $menuFrite->setQuantite($frite['quantite']);
            foreach ($frite['frites'] as $id) {
                $menuFrite->setFrites($this->friteRepo->findOneBy(['id' => $id]));
            }
        }
        $data->addMenuFrite($menuFrite);
        $data->addMenuTaille($menuTaille);
        $data->setGestionnaire($this->security->getUser());
        $data->setPrix($this->calcul->calculPrix($data));
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data) {
    }
}
