<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. まずカラムを作成（すでに存在する場合はスキップ）
            if (!Schema::hasColumn('users', 'department_code')) {
                $table->string('department_code')->nullable()->after('email');
            }
        });

        // 2. 外部キー制約を付ける前に、 departments テーブルに存在しない値を NULL にする（不整合対策）
        DB::table('users')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('departments')
                    ->whereRaw('users.department_code = departments.code');
            })
            ->update(['department_code' => null]);

        // 3. 満を持して制約を付与
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('department_code')
                ->references('code')
                ->on('departments')
                ->onUpdate('cascade')
                ->onDelete('set null'); // 部門が消えたらユーザーの部門コードをnullにする
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('department_code');
        });
    }
};
