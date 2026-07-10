<?php

namespace App\States;

class Draft extends DocumentState
{
    public static $name = 'draft';
    public function color(): string {return 'text-gray-500';}

    public function label(): string
    {
        return '下書き';
    }
}