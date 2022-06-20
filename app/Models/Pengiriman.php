<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pengiriman';
    protected $table = 'pengiriman';
    protected $fillable = [
        'id_supplier',
        'id_barang',
        'tanggal_datang',
        'bukti_terima',
        'status_pengiriman'
    ];

    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute(){
        if(!is_null($this->attributes['updated_at'])){
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }

    public function Supplier(){
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function Barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
