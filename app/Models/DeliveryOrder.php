<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $table = 'delivery_orders'; // Nama tabel dalam basis data

    protected $primaryKey = 'id_delivery'; // Kolom primary key

    protected $fillable = [
        'kode_delivery_orders',
        'nama_sopir',
        'plat_no',
        'tanggal_kirim',
    ];

    public function detailDelivery()
    {
        return $this->hasMany(DetailDelivery::class, 'id_detail_delivery');
    }
}
