<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Supplier;

class SupplierController extends Controller
{
    //Method untuk menampilkan semua data supplier (READ)
    public function index(){
        $supplier = Supplier::all(); //Mengambil semua data supplier

        if(count($supplier) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $supplier
            ], 200);
        } //Return data semua supplier dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data supplier kosong
    }

    //Method untuk menampilkan 1 data supplier (SEARCH)
    public function show($id_supplier){
        $supplier = Supplier::find($id_supplier); //Mencari data supplier berdasarkan id

        if(!is_null($supplier)){
            return response([
                'message' => 'Retrieve Supplier Success',
                'data' => $supplier
            ], 200);
        } //Return data semua supplier dalam bentuk JSON

        return response([
            'message' => 'Supplier Not Found',
            'data' => null
        ], 400); //Return message data supplier kosong
    }

    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'nama_supplier' => 'required|regex:/^[\pL\s\-]+$/u',
            'nama_pengirim' => 'required|regex:/^[\pL\s\-]+$/u',
            'alamat_supplier' => 'required||regex:/^[\pL\s\-]+$/u',
            'kontak_supplier' => 'required|digits_between:10,13|starts_with:08|numeric'
        ],
        [
        'nama_supplier.required' => 'Inputan tidak boleh kosoong',
        'nama_supplier.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'nama_pengirim.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'alamat_supplier.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'kontak_supplier.numeric' => 'Hanya bisa diinputkan angka']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Supplier = Supplier::create($storeData);

        return response([
            'message' => 'Add Supplier Success',
            'data' => $Supplier
        ], 200); //Return message data supplier baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data supplier (DELETE)
    public function destroy($id_supplier){
        $Supplier = Supplier::find($id_supplier); //Mencari data supplier berdasarkan id

        if(is_null($Supplier)){
            return response([
                'message' => 'Supplier Not Found',
                'date' => null
            ], 404);
        } //Return message saat data supplier tidak ditemukan

        if($Supplier->delete()){
            return response([
                'message' => 'Delete Supplier Success',
                'data' => $Supplier
            ], 200);
        } //Return message saat berhasil menghapus data supplier

        return response([
            'message' => 'Delete Supplier Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data supplier (UPDATE)
    public function update(Request $request, $id_supplier){
        $Supplier = Supplier::find($id_supplier); //Mencari data supplier berdasarkan id

        if(is_null($Supplier)){
            return response([
                'message' => 'Supplier Not Found',
                'data' => null
            ], 404);
        } //Return message saat data supplier tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_supplier' => 'required|regex:/^[\pL\s\-]+$/u',
            'nama_pengirim' => 'required|regex:/^[\pL\s\-]+$/u',
            'alamat_supplier' => 'required||regex:/^[\pL\s\-]+$/u',
            'kontak_supplier' => 'required|digits_between:10,13|starts_with:08|numeric'
        ],
        [
        'nama_supplier.required' => 'Inputan tidak boleh kosoong',
        'nama_supplier.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'nama_pengirim.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'alamat_supplier.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'kontak_supplier.numeric' => 'Hanya bisa diinputkan angka']); //Membuat rule validasi input


        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Supplier->nama_supplier = $updateData['nama_supplier']; 
        $Supplier->nama_pengirim = $updateData['nama_pengirim'];
        $Supplier->alamat_supplier = $updateData['alamat_supplier'];
        $Supplier->kontak_supplier = $updateData['kontak_supplier'];
        

        if($Supplier->save()){
            return response([
                'message' => 'Update Supplier Success',
                'data' => $Supplier
            ], 200);
        } //Return data supplier yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Supplier Failed',
            'data' => null
        ], 400);
    }
}
