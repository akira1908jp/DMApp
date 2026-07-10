<?php

namespace Database\Seeders;

use App\States\Draft;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DateTime;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documents = [
            ['title'=> '案件プロジェクト０１',
            'description'=> '目的概要説明',
            'budget'=> '100000000',
            'status' => 'draft',
            'user_id'=> '1', // ユーザー０１
            'department_code'=> '1', //部門A
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            ['title'=> '案件プロジェクト０２',
            'description'=> '目的概要説明',
            'budget'=> '200000000',
            'status' => 'draft',
            'user_id'=> '1', // ユーザー０１
            'department_code'=> '1', //部門A
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            ['title'=> '案件プロジェクト０３',
            'description'=> '目的概要説明',
            'budget'=> '500000000',
            'status' => 'approved',
            'user_id'=> '1', // ユーザー０１
            'department_code'=> '1', //部門A
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            ['title'=> '案件プロジェクト０８',
            'description'=> '目的概要説明',
            'budget'=> '80000000',
            'status' => 'approved',
            'user_id'=> '1', // ユーザー０１
            'department_code'=> '1', //部門A
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
            ],
            ['title'=> '案件プロジェクト０１',
            'description'=> '目的概要説明',
            'budget'=> '100000000',
            'status' => 'draft',
            'user_id'=> '2', // ユーザー０２
            'department_code'=> '1', //部門A
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()

            ],
            ['title'=> '案件プロジェクト０２',
            'description'=> '目的概要説明',
            'budget'=> '100000000',
            'status' => 'approved',
            'user_id'=> '2', // ユーザー０２
            'department_code'=> '1', //部門A
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()

            ],
            ['title'=> '案件プロジェクト０１',
            'description'=> '目的概要説明',
            'budget'=> '100000000',
            'status' => 'draft',
            'user_id'=> '3', // ユーザー０３
            'department_code'=> '2', //部門B
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()

            ],
            ['title'=> '案件プロジェクト０２',
            'description'=> '目的概要説明',
            'budget'=> '100000000',
            'status' => 'draft',
            'user_id'=> '3', // ユーザー０３
            'department_code'=> '2', //部門B
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()

            ],
            ['title'=> '案件プロジェクト０１',
            'description'=> '目的概要説明',
            'budget'=> '100000000',
            'status' => 'approved',
            'user_id'=> '4', // ユーザー０４
            'department_code'=> '2', //部門C
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()

            ],
            ['title'=> '案件プロジェクト０１',
            'description'=> '目的概要説明',
            'budget'=> '100000000',
            'status' => 'draft',
            'user_id'=> '4', // ユーザー０４
            'department_code'=> '2', //部門C
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()

            ],
            ['title'=> '案件プロジェクト０１',
            'description'=> '目的概要説明',
            'budget'=> '100000000',
            'status' => 'draft',
            'user_id'=> '5', // ユーザー０５
            'department_code'=> '3', //部門C
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()

            ],
            ['title'=> '案件プロジェクト０１',
            'description'=> '目的概要説明',
            'budget'=> '100000000',
            'status' => 'approved',
            'user_id'=> '5', // ユーザー０１
            'department_code'=> '3', //部門C
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()

            ],
        ];
        foreach ($documents as $document) {
            DB::table('documents')->insert($document);
        }
    }
}
