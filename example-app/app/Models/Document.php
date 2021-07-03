<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Document
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @mixin \Eloquent
 */
class Document extends Model
{
    use HasFactory;

    function createdBy() {
        return $this->belongsTo(User::class, "created_by", "id");
    }

    function memoDepartment() {
        return $this->belongsTo(Department::class, "memo_to_department_id", "id");
    }

}
