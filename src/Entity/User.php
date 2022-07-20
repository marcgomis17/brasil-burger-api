<?php

namespace App\Entity;

use DateTime;
use App\DTO\UserInput;
use App\DTO\UserOutput;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[InheritanceType("JOINED")]
#[DiscriminatorColumn(name: "discr", type: "string")]
#[DiscriminatorMap(
    [
        "gestionnaire" => "Gestionnaire",
        "client" => "Client",
        "livreur" => "Livreur",
    ]
)]
#[ApiResource(input: UserInput::class, output: UserOutput::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    // #[Groups(['users:read', 'product:write', 'product:read', 'product:read:post', 'menu:write', 'menu:read:post', 'orders:write'])]
    private $id;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    // #[Groups(['users:write', 'users:read', 'menu:read:post'])]
    private $prenom;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    // #[Groups(['users:write', 'users:read', 'menu:read:post'])]
    private $nom;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    // #[Groups(['users:write', 'users:read', 'menu:read:post'])]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[SerializedName('password')]
    #[Groups(['users:write'])]
    private $plainPassword;

    #[ORM\Column(type: 'string')]
    #[Groups(['users:read'])]
    private $password;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isVerified;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $token;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $expireAt;

    public function __construct() {
        $this->setIsVerified(false);
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(?string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getToken(): ?string {
        return $this->token;
    }

    public function setToken(string $token): self {
        $this->token = $token;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface {
        return $this->expireAt;
    }

    public function setExpireAt(?\DateTimeInterface $expireAt): self {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function isIsVerified(): ?bool {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function generateToken() {
        $this->setToken(rtrim(strtr(base64_encode(random_bytes(64)), '+/', '-_'), '='));
        $this->setExpireAt(new DateTime('+ 1 days'));
    }

    public function getPlainPassword(): ?string {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
