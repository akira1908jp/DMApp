<?php

namespace App\States;

class Rejected extends DocumentState
{
    public static $name = 'rejected';
    public function color(): string  {return 'text-red-500';}

    public function label(): string
    {
        return '却下';
    }
}