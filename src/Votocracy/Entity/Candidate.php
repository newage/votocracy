<?php
declare(strict_types=1);

namespace Votocracy\Entity;

use Common\Annotation;
use Common\Annotation\Hydrator;
use Common\Annotation\Input;
use Laminas\Hydrator\ClassMethodsHydrator;

#[Annotation\Hydrator(ClassMethodsHydrator::class)]
class Candidate
{
    #[Annotation\InputFilter(required: false)]
    #[Input\Filter\ToInt]
    #[Input\Validator\Digits]
    private ?int $id = null;

    #[Annotation\InputFilter(required: true, breakOnFailure: false)]
    #[Input\Validator\StringLength(min: 6, max: 255)]
    private ?string $description = null;

    #[Annotation\InputFilter(required: true, breakOnFailure: false)]
    #[Input\Filter\ToInt]
    #[Input\Validator\Digits]
    private ?int $electionId = null;

    #[Annotation\InputFilter(required: false, breakOnFailure: false)]
    #[Input\Filter\ToInt]
    #[Input\Validator\Digits]
    private ?int $ownerUserId = null;

    #[Hydrator\DateTimeStrategy('Y:m:d H:i:s')]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Candidate
    {
        $this->id = $id;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Candidate
    {
        $this->description = $description;
        return $this;
    }

    public function getElectionId(): ?int
    {
        return $this->electionId;
    }

    public function setElectionId(?int $electionId): Candidate
    {
        $this->electionId = $electionId;
        return $this;
    }

    public function getOwnerUserId(): ?int
    {
        return $this->ownerUserId;
    }

    public function setOwnerUserId(?int $ownerUserId): Candidate
    {
        $this->ownerUserId = $ownerUserId;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): Candidate
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
