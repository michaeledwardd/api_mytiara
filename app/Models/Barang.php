<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Barang extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'id_barang';
    protected $table = 'barang';
    protected $fillable = [
        'id_barang',
        'id_jenis',
        'nama_barang',
        'harga_pokok',
        'harga_jual',
        'status_tersedia',
        'garansi',
        'durasi_garansi',
        'foto_barang',
        'stok_barang',
        'keterangan'
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

    public function Jenis(){
        return $this->belongsTo(Jenis::class, 'id_jenis', 'id_jenis');
    }
}
