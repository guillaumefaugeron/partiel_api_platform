<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;


/**
 * @ApiResource(
 *     normalizationContext={"groups"={"album_read"}}
 *
 * )
 *@ApiFilter(SearchFilter::class, properties={"name": "ipartial"})
 * @ApiFilter(RangeFilter::class, properties={"releaseYear"})
 * @ApiFilter(NumericFilter::class, properties={"releaseYear"})
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("album_read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("album_read")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups("album_read")
     */
    private $releaseYear;

    /**
     * @Groups("album_read")
     * @ORM\OneToMany(targetEntity="App\Entity\Artist", mappedBy="album")
     */
    private $artist;

    public function __construct()
    {
        $this->artist = new ArrayCollection();
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

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): self
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    /**
     * @return Collection|Artist[]
     */
    public function getArtist(): Collection
    {
        return $this->artist;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->artist->contains($artist)) {
            $this->artist[] = $artist;
            $artist->setAlbum($this);
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        if ($this->artist->contains($artist)) {
            $this->artist->removeElement($artist);
            // set the owning side to null (unless already changed)
            if ($artist->getAlbum() === $this) {
                $artist->setAlbum(null);
            }
        }

        return $this;
    }
}
