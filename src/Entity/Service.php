<?php

/*
 * This file is part of the API as a Service Project.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * A service represents a table in your database and holds
 * several field definitions.
 *
 * @ApiResource()
 * @ORM\Entity()
 * @author Christian Siewert <christian@sieware.international>
 */
class Service
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
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Repository", inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $repository;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ServiceField", mappedBy="service", orphanRemoval=true)
     */
    private $serviceFields;

    public function __construct()
    {
        $this->serviceFields = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRepository(): ?Repository
    {
        return $this->repository;
    }

    public function setRepository(?Repository $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * @return Collection|ServiceField[]
     */
    public function getServiceFields(): Collection
    {
        return $this->serviceFields;
    }

    public function addServiceField(ServiceField $serviceField): self
    {
        if (!$this->serviceFields->contains($serviceField)) {
            $this->serviceFields[] = $serviceField;
            $serviceField->setService($this);
        }

        return $this;
    }

    public function removeServiceField(ServiceField $serviceField): self
    {
        if ($this->serviceFields->contains($serviceField)) {
            $this->serviceFields->removeElement($serviceField);
            // set the owning side to null (unless already changed)
            if ($serviceField->getService() === $this) {
                $serviceField->setService(null);
            }
        }

        return $this;
    }
}
