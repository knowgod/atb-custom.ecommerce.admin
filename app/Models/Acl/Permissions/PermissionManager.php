<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 25.01.16
 *
 */
namespace App\Models\Acl\Permissions;

use LaravelDoctrine\ACL\Permissions\PermissionManager as AclPermissionManager;

class PermissionManager extends AclPermissionManager
{
    public function getPermissionsWithDotNotation()
    {
        $permissions = $this->driver()->getAllPermissions();

        $list = $this->convertToDotArray(
            $permissions->toArray()
        );

        return array_flatten($list);
    }

    public function getDefaultDriver()
    {
        return $this->container->make('config')->get('acl.permissions.driver', 'config');
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return __NAMESPACE__;
    }


}