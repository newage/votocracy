<?php
declare(strict_types=1);

namespace App\Entity;

use Common\Annotation;
use Common\Annotation\Hydrator;
use Common\Annotation\Input;
use Laminas\Hydrator\ClassMethodsHydrator;

#[Annotation\Hydrator(ClassMethodsHydrator::class)]
class Vote
{
    #[Annotation\InputFilter(required: false)]
    #[Input\Filter\ToInt]
    #[Input\Validator\Digits]
    private ?int $id = null;

    #[Annotation\InputFilter(required: true, breakOnFailure: false)]
    #[Input\Filter\ToInt]
    #[Input\Validator\Digits]
    private ?int $candidateId = null;

    #[Annotation\InputFilter(required: true, breakOnFailure: false)]
    #[Input\Filter\ToInt]
    #[Input\Validator\Digits]
    private ?int $userId = null;

    #[Hydrator\DateTimeStrategy('Y:m:d H:i:s')]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Vote
    {
        $this->id = $id;
        return $this;
    }

    public function getCandidateId(): ?int
    {
        return $this->candidateId;
    }

    public function setCandidateId(?int $candidateId): Vote
    {
        $this->candidateId = $candidateId;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): Vote
    {
        $this->userId = $userId;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): Vote
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
