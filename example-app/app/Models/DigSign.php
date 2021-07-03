<?php

namespace App\Models;

use Crypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DigSign
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign query()
 * @mixin \Eloquent
 */
class DigSign extends Model
{
    use HasFactory;

    public $table = 'digsigns';
    function encrypt(){
        $this->data = Crypt::encryptString($this->sign_by_id.$this->document_id.$this->sign_uniqueness);
        return $this;
    }
}


