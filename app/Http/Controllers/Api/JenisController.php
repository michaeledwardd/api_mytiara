<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Jenis;

class JenisController extends Controller
{
    //Method untuk menampilkan semua data product (READ)
    public function index(){
        $jenis = Jenis::all(); //Mengambil semua data jenis

        if(count($jenis) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $jenis
            ], 200);
        } //Return data semua jenis dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data jenis kosong
    }

    //Method untuk menampilkan 1 data jenis (SEARCH)
    public function show($id_jenis){
        $jenis = Jenis::find($id_jenis); //Mencari data jenis berdasarkan id

        if(!is_null($jenis)){
            return response([
                'message' => 'Retrieve Jenis Success',
                'data' => $jenis
            ], 200);
        } //Return data semua jenis dalam bentuk JSON

        return response([
            'message' => 'Jenis Not Found',
            'data' => null
        ], 400); //Return message data jenis kosong
    }

    //Method untuk menambah 1 data jenis baru (CREATE)
    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'nama_jenis' => 'required|regex:/^[\pL\s\-]+$/u',
            'keterangan' => 'required|regex:/^[\pL\s\-]+$/u'
        ],
        [
        'nama_jenis.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'keterangan.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Jenis= Jenis::create($storeData);

        return response([
            'message' => 'Add Jenis Success',
            'data' => $Jenis
        ], 200); //Return message data jenis baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data product (DELETE)
    public function destroy($id_jenis){
        $Jenis = Jenis::find($id_jenis); //Mencari data product berdasarkan id

        if(is_null($Jenis)){
            return response([
                'message' => 'Jenis Not Found',
                'date' => null
            ], 404);
        } //Return message saat data jenis tidak ditemukan

        if($Jenis->delete()){
            return response([
                'message' => 'Delete Jenis Success',
                'data' => $Jenis
            ], 200);
        } //Return message saat berhasil menghapus data jenis

        return response([
            'message' => 'Delete Jenis Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data jenis (UPDATE)
    public function update(Request $request, $id_jenis){
        $Jenis = Jenis::find($id_jenis); //Mencari data jenis berdasarkan id

        if(is_null($Jenis)){
            return response([
                'message' => 'Jenis Not Found',
                'data' => null
            ], 404);
        } //Return message saat data jenis tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_jenis' => 'required|regex:/^[\pL\s\-]+$/u',
            'keterangan' => 'required|regex:/^[\pL\s\-]+$/u'
        ],
        [
            'nama_jenis.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
            'keterangan.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain'
        ]); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Jenis->nama_jenis = $updateData['nama_jenis']; 
        $Jenis->keterangan = $updateData['keterangan'];

        if($Jenis->save()){
            return response([
                'message' => 'Update Jenis Success',
                'data' => $Jenis
            ], 200);
        } //Return data jenis yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Jenis Failed',
            'data' => null
        ], 400);
    }
}
