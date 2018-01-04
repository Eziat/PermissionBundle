<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Model;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
interface PermissionInterface
{
    public function getId();

    public function setName(string $name) : self;

    public function getName() : string;

    public function setDescription(string $description) : self;

    public function getDescription() : string;
}