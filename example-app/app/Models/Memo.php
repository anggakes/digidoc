<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Memo
 *
 * @property int $id
 * @property string $title
 * @property int $from_id
 * @property int $to_id
 * @property int $draft_to_id
 * @property string|null $file_path
 * @property string $message
 * @property string $status
 * @property int $editable
 * @property string $number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Memo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Memo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Memo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereDraftToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Memo extends Model
{
    use HasFactory;
}
