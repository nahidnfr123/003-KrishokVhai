<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    public static function defaultPermissions(): array
    {
        return [
            'access_dashboard',

            'view_settings',
            'edit_settings',

            'view_roles',
            'edit_permissions',

            'view_users',
            'create_users',
            'edit_users',
            'block_unblock_users',
            'delete_users',
            'restore_users',
            'destroy_users',

            'view_brand',
            'create_brand',
            'edit_brand',
            'destroy_brand',

            'view_category',
            'create_category',
            'edit_category',
            'destroy_category',

            'manage_product',
            'view_products',
            'create_products',
            'edit_products',
            'delete_products',
            'restore_products',
            'destroy_products',
        ];

    }
}
