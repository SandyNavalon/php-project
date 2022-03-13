<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $name;

    #[ORM\OneToOne(targetEntity: Comics::class, inversedBy:'status')]
    private $comic;

    public function __construct()
    {
        $this->comic = new ArrayCollection();
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

    /**
     * @return Collection<int, Comics>
     */

    public function getComic(): Collection
    {
        return $this->comic;
    }

    public function addComic(Comics $comic): self
    {
        if (!$this->comic->contains($comic)) {
            $this->comic[] = $comic;
        }

        return $this;
    }

    public function removeComic(Comics $comic): self
    {
        $this->comic->removeElement($comic);

        return $this;
    }
}
