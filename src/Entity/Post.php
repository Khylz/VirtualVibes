<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $abstract = null;

    #[ORM\Column(length: 100)]
    private ?string $image = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Rubrik $rubrik = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'post')]
    private Collection $comments;

    #[ORM\Column(name:'is_published', type: 'boolean')]
    private ?bool $isPublished = null;

    #[Gedmo\Slug(fields:['title'])]
    #[ORM\Column(length: 255, unique:true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content3 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $undertitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $undertitle2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $undertitle3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $undertitle4 = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(string $abstract): static
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getRubrik(): ?Rubrik
    {
        return $this->rubrik;
    }

    public function setRubrik(?Rubrik $rubrik): static
    {
        $this->rubrik = $rubrik;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }
    

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent2(): ?string
    {
        return $this->content2;
    }

    public function setContent2(?string $content2): static
    {
        $this->content2 = $content2;

        return $this;
    }

    public function getContent3(): ?string
    {
        return $this->content3;
    }

    public function setContent3(?string $content3): static
    {
        $this->content3 = $content3;

        return $this;
    }

    public function getContent4(): ?string
    {
        return $this->content4;
    }

    public function setContent4(?string $content4): static
    {
        $this->content4 = $content4;

        return $this;
    }

    public function getUndertitle(): ?string
    {
        return $this->undertitle;
    }

    public function setUndertitle(?string $undertitle): static
    {
        $this->undertitle = $undertitle;

        return $this;
    }

    public function getUndertitle2(): ?string
    {
        return $this->undertitle2;
    }

    public function setUndertitle2(?string $undertitle2): static
    {
        $this->undertitle2 = $undertitle2;

        return $this;
    }

    public function getUndertitle3(): ?string
    {
        return $this->undertitle3;
    }

    public function setUndertitle3(?string $undertitle3): static
    {
        $this->undertitle3 = $undertitle3;

        return $this;
    }

    public function getUndertitle4(): ?string
    {
        return $this->undertitle4;
    }

    public function setUndertitle4(?string $undertitle4): static
    {
        $this->undertitle4 = $undertitle4;

        return $this;
    }
}
