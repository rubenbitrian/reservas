<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

//$2y$13$rEmuKfXhlxMnsGF2A1D.IeI8Uh3UCJRMimMVtceT2kEOl0HzzP696
//admin1234

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface {

  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=180, unique=true)
   */
  private $email;

  /**
   * @ORM\Column(type="string", length=180)
   */
  private $name;

  /**
   * @ORM\Column(type="string", length=200)
   */
  private $surnames;

  /**
   * @ORM\Column(type="json")
   */
  private $roles = [];

  /**
   * @var string The hashed password
   * @ORM\Column(type="string")
   */
  private $password;

  /**
   * @ORM\ManyToOne(targetEntity=UserGroup::class, inversedBy="users")
   * @ORM\JoinColumn(nullable=true)
   */
  private $userGroup;

  public function __toString() {
    return $this->email;
  }

  public function getId():?int {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param   string  $name
   */
  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  /**
   * @return string
   */
  public function getSurnames() {
    return $this->surnames;
  }

  /**
   * @param   string  $surnames
   */
  public function setSurnames($surnames) {
    $this->surnames = $surnames;

    return $this;
  }

  public function getEmail():?string {
    return $this->email;
  }

  public function setEmail(string $email):self {
    $this->email = $email;

    return $this;
  }

  /**
   * A visual identifier that represents this user.
   *
   * @see UserInterface
   */
  public function getUserIdentifier() {
    return (string) $this->email;
  }

  /**
   * @deprecated since Symfony 5.3, use getUserIdentifier instead
   */
  public function getUsername():string {
    return (string) $this->email;
  }

  /**
   * @see UserInterface
   */
  public function getRoles():array {
    $roles = $this->roles;
    // guarantee every user at least has ROLE_USER
    $roles[] = 'ROLE_USER';

    return array_unique($roles);
  }

  public function setRoles(array $roles):self {
    $this->roles = $roles;

    return $this;
  }

  /**
   * @see PasswordAuthenticatedUserInterface
   */
  public function getPassword():string {
    return $this->password;
  }

  public function setPassword(string $password):self {
    $this->password = $password;

    return $this;
  }

  /**
   * Returning a salt is only needed, if you are not using a modern
   * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
   *
   * @see UserInterface
   */
  public function getSalt():?string {
    return NULL;
  }

  /**
   * @see UserInterface
   */
  public function eraseCredentials() {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;
  }

  public function getUserGroup():?userGroup {
    return $this->userGroup;
  }

  public function setUserGroup(?userGroup $userGroup):self {
    $this->userGroup = $userGroup;

    return $this;
  }

}
