<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Docno
 *
 * @property int $id
 * @property string $doc_date
 * @property string $doc_type
 * @property string $classification
 * @property string $subject
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Docno newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Docno newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Docno query()
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereDocDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereDocType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $docno
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereDocno($value)
 */
class Docno extends Model
{
    protected $table = 'docnos';

    use HasFactory;


}
