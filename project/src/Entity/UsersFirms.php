<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersFirmsRepository")
 */
class UsersFirms
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_firm;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFirm(): ?int
    {
        return $this->id_firm;
    }

    public function setIdFirm(int $id_firm): self
    {
        $this->id_firm = $id_firm;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
}
