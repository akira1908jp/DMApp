<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['code' => '0', 'name' => '本部'],
            ['code' => '1', 'name' => '部門A'],
            ['code' => '2', 'name' => '部門B'],
            ['code' => '3', 'name' => '部門C']
        ];

        foreach ($departments as $department) {
            DB::table('departments')->updateOrInsert(
                ['code' => $department['code']], // 検索条件（重複登録を防ぐ）
                ['name' => $department['name'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}