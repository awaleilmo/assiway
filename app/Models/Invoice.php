<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];
//    status 0 = belum bayar, 1 = sudah bayar, 2 = selesai, 3 = dibatalkan
}
