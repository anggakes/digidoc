<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Letter
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string|null $file_path
 * @property string $description
 * @property string $type
 * @property string $from
 * @property string $to
 * @property int $uploaded_by
 * @property int $editable
 * @property string $number
 * @method static \Illuminate\Database\Eloquent\Builder|Letter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereUploadedBy($value)
 * @mixin \Eloquent
 * @property int $from_id
 * @property int $to_id
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereToId($value)
 */
class Letter extends Model
{
    use HasFactory;
}
