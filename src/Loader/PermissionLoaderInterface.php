<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Loader;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
interface PermissionLoaderInterface
{
    /**
     * Loads a permissions from the configuration file.
     */
    public function loadPermissions() : void;
}