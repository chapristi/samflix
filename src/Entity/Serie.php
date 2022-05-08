<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $name;

    #[ORM\OneToMany(mappedBy: 'serie', targetEntity: SerieUpload::class)]
    private $serieUploads;

    #[ORM\Column(type: 'text')]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $token;

    #[ORM\OneToMany(mappedBy: 'serie', targetEntity: CategoriesOfUpload::class)]
    private $categoriesOfUploads;

    #[ORM\Column(type: 'text')]
    private $description;

    public function __construct()
    {
        $this->serieUploads = new ArrayCollection();
        $this->token = Uuid::uuid4();
        $this->categoriesOfUploads = new ArrayCollection();
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
     * @return Collection<int, SerieUpload>
     */
    public function getSerieUploads(): Collection
    {
        return $this->serieUploads;
    }

    public function addSerieUpload(SerieUpload $serieUpload): self
    {
        if (!$this->serieUploads->contains($serieUpload)) {
            $this->serieUploads[] = $serieUpload;
            $serieUpload->setSerie($this);
        }

        return $this;
    }

    public function removeSerieUpload(SerieUpload $serieUpload): self
    {
        if ($this->serieUploads->removeElement($serieUpload)) {
            // set the owning side to null (unless already changed)
            if ($serieUpload->getSerie() === $this) {
                $serieUpload->setSerie(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, CategoriesOfUpload>
     */
    public function getCategoriesOfUploads(): Collection
    {
        return $this->categoriesOfUploads;
    }

    public function addCategoriesOfUpload(CategoriesOfUpload $categoriesOfUpload): self
    {
        if (!$this->categoriesOfUploads->contains($categoriesOfUpload)) {
            $this->categoriesOfUploads[] = $categoriesOfUpload;
            $categoriesOfUpload->setSerie($this);
        }

        return $this;
    }

    public function removeCategoriesOfUpload(CategoriesOfUpload $categoriesOfUpload): self
    {
        if ($this->categoriesOfUploads->removeElement($categoriesOfUpload)) {
            // set the owning side to null (unless already changed)
            if ($categoriesOfUpload->getSerie() === $this) {
                $categoriesOfUpload->setSerie(null);
            }
        }

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
}
