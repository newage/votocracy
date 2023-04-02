<?php

declare(strict_types=1);

namespace Common\Data\Value;

use Common\Data\UserInterface;

class TokenBasedUser implements UserInterface
{
    public function __construct(private readonly int $id, private readonly string $email, private readonly array $roles)
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
