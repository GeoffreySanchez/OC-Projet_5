<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *     fields = {"email"},
 *     message = "L'email que vous avez indiqué est déjà utilisé",
 * )
 * @UniqueEntity(
 *     fields = {"username"},
 *     message = "Cet utilisateur existe déjà"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe est trop court, 8 caractères minimum")
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Votre mot de passe doit être identique")
     */
    public $confirm_password;

    /**
     * @Assert\EqualTo(propertyPath="email", message="L'adresse mail doit être la même dans les deux champs")
     */
    public $confirm_email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tickets = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active = false;

    /**
     * @var array
     * @ORM\Column(type="string", length=255)
     */
    private $roles = 'ROLE_VISITOR';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        if($email == '')
        {
            $this->email = $this->email;
        }
        else
        {
            $this->email = $email;
        }


        return $this;
    }

    public function getAdresse(): ?string
    {

        return $this->adresse;
    }

    public function setAdresse($adresse): self
    {
        if($adresse == '') {
            $this->adresse = $this->adresse;
        } else {
            $this->adresse = $adresse;
        }
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        if($password == '') {
            $this->password = $this->password;
        } else {
            $this->password = $password;
        }
        return $this;
    }

    public function getTickets(): ?string
    {
        return $this->tickets;
    }

    public function setTickets(string $tickets): self
    {
        $this->tickets = $tickets;

        return $this;
    }

    public function getActive(): ?string
    {
        return $this->active;
    }

    public function setActive(string $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }


    public function getRoles():  ?array
    {
        return [$this->roles];
    }

    public function setRoles(string $roles): self
    {
            $this->roles = $roles;
        return $this;
    }
    
    public function handleUser(string $action)
    {
            if ($action == "valid") {
                $this->setActive(1);
                $this->setRoles("ROLE_USER");
            }
            elseif ($action == "upToAdmin") {
                $this->setRoles("ROLE_ADMIN");
            }
            elseif($action == "ban") {
                $this->setActive(0);
                $this->setRoles("ROLE_VISITOR");
            }
            elseif($action == "downToUser") {
                $this->setRoles("ROLE_USER");
            }
    }
}
