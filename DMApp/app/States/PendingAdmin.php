<?php

namespace App\States;

class PendingAdmin extends DocumentState
{
    public static $name = 'pending_admin';
    public function color(): string {return 'text-orange-500';} 

    public function label(): string
    {
        return '管理部門承認待ち';
    }
}
