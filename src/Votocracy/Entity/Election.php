<?php
declare(strict_types=1);

namespace Votocracy\Entity;

use Votocracy\Entity\Enum\ElectionModel;
use Votocracy\Entity\Enum\ElectionStatus;
use Votocracy\Entity\Enum\ElectionVisible;
use Common\Annotation;
use Common\Annotation\Hydrator;
use Common\Annotation\Input;
use Laminas\Hydrator\ClassMethodsHydrator;

#[Annotation\Hydrator(name: ClassMethodsHydrator::class)]
class Election
{
    #[Annotation\InputFilter(required: false)]
    #[Input\Filter\ToInt]
    #[Input\Validator\Digits]
    private ?int $id = null;

    #[Annotation\InputFilter(required: true, breakOnFailure: false)]
    #[Input\Validator\StringLength(min: 6, max: 255)]
    private ?string $description = null;

    #[Hydrator\EnumStrategy(class: ElectionStatus::class)]
    #[Annotation\InputFilter(required: false, breakOnFailure: false)]
    #[Input\Validator\EnumStrategy(class: ElectionStatus::class)]
    private ?ElectionStatus $status = null;

    #[Hydrator\EnumStrategy(class: ElectionVisible::class)]
    #[Annotation\InputFilter(required: false, breakOnFailure: false)]
    #[Input\Validator\EnumStrategy(class: ElectionVisible::class)]
    private ?ElectionVisible $visible = null;

    #[Hydrator\EnumStrategy(class: ElectionModel::class)]
    #[Annotation\InputFilter(required: false, breakOnFailure: false)]
    #[Input\Validator\EnumStrategy(class: ElectionModel::class)]
    private ?ElectionModel $model = null;

    #[Hydrator\DateTimeStrategy(format: 'Y-m-d H:i:s')]
    private ?\DateTimeInterface $createdAt = null;

    #[Hydrator\DateTimeStrategy(format: 'Y-m-d H:i:s')]
    private ?\DateTimeInterface $updatedAt = null;

    #[Hydrator\DateTimeStrategy(format: 'Y-m-d H:i:s')]
    private ?\DateTimeInterface $dateStart = null;

    #[Hydrator\DateTimeStrategy(format: 'Y-m-d H:i:s')]
    private ?\DateTimeInterface $dateEnd = null;

    #[Input\Validator\IsInt]
    private ?int $serviceId = null;

    #[Input\Validator\IsInt]
    private ?int $ownerUserId = null;

    private ?int $voterMinRating = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStatus(): ?ElectionStatus
    {
        return $this->status;
    }

    public function setStatus(?ElectionStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getVisible(): ?ElectionVisible
    {
        return $this->visible;
    }

    public function setVisible(?ElectionVisible $visible): self
    {
        $this->visible = $visible;
        return $this;
    }

    public function getModel(): ?ElectionModel
    {
        return $this->model;
    }

    public function setModel(?ElectionModel $model): self
    {
        $this->model = $model;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt ?? $this->setUpdatedAt(new \DateTimeImmutable())->getUpdatedAt();
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(?\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    public function getServiceId(): ?int
    {
        return $this->serviceId;
    }

    public function setServiceId(?int $serviceId): self
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    public function getOwnerUserId(): ?int
    {
        return $this->ownerUserId;
    }

    public function setOwnerUserId(?int $ownerUserId): self
    {
        $this->ownerUserId = $ownerUserId;
        return $this;
    }

    public function getVoterMinRating(): ?int
    {
        return $this->voterMinRating;
    }

    public function setVoterMinRating(?int $voterMinRating): self
    {
        $this->voterMinRating = $voterMinRating;
        return $this;
    }
}
