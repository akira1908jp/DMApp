<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(["report","actual","progress_date","progeres_status"])]
class Task extends Model
{
public function document()
    {
        // Task は一つの Document に属する
        return $this->belongsTo(Document::class);
    }
}
