<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'task-list',
            'task-create',
            'task-edit',
            'task-delete',
            'note-list',
            'note-create',
            'note-edit',
            'note-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'event-replicate',
            'lead-list',
            'lead-create',
            'lead-edit',
            'lead-delete',
            'share-client',
            'calender-show',
            'comment-list',
            'comment-create',
            'comment-edit',
            'comment-delete',
            'invoice-list',
            'invoice-create',
            'invoice-edit',
            'invoice-delete',
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
            'client-import',
            'client-appointment',
            'source-list',
            'source-create',
            'source-edit',
            'source-delete',
            'stats-list',
            'team-list',
            'team-create',
            'team-edit',
            'team-delete',
            'agency-list',
            'agency-create',
            'agency-edit',
            'agency-delete',
            'cant-update-field',
            'can-generate-report',
            'share-lead',
            'transfer-lead-to-deal',
            'change-task',
            'transfer-deal-to-invoice',
            'settings',
            'write-feedback',
            'chose-negativity',
            'chose-results',
            'share-deal',
            'share-appointment',
            'payment-list',
            'payment-create',
            'payment-edit',
            'payment-delete',
            'simple-user',
            'team-manager',
            'deal-stage',
            'department-list',
            'department-create',
            'department-edit',
            'department-delete',
            'department-task',
            'department-agencies-sell'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
