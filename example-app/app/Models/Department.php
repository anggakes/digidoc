<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    function kepala() {
        $jp =  JobPosition::where("department_id", "=", $this->id)
            ->whereNull("parent_id")->first();

        return $jp;
    }
}
