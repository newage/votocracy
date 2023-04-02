<?php

namespace Common\Data;

interface UserInterface
{
    public function getId(): int;

    public function getEmail(): string;

    public function getRoles(): array;
}
