<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use App\Repositories\CustomerRepository;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRootUser();
        $this->createAdminUser();

        // Create a user only on local
        if (app()->isLocal()) {
            $this->createVisitorUser();
            $this->demoCustomer();
        }
    }

    private function createRootUser()
    {
        $rootUser = User::firstOrCreate(
            ['email' => 'root@readyecommerce.com'],
            [
                'name' => 'Super Admin',
                'phone' => '01000000001',
                'password' => \Illuminate\Support\Facades\Hash::make('secret'),
                'is_active' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]
        );

        $rootUser->assignRole(Roles::ROOT->value);
    }

    private function createAdminUser()
    {
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@readyecommerce.com'],
            [
                'name' => 'Admin',
                'phone' => '01000000002',
                'password' => \Illuminate\Support\Facades\Hash::make('secret'),
                'is_active' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]
        );

        $adminUser->assignRole(Roles::ADMIN->value);
    }

    private function createVisitorUser()
    {
        $visitorUser = User::firstOrCreate(
            ['email' => 'visitor@readyecommerce.com'],
            [
                'name' => 'Visitor',
                'phone' => '01000000003',
                'password' => \Illuminate\Support\Facades\Hash::make('secret'),
                'is_active' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]
        );

        $visitorUser->assignRole(Roles::VISITOR->value);
    }

    private function demoCustomer()
    {
        $user = User::firstOrCreate(
            ['email' => 'user@readyecommerce.com'],
            [
                'name' => 'Demo Customer',
                'phone' => '01000000405',
                'password' => \Illuminate\Support\Facades\Hash::make('secret'),
                'is_active' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]
        );

        $user->assignRole(Roles::CUSTOMER->value);

        CustomerRepository::storeByRequest($user);
    }
}
