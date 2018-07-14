[![Build Status](https://travis-ci.org/Eziat/PermissionBundle.svg?branch=master)](https://travis-ci.org/Eziat/PermissionBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Eziat/PermissionBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Eziat/PermissionBundle/?branch=master)

Eziat Permission bundle
=======================
Permission bundle provides a flexible way to control access decisions. 
Basically it make sense to use it if you need to have something more
flexible than roles but less complex than acl definitions.

Installation
------------

### Step 1 Download the bundle using composer.
```bash
composer require eziat/permission-bundle
```

### Step 2 Enable the bundle
Add the bundle to the `config/bundles.php` file.
```php
<?php
// config/bundles.php

return [
    //...
    new Eziat\PermissionBundle\EziatPermissionBundle(),
    //...
];
```

This is done automatically if you use flex.

### Step 3 Create your permission class (optional)
* Required if you want to store permissions in the database as an additional table.
```php
<?php
// src/Entity/Permission.php

namespace App\Entity;

use Eziat\PermissionBundle\Entity\Permission as BasePermission;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="permission")
 */
class Permission extends BasePermission
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    public function getId()
    {
        return $this->id;
    }
    
    // Your other logic.
}
```

### Step 4 Implement UserPermissionInterface 
To use the `UserManager` your `User` class should implement `UserPermissionInterface`.
There are two methods to implement:
 * `getId()` 
 * `getPermissions()` 

```php
<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Eziat\PermissionBundle\Model\UserPermissionInterface;

/**
 * @ORM\Entity
 */
class User implements UserPermissionInterface
{
    /**
     * @ORM\ManyToMany(targetEntity="Permission")
     * @ORM\JoinTable(name="users_permissions",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="permission_id", referencedColumnName="id")}
     * )
     */
    protected $permissions;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getPermissions() : array
    {
        return $this->permissions;
    }
    
    // Your other logic.
}
```

### Step 5 Configure the bundle
```yaml
eziat_permission:
    database:
        db_driver: orm
        permission_class: App\Entity\Permission
    cache: ~
```
