<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Barang;

class BarangController extends Controller
{
    //Method untuk menampilkan semua data barang (READ)
    public function index(){
        $barang = Barang::all(); //Mengambil semua data barang

        if(count($barang) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $barang
            ], 200);
        } //Return data semua barang dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data barang kosong
    }

    //Method untuk menampilkan 1 data barang (SEARCH)
    public function show($id_barang){
        $barang = Barang::find($id_barang); //Mencari data barang berdasarkan id

        if(!is_null($barang)){
            return response([
                'message' => 'Retrieve Barang Success',
                'data' => $barang
            ], 200);
        } //Return data semua barang dalam bentuk JSON

        return response([
            'message' => 'Barang Not Found',
            'data' => null
        ], 400); //Return message data barang kosong
    }

    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'id_jenis' => 'required',
            'nama_barang' => 'required|regex:/^[\pL\s\-]+$/u',
            'harga_pokok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'status_tersedia' => 'required|regex:/^[\pL\s\-]+$/u',
            'garansi' => 'required',
            'durasi_garansi' => 'required|numeric',
            'foto_barang' => 'required|max:1024|mimes:jpg,png,jpeg|image',
            'stok_barang' => 'required|numeric',
            'keterangan' => 'required'
        ],
        [
        'id_jenis.required' => 'Inputan tidak boleh kosoong',
        'harga_pokok.numeric' => 'Inputan harus dalam bentuk numeric',
        'harga_jual.numeric' => 'Inputan harus dalam bentuk numeric',
        'nama_barang.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'status_tersedia.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'keterangan.required' => 'Inputan tidak boleh kosong',
        'stok_barang.numeric' => 'Inputan harus dalam bentuk angka']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $count = DB::table('barang')->count() +1;
        $id_generate = sprintf("%03d", $count);

        $uploadBerkas = $request->upload_berkas->store('img_foto_barang',['disk'=>'public']);

        $Barang = Barang::create([
            'id_barang'=>'TIARA'.'-'.$id_generate,
            'nama_barang'=>$request->nama_barang,
            'harga_pokok'=>$request->harga_pokok,
            'harga_jual'=>$request->harga_jual,
            'status_tersedia'=>$request->status_tersedia,
            'garansi'=>$request->garansi,
            'durasi_garansi'=>$request->durasi_garansi,
            'foto_barang'=>$uploadBerkas,
            'stok_barang'=>$request->stok_barang,
            'keterangan'=>$request->keterangan,
        ]);

        return response([
            'message' => 'Add Barang Success',
            'data' => $Barang
        ], 200); //Return message data barang baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data barang (DELETE)
    public function destroy($id_barang){
        $Barang = Barang::find($id_barang); //Mencari data barang berdasarkan id

        if(is_null($Barang)){
            return response([
                'message' => 'Barang Not Found',
                'date' => null
            ], 404);
        } //Return message saat data Barang tidak ditemukan

        if($Barang->delete()){
            return response([
                'message' => 'Delete Barang Success',
                'data' => $Barang
            ], 200);
        } //Return message saat berhasil menghapus data Barang

        return response([
            'message' => 'Delete Barang Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data barang (UPDATE)
    public function update(Request $request, $id_barang){
        $Barang = Barang::find($id_barang); //Mencari data Barang berdasarkan id

        if(is_null($Barang)){
            return response([
                'message' => 'Barang Not Found',
                'data' => null
            ], 404);
        } //Return message saat data Barang tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_jenis' => 'required',
            'nama_barang' => 'required|regex:/^[\pL\s\-]+$/u',
            'harga_pokok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'status_tersedia' => 'required|regex:/^[\pL\s\-]+$/u',
            'garansi' => 'required',
            'durasi_garansi' => 'required|numeric',
            'foto_barang' => 'required|max:1024|mimes:jpg,png,jpeg|image',
            'stok_barang' => 'required|numeric',
            'keterangan' => 'required'
        ],
        [
        'id_jenis.required' => 'Inputan tidak boleh kosoong',
        'harga_pokok.numeric' => 'Inputan harus dalam bentuk numeric',
        'harga_jual.numeric' => 'Inputan harus dalam bentuk numeric',
        'nama_barang.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'status_tersedia.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'keterangan.required' => 'Inputan tidak boleh kosong',
        'stok_barang.numeric' => 'Inputan harus dalam bentuk angka']); //Membuat rule validasi input


        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Barang->id_jenis = $updateData['id_jenis']; 
        $Barang->nama_barang = $updateData['nama_barang'];
        $Barang->harga_pokok = $updateData['harga_pokok'];
        $Barang->harga_jual = $updateData['harga_jual'];
        $Barang->status_tersedia = $updateData['status_tersedia'];
        $Barang->garansi = $updateData['garansi'];
        $Barang->durasi_garansi = $updateData['durasi_garansi'];
        if(isset($request->upload_berkas))
        {
            $uploadBerkas = $request->upload_berkas->store('img_foto_barang',['disk'=>'public']);
            $Barang->upload_berkas = $uploadBerkas;
        }
        $Barang->keterangan = $updateData['keterangan'];

        if($Barang->save()){
            return response([
                'message' => 'Update Barang Success',
                'data' => $Barang
            ], 200);
        } //Return data Barang yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Barang Failed',
            'data' => null
        ], 400);
    }
}
