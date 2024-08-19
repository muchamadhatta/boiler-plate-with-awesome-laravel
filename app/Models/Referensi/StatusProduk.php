<?php

namespace App\Models\Referensi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusProduk extends Model
{
    use HasFactory;
    protected $table = 'status_produk';
    public $incrementing = true;
    protected $guarded = [];
    public $timestamps = false;
}
