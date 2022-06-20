<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'id_transaksi';
    protected $table = 'transaksi';
    protected $fillable = [
        'id_barang',
        'id_pegawai',
        'id_customer',
        'quantity',
        'total_quantity',
        'total_all',
        'metode_bayar',
        'status_transaksi',
        'tgl_transaksi'
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

    public function Barang(){
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    public function Pegawai(){
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function Customer(){
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}
