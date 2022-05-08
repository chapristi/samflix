<?php

namespace App\Entity;

use App\Repository\CategoriesOfUploadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesOfUploadRepository::class)]
class CategoriesOfUpload
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'categoriesOfUploads')]
    #[ORM\JoinColumn(nullable: false)]

    private $category;

    #[ORM\ManyToOne(targetEntity: Serie::class, inversedBy: 'categoriesOfUploads')]
    #[ORM\JoinColumn(nullable: false)]
    private $serie;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): self
    {
        $this->serie = $serie;

        return $this;
    }


}
