<?php

namespace App\Entity;

use App\Repository\ConditionComicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConditionComicRepository::class)]
class ConditionComic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $conditionName;

    #[ORM\ManyToMany(targetEntity: Comics::class, inversedBy: 'conditionComics')]
    private $comicRelation;

    public function __construct()
    {
        $this->comicRelation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConditionName(): ?string
    {
        return $this->conditionName;
    }

    public function setConditionName(string $conditionName): self
    {
        $this->conditionName = $conditionName;

        return $this;
    }

    /**
     * @return Collection<int, Comics>
     */
    public function getComicRelation(): Collection
    {
        return $this->comicRelation;
    }

    public function addComicRelation(Comics $comicRelation): self
    {
        if (!$this->comicRelation->contains($comicRelation)) {
            $this->comicRelation[] = $comicRelation;
        }

        return $this;
    }

    public function removeComicRelation(Comics $comicRelation): self
    {
        $this->comicRelation->removeElement($comicRelation);

        return $this;
    }
}
