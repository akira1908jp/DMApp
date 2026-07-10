<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates; // トレイトをインポート
use App\States\DocumentState; // 作成したベースのStateクラス
use App\States\Draft;
use App\States\PendingAdmin;
use App\States\PendingHeadquarters;
use App\States\Approved;
use App\States\Rejected;
use Spatie\ModelStates\StateConfig;
use APP\Models\Approvals;


class Document extends Model
{
    use HasStates;

    protected function casts() {
        return [
            'status' => DocumentState::class,
        ];
    }

    // 3. ここに遷移ルール（ワークフローの設計）を書く
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Draft::class) // 初期状態
            
            // 申請フローの定義
            ->allowTransition(Draft::class, PendingAdmin::class)               // 申請：下書き -> 管理部門
            ->allowTransition(PendingAdmin::class, PendingHeadquarters::class) // 承認：管理部門 -> 本部
            ->allowTransition(PendingHeadquarters::class, Approved::class)     // 承認：本部 -> 完了
            
            // 却下・差し戻しの定義
            ->allowTransition([PendingAdmin::class, PendingHeadquarters::class], Rejected::class) // 却下
            ->allowTransition(PendingAdmin::class, Draft::class); // 差し戻し（例：管理部門から申請者へ）
    }

    // 操作したユーザーへのリレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function department() {
        return $this->belongsTo(Department::class, 'department_code', 'code') ;
    }
    public function tasks()
{
    // Document は複数の Task を持つ
    return $this->hasMany(Task::class);
}
}
