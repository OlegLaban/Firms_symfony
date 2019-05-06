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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirmName(): ?string
    {
        return $this->firmName;
    }

    public function setFirmName(string $firm_name): self
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
}
