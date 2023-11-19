<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDelivery extends Model
{
    use HasFactory;
    protected $table = 'detail_deliveries'; // Nama tabel dalam basis data
    protected $primaryKey = 'id_detail_delivery'; // Kolom primary key
    protected $fillable = [
        'id_delivery',
        'id_distribusi',
    ];

    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class, 'id_delivery');
    }
}
