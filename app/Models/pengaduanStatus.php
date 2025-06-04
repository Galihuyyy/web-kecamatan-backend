<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengaduanStatus extends Model
{
    protected $table = "pengaduan_status";
    protected $guarded = [];
    public function pengaduan() {
        return $this->belongsTo(pengaduan::class, 'pengaduan_id', 'id');
    }

    public function approver() {
        return $this->belongsTo(User::class, 'approver_id', 'id');
    }
}
