<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    //Method untuk menampilkan semua data pegawai (READ)
    public function index(){
        $pegawai = Pegawai::all(); //Mengambil semua data pegawai

        if(count($pegawai) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pegawai
            ], 200);
        } //Return data semua pegawai dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data pegawai kosong
    }

    //Method untuk menampilkan 1 data pegawai (SEARCH)
    public function show($id_pegawai){
        $pegawai = Pegawai::find($id_pegawai); //Mencari data pegawai berdasarkan id

        if(!is_null($pegawai)){
            return response([
                'message' => 'Retrieve Pegawai Success',
                'data' => $pegawai
            ], 200);
        } //Return data semua pegawai dalam bentuk JSON

        return response([
            'message' => 'Pegawai Not Found',
            'data' => null
        ], 400); //Return message data pegawai kosong
    }

    //Method untuk menambah 1 data pegawai baru (CREATE)
    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'nama_pegawai' => 'required|regex:/^[\pL\s\-]+$/u',
            'jenis_kelamin' => 'required|regex:/^[\pL\s\-]+$/u',
            'role' => 'required||regex:/^[\pL\s\-]+$/u',
            'kontak_pegawai' => 'required|digits_between:10,13|starts_with:08|numeric'
        ],
        [
        'nama_pegawai.required' => 'Inputan tidak boleh kosoong',
        'nama_pegawai.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'jenis_kelamin.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'role.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'kontak_pegawai.numeric' => 'Hanya bisa diinputkan angka']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Pegawai = Pegawai::create($storeData);

        return response([
            'message' => 'Add Pegawai Success',
            'data' => $Pegawai
        ], 200); //Return message data pegawai baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data pegawai (DELETE)
    public function destroy($id_pegawai){
        $Pegawai = Pegawai::find($id_pegawai); //Mencari data pegawai berdasarkan id

        if(is_null($Pegawai)){
            return response([
                'message' => 'Pegawai Not Found',
                'date' => null
            ], 404);
        } //Return message saat data pegawai tidak ditemukan

        if($Pegawai->delete()){
            return response([
                'message' => 'Delete Pegawai Success',
                'data' => $Pegawai
            ], 200);
        } //Return message saat berhasil menghapus data pegawai

        return response([
            'message' => 'Delete Pegawai Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data pegawai (UPDATE)
    public function update(Request $request, $id_pegawai){
        $Pegawai = Pegawai::find($id_pegawai); //Mencari data pegawai berdasarkan id

        if(is_null($Pegawai)){
            return response([
                'message' => 'Pegawai Not Found',
                'data' => null
            ], 404);
        } //Return message saat data pegawai tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_pegawai' => 'required|regex:/^[\pL\s\-]+$/u',
            'jenis_kelamin' => 'required|regex:/^[\pL\s\-]+$/u',
            'role' => 'required||regex:/^[\pL\s\-]+$/u',
            'kontak_pegawai' => 'required|digits_between:10,13|starts_with:08|numeric'
        ],
        [
        'nama_pegawai.required' => 'Inputan tidak boleh kosoong',
        'nama_pegawai.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'jenis_kelamin.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'role.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'kontak_pegawai.numeric' => 'Hanya bisa diinputkan angka']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Pegawai->nama_pegawai = $updateData['nama_pegawai']; 
        $Pegawai->jenis_kelamin = $updateData['jenis_kelamin'];
        $Pegawai->role = $updateData['role'];
        $Pegawai->kontak_pegawai = $updateData['kontak_pegawai'];

        if($Pegawai->save()){
            return response([
                'message' => 'Update Pegawai Success',
                'data' => $Pegawai
            ], 200);
        } //Return data pegawai yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Pegawai Failed',
            'data' => null
        ], 400);
    }
}
