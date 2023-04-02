<?php
declare(strict_types=1);

namespace App\Entity;

use Common\Annotation;
use Common\Annotation\Hydrator;
use Common\Annotation\Input;
use Laminas\Hydrator\ClassMethodsHydrator;

#[Annotation\Hydrator(name: ClassMethodsHydrator::class)]
class Service
{
    #[Annotation\InputFilter(required: false)]
    #[Input\Filter\ToInt]
    #[Input\Validator\Digits]
    private ?int $id = null;

    #[Annotation\InputFilter(required: true, breakOnFailure: false)]
    #[Input\Validator\StringLength(min: 4, max: 55)]
    private ?string $title = null;

    #[Annotation\InputFilter(required: true, breakOnFailure: false)]
    #[Input\Validator\StringLength(min: 2, max: 10)]
    private ?string $alias = null;

    #[Hydrator\DateTimeStrategy(format: 'Y-m-d H:i:s')]
    private ?\DateTimeInterface $createdAt = null;

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle():?string
    {
        return $this->title;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;
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
