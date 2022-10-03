<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $questions = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTreated = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    // public function getQuestion(): ?array
    // {
    //     return $this->question;
    // }

    // public function setQuestion(array $question): self
    // {
    //     $this->question = $question;

    //     return $this;
    // }
    
    public function getQuestion(): ?array
    {
        return $this->questions;
    }

    public function setQuestion(String $question): self
    {
        if (!in_array($question, $this->questions)) {
            $this->questions[] = $question;
        }
        return $this;
    }

    public function isTreated(): ?bool
    {
        return $this->isTreated;
    }

    public function setIsTreated(bool $isTreated): self
    {
        $this->isTreated = $isTreated;

        return $this;
    }
}
