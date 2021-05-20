<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $table = 'letters';
    use HasFactory;

    public function docno(){
        return $this->belongsTo(Docno::class, "docno_id", "id");
    }

    public function draftTo(){
        return $this->belongsTo(User::class, "draft_to_id", "id");
    }

    public function to(){
        return $this->belongsTo(User::class, "to_id", "id");
    }

    public function from(){
        return $this->belongsTo(User::class, "from_id", "id");
    }

    public function officialMemo(){
        return $this->hasOne(OfficialMemo::class, "letter_id", "id");
    }


}
