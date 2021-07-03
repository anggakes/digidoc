<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentAction extends Model
{
    use HasFactory;

    function user() {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    function document() {
        return $this->belongsTo(Document::class, "document_id", "id");
    }
}
