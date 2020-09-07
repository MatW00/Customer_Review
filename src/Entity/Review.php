<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\Email(
     *     message = "Le mail '{{ value }}' n'est pas valide.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\Length(
     *      min=5,
     *      minMessage = "Votre pseudo doit faire {{ limit }} caractères minimun.",
     *      )
     */
    private $pseudo;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $dateCreate;

    /**
     * @var ?Image
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade="all", orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $image = null;

    /**
     * @var int
    */
    private $limit;

    /**
     * @var bool
     */
    private $deleteImage;

    public function __construct()
    {
        $this->dateCreate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get the value of comment
     */ 
    public function getComment()
    {
        return $this->comment;
    }

    
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get the value of dateCreate.
     *
     * @return \DateTime
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set the value of dateCreate.
     *
     * @param \DateTime $dateCreate
     *
     * @return self
     */
    public function setDateCreate(\DateTime $dateCreate)
    {
        $this->dateCreate = $dateCreate;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function getDeleteImage()
    {
        return $this->deleteImage;
    }
    
    public function setDeleteImage(bool $deleteImage)
    {
        $this->deleteImage = $deleteImage;
        if ($deleteImage) {
            $this->image = null;
        }

        return $this;
    }

    /**
     * Get the value of image.
     *
     * @return ?Image
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Set the value of image.
     *
     * @param ?Image $image
     *
     * @return self
     */
    public function setImage(?Image $image)
    {
        if (empty($image->getFile())) {
            $image = null;
        }
        $this->image = $image;

        return $this;
    }

    public static function excerpt(string $comment, int $limit = 60)
    {
        if (strlen($comment) <= $limit ) { // strlen Retourne la taille d'une chaîne avec smiley etc...
            return $comment;
        }
        $lastSpace = strpos($comment, " ", $limit);
        return substr($comment, 0, $lastSpace). "...";
    }

    public function getExcerptComment(): ?string
    {
        if ($this->comment === null) {
            return null;
        }
    
        return nl2br(($this->excerpt($this->comment, 60)));
    }
    
}
