<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CategoriesOfUpload::class)]
    private $categoriesOfUploads;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    public function __construct()
    {
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
            $categoriesOfUpload->setCategory($this);
        }

        return $this;
    }

    public function removeCategoriesOfUpload(CategoriesOfUpload $categoriesOfUpload): self
    {
        if ($this->categoriesOfUploads->removeElement($categoriesOfUpload)) {
            // set the owning side to null (unless already changed)
            if ($categoriesOfUpload->getCategory() === $this) {
                $categoriesOfUpload->setCategory(null);
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
}
