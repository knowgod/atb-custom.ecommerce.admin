<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */
        'roles'       => [
                'entity' => App\Models\Acl\Entities\Role::class,
        ],
    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |
    | Available drivers: config|doctrine
    | When set to config, add the permission names to list
    |
    */
        'permissions' => [
                'driver' => 'config',
                'entity' => LaravelDoctrine\ACL\Permissions\Permission::class,
                'list'   => [
                        [
                                'order'      => [
                                        '*',
                                        'create',
                                        'update',
                                        'delete',
                                        'view',
                                        'list'
                                ],
                                'invitation' => [
                                        '*',
                                        'create',
                                        'update',
                                        'delete',
                                        'view',
                                        'list'
                                ],
                                'user'       => [
                                        '*',
                                        'create',
                                        'update',
                                        'delete',
                                        'view',
                                        'list',
                                        'template' => 'user_emails'
                                ],
                        ],
                ],
        ],
];
