<?php

namespace App\States;

class PendingHeadquarters extends DocumentState
{
    public static $name = 'pending_hq';
    public function color(): string {return 'text-orange-500';}

    public function label(): string
    {
        return '本部承認待ち';
    }
}
