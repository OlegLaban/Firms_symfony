<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users
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
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $father_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $birth_day;

    /**
     * @ORM\Column(type="integer")
     */
    private $inn;

    /**
     * @ORM\Column(type="integer")
     */
    private $cnils;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer")
     */
    private $data_start_job;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getFatherName(): ?string
    {
        return $this->father_name;
    }

    public function setFatherName(string $father_name): self
    {
        $this->father_name = $father_name;

        return $this;
    }

    public function getBirthDay(): ?int
    {
        return $this->birth_day;
    }

    public function setBirthDay(int $birth_day): self
    {
        $this->birth_day = $birth_day;

        return $this;
    }

    public function getInn(): ?int
    {
        return $this->inn;
    }

    public function setInn(int $inn): self
    {
        $this->inn = $inn;

        return $this;
    }

    public function getCnils(): ?int
    {
        return $this->cnils;
    }

    public function setCnils(int $cnils): self
    {
        $this->cnils = $cnils;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDataStartJob(): ?int
    {
        return $this->data_start_job;
    }

    public function setDataStartJob(int $data_start_job): self
    {
        $this->data_start_job = $data_start_job;

        return $this;
    }
}
