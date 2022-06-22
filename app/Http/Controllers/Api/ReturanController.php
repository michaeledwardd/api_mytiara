<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Returan;

class ReturanController extends Controller
{
    //Method untuk menampilkan semua data returan (READ)
    public function index(){
        $returan = Returan::all(); //Mengambil semua data returan

        if(count($returan) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $returan
            ], 200);
        } //Return data semua returan dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data returan kosong
    }

    //Method untuk menampilkan 1 data returan (SEARCH)
    public function show($id_returan){
        $returan = Returan::find($id_returan); //Mencari data returan berdasarkan id

        if(!is_null($returan)){
            return response([
                'message' => 'Retrieve Returan Success',
                'data' => $returan
            ], 200);
        } //Return data semua returan dalam bentuk JSON

        return response([
            'message' => 'Returan Not Found',
            'data' => null
        ], 400); //Return message data returan kosong
    }

    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'id_barang' => 'required',
            'kendala_barang' => 'required|regex:/^[\pL\s\-]+$/u',
            'status_returan' => 'required|regex:/^[\pL\s\-]+$/u',
            'tgl_diambil' => 'required|date_format:Y-m-d'
        ],
        [
        'id_barang.required' => 'Inputan tidak boleh kosoong',
        'kendala_barang.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'status_returan.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'tgl_diambil.required' => 'Inputan tidak boleh kosong']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Returan = Returan::create($storeData);

        return response([
            'message' => 'Add Returan Success',
            'data' => $Returan
        ], 200); //Return message data returan baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data returan (DELETE)
    public function destroy($id_returan){
        $Returan = Returan::find($id_returan); //Mencari data returan berdasarkan id

        if(is_null($Returan)){
            return response([
                'message' => 'Returan Not Found',
                'date' => null
            ], 404);
        } //Return message saat data returan tidak ditemukan

        if($Returan->delete()){
            return response([
                'message' => 'Delete Returan Success',
                'data' => $Returan
            ], 200);
        } //Return message saat berhasil menghapus data returan

        return response([
            'message' => 'Delete Returan Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data returan (UPDATE)
    public function update(Request $request, $id_returan){
        $Returan = Returan::find($id_returan); //Mencari data returan berdasarkan id

        if(is_null($Returan)){
            return response([
                'message' => 'Returan Not Found',
                'data' => null
            ], 404);
        } //Return message saat data returan tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_barang' => 'required',
            'kendala_barang' => 'required|regex:/^[\pL\s\-]+$/u',
            'status_returan' => 'required|regex:/^[\pL\s\-]+$/u',
            'tgl_diambil' => 'required|date_format:Y-m-d'
        ],
        [
        'id_barang.required' => 'Inputan tidak boleh kosoong',
        'kendala_barang.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'status_returan.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'tgl_diambil.required' => 'Inputan tidak boleh kosong']); //Membuat rule validasi input


        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Returan->id_barang = $updateData['id_barang']; 
        $Returan->kendala_barang = $updateData['kendala_barang'];
        $Returan->status_returan = $updateData['status_returan'];
        $Returan->tgl_diambil = $updateData['tgl_diambil'];
        

        if($Returan->save()){
            return response([
                'message' => 'Update Returan Success',
                'data' => $Returan
            ], 200);
        } //Return data Returan yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Returan Failed',
            'data' => null
        ], 400);
    }
}
