<?php

declare(strict_types = 1);

namespace Eziat\PermissionBundle\Command;

use Eziat\PermissionBundle\Loader\PermissionLoaderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Tomas Jakl <tomasjakll@gmail.com>
 */
class LoadPermissionDataCommand extends Command
{
    /**
     * @var PermissionLoaderInterface
     */
    private $permissionLoader;

    public function __construct(PermissionLoaderInterface $permissionLoader)
    {
        $this->permissionLoader = $permissionLoader;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('eziat:permission:load')
            ->setDescription('Loads a permission data from config files to the db.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->permissionLoader->loadPermissions();

        $output->writeln('<info>Permissions were succesfully loaded.</info>');
    }
}