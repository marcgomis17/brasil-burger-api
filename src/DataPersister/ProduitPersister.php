<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Entity\MenuBurger;
use App\IService\ICalculPrix;
use App\IService\IFileUploader;
use App\Entity\MenuPortionFrite;
use App\Entity\MenuTailleBoisson;
use App\Service\MultipartDecoder;
use App\Repository\BurgerRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PortionFriteRepository;
use App\Repository\TailleBoissonRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Boisson;
use App\Entity\Burger;
use App\Entity\PortionFrite;

final class ProduitPersister implements DataPersisterInterface {
    private $decoder;
    private $uploader;
    private $em;
    private $security;
    private $burgerRepo;
    private $tailleRepo;
    private $friteRepo;
    private $calcul;

    public function __construct(
        RequestStack $request,
        IFileUploader $uploader,
        EntityManagerInterface $entityManagerInterface,
        Security $security,
        BurgerRepository $burgerRepo,
        TailleBoissonRepository $tailleBoissonRepository,
        PortionFriteRepository $portionFriteRepository,
        ICalculPrix $calcul
    ) {
        $this->decoder = new MultipartDecoder($request);
        $this->uploader = $uploader;
        $this->em = $entityManagerInterface;
        $this->security = $security;
        $this->burgerRepo = $burgerRepo;
        $this->tailleRepo = $tailleBoissonRepository;
        $this->friteRepo = $portionFriteRepository;
        $this->calcul = $calcul;
    }

    public function supports($data): bool {
        return $data instanceof Produit;
    }

    public function persist($data) {
        $body = $this->decoder->decode($data::class, $this->decoder::FORMAT);
        $data->setNom($body['nom']);
        $data->setImage($this->uploader->upload($body['image']));
        $data->setIsAvailable(true);
        $data->setGestionnaire($this->security->getUser());
        if ($data instanceof Burger) $data->setType('burger');
        if ($data instanceof PortionFrite) $data->setType('frite');
        if ($data instanceof Menu) $data->setType('menu');
        if ($data instanceof Boisson) $data->setType('boisson');

        /* if (isset($body['taille'])) {
            foreach ($body['taille'] as $taille) {
                $data->addTaille($this->tailleRepo->findOneBy(['id' => $taille['id']]));
            }
        } */

        if (!($data instanceof Menu)) {
            $data->setPrix((int)$body['prix']);
        }

        if ($data instanceof Menu) {
            $menuBurger = new MenuBurger();
            $menuTaille = new MenuTailleBoisson();
            $menuFrite = new MenuPortionFrite();
            foreach ($body['menuBurgers'] as $burger) {
                $menuBurger->setQuantite($burger['quantite']);
                $menuBurger->setBurger($this->burgerRepo->findOneBy(['id' => $burger['burger']['id']]));
            }
            foreach ($body['menuTailles'] as $taille) {
                $menuTaille->setQuantite($taille['quantite']);
                $menuTaille->setTailles($this->tailleRepo->findOneBy(['id' => $taille['tailles']['id']]));
            }
            foreach ($body['menuFrites'] as $frite) {
                $menuFrite->setQuantite($frite['quantite']);
                $menuFrite->setFrites($this->friteRepo->findOneBy(['id' => $frite['frites']['id']]));
            }
            $data->addMenuBurger($menuBurger);
            $data->addMenuFrite($menuFrite);
            $data->addMenuTaille($menuTaille);
            $data->setPrix($this->calcul->calculPrix($data));
        }
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data) {
        $data->setIsAvailable(false);
    }
}
