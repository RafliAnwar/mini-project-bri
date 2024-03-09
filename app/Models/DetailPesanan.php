<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pesanan', 
        'id_produk', 
        'qty', 
        'harga',
    ];

    public function pesanan(){
        return $this->belongsTo(Pesanan::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
