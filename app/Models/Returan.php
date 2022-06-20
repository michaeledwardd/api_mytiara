<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Returan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_returan';
    protected $table = 'returan';
    protected $fillable = [
        'id_barang',
        'kendala_barang',
        'status_returan',
        'tgl_diambil'
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
}
