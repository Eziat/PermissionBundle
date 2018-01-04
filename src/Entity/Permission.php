<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Entity;

use Eziat\PermissionBundle\Model\PermissionInterface;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
abstract class Permission implements PermissionInterface
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * {@inheritdoc}
     */
    public function setName(string $name) : PermissionInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription(string $description) : PermissionInterface
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription() : string
    {
        return $this->description;
    }
}