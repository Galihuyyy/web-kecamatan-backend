<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengaduan extends Model
{
    protected $table = "pengaduan";
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
