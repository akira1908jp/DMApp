<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function users()
    {
        return $this->hasMany(User::class, 'department_code', 'code');
    }
    public function tasks() {
        return $this->hasMany(Task::class, 'department_code', 'code');
    }
    public function documents() {
        return $this->hasMany(Task::class, 'department_code', 'code');
    }
}
