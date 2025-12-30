<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string", length=180, unique=true) */
    private $email;

    /** @ORM\Column(type="json") */
    private $roles = [];

    /** @ORM\Column(type="string") */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="Note", mappedBy="user", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $notes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
        $this->email = '';
        $this->password = '';
        $this->roles = [];
    }

    public function getId(): ?int { return $this->id; }

    public function getEmail(): string { return $this->email ?? ''; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getUsername(): string { return $this->email ?? ''; }

    public function getRoles(): array
    {
        return array_unique(array_merge($this->roles, ['ROLE_USER']));
    }

    public function setRoles(array $roles): self { $this->roles = $roles; return $this; }

    public function getPassword(): string { return $this->password ?? ''; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }

    public function getSalt() {}
    public function eraseCredentials() {}

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setUser($this);
        }
        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->removeElement($note)) {
            if ($note->getUser() === $this) {
                $note->setUser(null);
            }
        }
        return $this;
    }
}
