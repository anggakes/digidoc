<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JobPosition
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $label
 * @property int $parent_id
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $department
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereDepartment($value)
 * @property-read JobPosition|null $parent
 */
class JobPosition extends Model
{
    use HasFactory;

    public function jobParent()
    {
        return $this->belongsTo(JobPosition::class, "parent_id", "id");
    }

    public function department(){
        return $this->belongsTo(Department::class, "department_id", "id");
    }

    public function user(){
        return $this->hasOne(User::class, 'job_position_id', 'id');
    }
}
