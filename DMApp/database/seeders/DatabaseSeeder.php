<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            DepartmentSeeder::class]);
        $user01 =  User::updateOrCreate(
            ['email' => 'sample01@sample.com'],
            ['name' => 'ユーザー０１',
            'email' => 'sample01@sample.com',
            'password' => bcrypt('test1234'),
            'department_code' => '1'
            ]);

        $user02 = User::updateOrCreate(
            ['email' => 'sample02@sample.com'],            
            ['name' => 'ユーザー０２',
            'email' => 'sample02@sample.com',
            'password' => bcrypt('test1234'),
            'department_code' => '1'
            ]);
        $user03 = User::updateOrCreate(
            ['email' => 'sample03@sample.com'],            
            ['name' => 'ユーザー０３',
            'email' => 'sample03@sample.com',
            'password' => bcrypt('test1234'),
            'department_code' => '2'
            ]);
        $user04 = User::updateOrCreate(
            ['email' => 'sample04@sample.com'],            
            ['name' => 'ユーザー０４',
            'email' => 'sample04@sample.com',
            'password' => bcrypt('test1234'),
            'department_code' => '2'
            ]);
        $user05 = User::updateOrCreate(
            ['email' => 'sample05@sample.com'],            
            ['name' => 'ユーザー０５',
            'email' => 'sample05@sample.com',
            'password' => bcrypt('test1234'),
            'department_code' => '3'
            ]);

        $userDpA = User::updateOrCreate(
            ['email' => 'sampleA@sample.com'],            
            ['name' => '管理ユーザーA',
            'email' => 'sampleA@sample.com',
            'password' => bcrypt('test1234'),
            'department_code' => '1'
            ]); 
        $userDpB = User::updateOrCreate(
            ['email' => 'sampleB@sample.com'],            
            ['name' => '管理ユーザーB',
            'email' => 'sampleB@sample.com',
            'password' => bcrypt('test1234'),
            'department_code' => '2'
            ]); 
        $userDpC = User::updateOrCreate(
            ['email' => 'sampleC@sample.com'],            
            ['name' => '管理ユーザーC',
            'email' => 'sampleC@sample.com',
            'password' => bcrypt('test1234'),
            'department_code' => '3'
            ]); 

            $userhq = User::updateOrCreate(
            ['email' => 'samplehq@sample.com'],            
            ['name' => '本部ユーザー',
            'email' => 'samplehq@sample.com',
            'password' => bcrypt('test1234'),
            'department_code' => '0'
            ]);

        $roleUser = Role::updateOrCreate(['name' => 'user']);
        $roleAdmin = Role::updateOrCreate(['name' => 'approveAsAdmin']);
        $roleHq = Role::updateOrCreate(['name' => 'approveAsHq']);

        // $permissionA = Permission::updateOrCreate(['name' => '管理部門A']); 

        $user01->assignRole($roleUser);
        $user02->assignRole($roleUser);
        $user03->assignRole($roleUser);
        $user04->assignRole($roleUser);
        $user05->assignRole($roleUser);
        $userDpA->assignRole($roleAdmin);
        $userDpB->assignRole($roleAdmin);
        $userDpC->assignRole($roleAdmin);
        $userhq->assignRole($roleHq);
        // $user02->givePermissionTo($permissionA);

        $this->call([
            DocumentSeeder::class]);
    }
}
