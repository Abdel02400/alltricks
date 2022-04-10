<?php

namespace App\Entity;

use App\Repository\SourceRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sources")
 * @ORM\Entity(repositoryClass=SourceRepository::class)
 * @UniqueEntity("name")
 */
class Source
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private ?string $name = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SourceCategory", inversedBy="sources")
     * @ORM\JoinColumn(name="source_category_id", referencedColumnName="id", nullable=false)
     */
    private ?SourceCategory $sourceCategory = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="source")
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
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
     * @return Source
     */
    public function setName(?string $name): Source
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return SourceCategory|null
     */
    public function getSourceCategory(): ?SourceCategory
    {
        return $this->sourceCategory;
    }

    /**
     * @param SourceCategory|null $sourceCategory
     * @return Source
     */
    public function setSourceCategory(?SourceCategory $sourceCategory): Source
    {
        $this->sourceCategory = $sourceCategory;
        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    /**
     * @param Article $article
     * @return Source
     */
    public function addArticle(Article $article): Source
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setSource($this);
        }
        return $this;
    }

    /**
     * @param Article $article
     * @return Source
     */
    public function removeSource(Article $article): Source
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            if ($article->getSource() === $this) {
                $article->setSource(null);
            }
        }
        return $this;
    }
}