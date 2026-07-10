<?php

namespace App\States;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class DocumentState extends State
{
    // 必要に応じて、全状態共通のメソッド（ラベル取得など）を定義できます
    abstract public function label(): string;
    public function is(string $stateClass): bool
    {
        return $this instanceof $stateClass;
    }
}