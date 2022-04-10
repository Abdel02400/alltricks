<?php

namespace App\Entity;

use App\Repository\SourceCategoryRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sources_category")
 * @ORM\Entity(repositoryClass=SourceCategoryRepository::class)
 * @UniqueEntity("email")
 */
class SourceCategory 
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=30, nullable=false, unique=true)
     */
    private ?string $name = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Source", mappedBy="sourceCategory")
     */
    private $sources;

    public function __construct()
    {
        $this->sources = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return SourceCategory
     */
    public function setName(?string $name): SourceCategory
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection|Source[]
     */
    public function getSources(): Collection
    {
        return $this->sources;
    }

     /**
      * @param Source $source
      * @return SourceCategory
      */
     public function addSource(Source $source): SourceCategory
     {
         if (!$this->sources->contains($source)) {
             $this->sources[] = $source;
             $source->setSourceCategory($this);
         }
     
         return $this;
     }
 
     /**
      * @param Source $source
      * @return SourceCategory
      */
     public function removeSource(Source $source): SourceCategory
     {
         if ($this->sources->contains($source)) {
             $this->sources->removeElement($source);
             if ($source->getSourceCategory() === $this) {
                 $source->setSourceCategory(null);
             }
         }
     
         return $this;
     }
}