<?php

declare(strict_types=1);

namespace App\Entity;

class User
{
    protected $id;
    protected $name;
    protected ?ApplicationCollection $applications = null;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ?ApplicationCollection
     */
    public function getApplications(): ?ApplicationCollection
    {
        return $this->applications;
    }

    /**
     * @param ApplicationCollection $applications
     */
    public function setApplications(ApplicationCollection $applications): self
    {
        $this->applications = $applications;
        return $this;
    }
}
