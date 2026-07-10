<?php

namespace App\States;

class Approved extends DocumentState
{
    public static $name = 'approved';
    public function color(): string 
    {
         return 'text-green-500';
    }

    public function label(): string
    {
        return '承認済み';
    }
}