<?php

namespace App\Entity;

use App\Repository\UploadsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: UploadsRepository::class)]
class Uploads
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $name;

    #[ORM\Column(type: 'text')]
    private $image;

    #[ORM\Column(type: 'text')]
    private $video;

    #[ORM\Column(type: 'string', length: 255)]
    private $category;

    #[ORM\Column(type: 'string', length: 255)]
    private $token ;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $episode;

    #[ORM\OneToMany(mappedBy: 'Upload', targetEntity: CategoriesOfUpload::class)]
    private $categoriesOfUploads;

    #[ORM\OneToMany(mappedBy: 'upload', targetEntity: SerieUpload::class)]
    private $serieUploads;
    public function __construct(){
        $this->token =Uuid::uuid4();
        $this->serieUploads = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

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

    public function getEpisode(): ?string
    {
        return $this->episode;
    }

    public function setEpisode(?string $episode): self
    {
        $this->episode = $episode;

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
            $serieUpload->setUpload($this);
        }

        return $this;
    }

    public function removeSerieUpload(SerieUpload $serieUpload): self
    {
        if ($this->serieUploads->removeElement($serieUpload)) {
            // set the owning side to null (unless already changed)
            if ($serieUpload->getUpload() === $this) {
                $serieUpload->setUpload(null);
            }
        }

        return $this;
    }
}
