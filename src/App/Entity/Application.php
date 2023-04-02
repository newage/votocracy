<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\Status;

class Application
{
    protected ?int $id = null;
    protected ?string $message = null;
    protected ?Status $status = null;
    protected ?User $users = null;
    protected ?ApplicationCollection $collection = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCollection(): ?ApplicationCollection
    {
        return $this->collection;
    }

    public function setCollection(?ApplicationCollection $collection): self
    {
        $this->collection = $collection;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->users;
    }

    public function setUser(?User $users): self
    {
        $this->users = $users;
        return $this;
    }
}
