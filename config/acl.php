<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */
    'roles'         => [
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
    'permissions'   => [
        'driver' => 'config',
        'entity' => LaravelDoctrine\ACL\Permissions\Permission::class,
        'list'   => [
                [
                 'order'=>[
                     'fucking.create',
                     'fucking.update',
                 ],
                 'order.update.rakamakafo',
                 'fucking.piece.of.fuck'
                ]
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Organisations
    |--------------------------------------------------------------------------
    */
/*    'organisations' => [
        'entity' => App\Organisation::class,
    ],*/
];
