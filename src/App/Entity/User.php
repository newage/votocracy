<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Enum\UserRole;
use App\Entity\Enum\UserStatus;
use Common\Annotation;
use Common\Annotation\Hydrator;
use Common\Annotation\Input;
use Laminas\Hydrator\ClassMethodsHydrator;

#[Annotation\Hydrator(name: ClassMethodsHydrator::class)]
class User
{
    #[Annotation\InputFilter(required: false)]
    #[Input\Filter\ToInt]
    #[Input\Validator\Digits]
    private ?int $id = null;

    #[Annotation\InputFilter(required: true, breakOnFailure: false)]
    #[Input\Validator\StringLength(min: 6, max: 255)]
    private ?string $email = null;

    #[Hydrator\EnumStrategy(class: UserStatus::class)]
    #[Annotation\InputFilter(required: true, breakOnFailure: false)]
    #[Input\Validator\EnumStrategy(class: UserStatus::class)]
    private ?UserStatus $status = null;

    #[Annotation\InputFilter(required: false)]
    #[Input\Filter\ToInt]
    #[Input\Validator\Digits]
    private ?int $points = null;

    #[Hydrator\EnumStrategy(class: UserRole::class)]
    #[Annotation\InputFilter(required: false, breakOnFailure: false)]
    #[Input\Validator\EnumStrategy(class: UserRole::class)]
    private ?UserRole $role = null;

    #[Hydrator\DateTimeStrategy(format: 'Y-m-d H:i:s')]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int|string $id): self
    {
        $this->id = (int)$id;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getStatus(): ?UserStatus
    {
        return $this->status;
    }

    public function setStatus(?UserStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;
        return $this;
    }

    public function getRole(): ?UserRole
    {
        return $this->role;
    }

    public function setRole(?UserRole $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
