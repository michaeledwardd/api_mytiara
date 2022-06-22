<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Pengiriman;

class PengirimanController extends Controller
{
    //Method untuk menampilkan semua data jenis (READ)
    public function index(){
        $pengiriman = Pengiriman::all(); //Mengambil semua data jenis

        if(count($jenis) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pengiriman
            ], 200);
        } //Return data semua jenis dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data jenis kosong
    }

    //Method untuk menampilkan 1 data jenis (SEARCH)
    public function show($id_pengiriman){
        $pengiriman = Pengiriman::find($id_pengiriman); //Mencari data jenis berdasarkan id

        if(!is_null($pengiriman)){
            return response([
                'message' => 'Retrieve pengiriman Success',
                'data' => $pengiriman
            ], 200);
        } //Return data semua pengiriman dalam bentuk JSON

        return response([
            'message' => 'pengiriman Not Found',
            'data' => null
        ], 400); //Return message data pengiriman kosong
    }

    //Method untuk menambah 1 data jenis baru (CREATE)
    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'id_supplier' => 'required',
            'id_barang' => 'required',
            'tanggal_datang' => 'required|date_format:Y-m-d',
            'bukti_terima' => 'required|max:1024|mimes:jpg,png,jpeg|image',
            'status_pengiriman' => 'required'
        ],
        [
        'id_barang.required' => 'Inputan tidak boleh kosong',
        'id_supplier.required' => 'Inputan tidak boleh kosong']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $buktiTerima = $request->bukti_terima->store('img_bukti_terima',['disk'=>'public']);

        $Pengiriman = Pengiriman::create([
            'id_supplier'=>$request->id_supplier,
            'id_barang'=>$request->id_barang,
            'tanggal_datang'=>$request->tanggal_datang,
            'bukti_terima'=>$buktiTerima,
            'status_pengiriman'=>$required->status_pengiriman,
        ]);

        return response([
            'message' => 'Add Pengiriman Success',
            'data' => $Pengiriman
        ], 200); //Return message data jenis baru dalam bentuk JSON
    }

    public function destroy($id_pengiriman){
        $Pengiriman = Pengiriman::find($id_pengiriman); //Mencari data jenis berdasarkan id

        if(is_null($Pengiriman)){
            return response([
                'message' => 'Pengiriman Not Found',
                'date' => null
            ], 404);
        } //Return message saat data Pengiriman tidak ditemukan

        if($Pengiriman->delete()){
            return response([
                'message' => 'Delete Pengiriman Success',
                'data' => $Pengiriman
            ], 200);
        } //Return message saat berhasil menghapus data Pengiriman

        return response([
            'message' => 'Delete Pengiriman Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data jenis (UPDATE)
    public function update(Request $request, $id_pengiriman){
        $Pengiriman = Pengiriman::find($id_pengiriman); //Mencari data jenis berdasarkan id

        if(is_null($Pengiriman)){
            return response([
                'message' => 'Pengiriman Not Found',
                'data' => null
            ], 404);
        } //Return message saat data Pengiriman tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_supplier' => 'required',
            'id_barang' => 'required',
            'tanggal_datang' => 'required|date_format:Y-m-d',
            'bukti_terima' => 'required|max:1024|mimes:jpg,png,jpeg|image',
            'status_pengiriman' => 'required'
        ],
        [
        'id_barang.required' => 'Inputan tidak boleh kosong',
        'id_supplier.required' => 'Inputan tidak boleh kosong']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Pengiriman->id_supplier = $updateData['id_supplier']; 
        $Pengiriman->id_barang = $updateData['id_barang'];
        $Pengiriman->tanggal_datang = $updateData['tanggal_datang'];
        if(isset($request->bukti_terima))
        {
            $buktiTerima = $request->bukti_terima->store('img_bukti_terima',['disk'=>'public']);
            $pengiriman->bukti_terima = $buktiTerima;
        }
        $Pengiriman->status_pengiriman = $updateData['status_pengiriman'];

        if($Pengiriman->save()){
            return response([
                'message' => 'Update Pengiriman Success',
                'data' => $Pengiriman
            ], 200);
        } //Return data Pengiriman yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Pengiriman Failed',
            'data' => null
        ], 400);
    }
}
