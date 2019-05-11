<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompaniesRepository")
 */
class Companies
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
    private $firmName;

    /**
     * @ORM\Column(type="integer")
     */
    private $ogrn;

    /**
     * @ORM\Column(type="integer")
     */
    private $oktmo;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    private $idFirstEmployee;

    /**
     * @ORM\Column(type="string", length=255);
     */
    private $address;

    /**
     * @ORM\Column(type="integer", length=12);
     */
    private $phone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirmName(): ?string
    {
        return $this->firmName;
    }

    public function setFirmName(string $firmName): self
    {
        $this->firmName = $firmName;

        return $this;
    }

    public function getOgrn(): ?int
    {
        return $this->ogrn;
    }

    public function setOgrn(int $ogrn): self
    {
        $this->ogrn = $ogrn;

        return $this;
    }

    public function getOktmo(): ?int
    {
        return $this->oktmo;
    }

    public function setOktmo(int $oktmo): self
    {
        $this->oktmo = $oktmo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getIdFirstEmployee(): ?string
    {
        return $this->idFirstEmployee;
    }

    public function setIdFirstEmployee(string $idFirstEmployee): self
    {
        $this->idFirstEmployee = $idFirstEmployee;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}

