<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    //Method untuk menampilkan semua data jenis (READ)
    public function index(){
        $transaksi = Transaksi::all(); //Mengambil semua data jenis

        if(count($transaksi) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $transaksi
            ], 200);
        } //Return data semua jenis dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data jenis kosong
    }

    //Method untuk menampilkan 1 data jenis (SEARCH)
    public function show($id_transaksi){
        $transaksi = Transaksi::find($id_transaksi); //Mencari data jenis berdasarkan id

        if(!is_null($transaksi)){
            return response([
                'message' => 'Retrieve transaksi Success',
                'data' => $transaksi
            ], 200);
        } //Return data semua transaksi dalam bentuk JSON

        return response([
            'message' => 'transaksi Not Found',
            'data' => null
        ], 400); //Return message data transaksi kosong
    }

    //Method untuk menambah 1 data jenis baru (CREATE)
    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'id_barang' => 'required',
            'id_pegawai' => 'required',
            'id_customer' => 'required',
            'quantity' => 'required|numeric',
            'total_quantity' => 'required|numeric',
            'metode_bayar' => 'required|regex:/^[\pL\s\-]+$/u',
            'status_transaksi' => 'required|regex:/^[\pL\s\-]+$/u',
            'tgl_transaksi' => 'required|date_format:Y-m-d',
        ],
        [
        'id_barang.required' => 'Inputan tidak boleh kosong',
        'id_customer.required' => 'Inputan tidak boleh kosong',
        'id_pegawai.required' => 'Inputan tidak boleh kosong']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }
        $count = DB::table('customer')->count() +1;
        $id_generate = sprintf("%03d", $count);

        $hargabarang = barang::where('id_barang', $request->id_barang)->first();
        $harga = $sewa->harga_jual;
        $totalbayar = $quantity * $harga;

        $Transaksi = Transaksi::create([
            'id_transaksi'=>'TRN'.'TIARA'.$id_generate,
            'id_barang'=>$request->id_barang,
            'id_pegawai'=>$request->id_pegawai,
            'id_customer'=>$request->id_customer,
            'quantity'=>$request->quantity,
            'total_quantity'=>$harga,
            'total_all'=>$totalbayar,
            'metode_bayar'=>$request->metode_bayar,
            'status_transaksi'=>$request->status_transaksi,
            'tgl_transaksi'=>$request->tgl_transaksi,
        ]);

        return response([
            'message' => 'Add Transaksi Success',
            'data' => $Transaksi
        ], 200); //Return message data jenis baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data jenis (DELETE)
    public function destroy($id_transaksi){
        $Transaksi = Transaksi::find($id_transaksi); //Mencari data Transaksi berdasarkan id

        if(is_null($Transaksi)){
            return response([
                'message' => 'Transaksi Not Found',
                'date' => null
            ], 404);
        } //Return message saat data Transaksi tidak ditemukan

        if($Transaksi->delete()){
            return response([
                'message' => 'Delete Transaksi Success',
                'data' => $Transaksi
            ], 200);
        } //Return message saat berhasil menghapus data Transaksi

        return response([
            'message' => 'Delete Transaksi Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data jenis (UPDATE)
    public function update(Request $request, $id_transaksi){
        $Transaksi = Transaksi::find($id_transaksi); //Mencari data Transaksi berdasarkan id

        if(is_null($Transaksi)){
            return response([
                'message' => 'Transaksi Not Found',
                'data' => null
            ], 404);
        } //Return message saat data Transaksi tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_barang' => 'required',
            'id_pegawai' => 'required',
            'id_customer' => 'required',
            'quantity' => 'required|numeric',
            'total_quantity' => 'required|numeric',
            'metode_bayar' => 'required|regex:/^[\pL\s\-]+$/u',
            'status_transaksi' => 'required|regex:/^[\pL\s\-]+$/u',
            'tgl_transaksi' => 'required|date_format:Y-m-d',
        ],
        [
        'id_barang.required' => 'Inputan tidak boleh kosong',
        'id_customer.required' => 'Inputan tidak boleh kosong',
        'id_pegawai.required' => 'Inputan tidak boleh kosong']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $hargabarang = barang::where('id_barang', $request->id_barang)->first();
        $harga = $sewa->harga_jual;

        $totalbayar = $quantity * $harga;

        $Transaksi->id_barang = $updateData['id_barang']; 
        $Transaksi->id_pegawai = $updateData['id_pegawai'];
        $Transaksi->id_customer = $updateData['id_pegawai'];
        $Transaksi->quantity = $updateData['quantity'];
        $Transaksi->total_quantity = $harga;
        $Transaksi->total_all = $totalbayar;
        $Transaksi->metode_bayar = $updateData['metode_bayar'];
        $Transaksi->status_transaksi = $updateData['status_transaksi'];
        $Transaksi->tgl_transaksi = $updateData['tgl_transaksi'];

        if($Transaksi->save()){
            return response([
                'message' => 'Update Transaksi Success',
                'data' => $Transaksi
            ], 200);
        } //Return data Transaksi yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Transaksi Failed',
            'data' => null
        ], 400);
    }
}
