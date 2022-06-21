<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Customer;

class CustomerController extends Controller
{
    //Method untuk menampilkan semua data customer (READ)
    public function index(){
        $customer = Customer::all(); //Mengambil semua data customer

        if(count($customer) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $customer
            ], 200);
        } //Return data semua customer dalam bentuk JSON

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //Return message data customer kosong
    }

    //Method untuk menampilkan 1 data customer (SEARCH)
    public function show($id_customer){
        $customer = Customer::find($id_customer); //Mencari data customer berdasarkan id

        if(!is_null($customer)){
            return response([
                'message' => 'Retrieve Customer Success',
                'data' => $customer
            ], 200);
        } //Return data semua customer dalam bentuk JSON

        return response([
            'message' => 'Customer Not Found',
            'data' => null
        ], 400); //Return message data customer kosong
    }

    //Method untuk menambah 1 data customer baru (CREATE)
    public function store(Request $request){
        $storeData = $request->all(); //Mengambil semua input dari API Client
        $validate = Validator::make($storeData, [
            'nama_customer' => 'required|regex:/^[\pL\s\-]+$/u',
            'alamat_customer' => 'required'
        ],
        [
        'nama_customer.required' => 'Inputan tidak boleh kosoong',
        'nama_customer.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'alamat_customer.required' => 'Inputan tidak boleh kosong']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Customer = Customer::create($storeData);

        return response([
            'message' => 'Add Customer Success',
            'data' => $Customer
        ], 200); //Return message data customer baru dalam bentuk JSON
    }

    //Method untuk menghapus 1 data customer (DELETE)
    public function destroy($id_customer){
        $Customer = Customer::find($id_customer); //Mencari data customer berdasarkan id

        if(is_null($Customer)){
            return response([
                'message' => 'Customer Not Found',
                'date' => null
            ], 404);
        } //Return message saat data customer tidak ditemukan

        if($Customer->delete()){
            return response([
                'message' => 'Delete Customer Success',
                'data' => $Customer
            ], 200);
        } //Return message saat berhasil menghapus data customer

        return response([
            'message' => 'Delete Customer Failed',
            'data' => null,
        ], 400);
    }

    //Method untuk mengubah 1 data customer (UPDATE)
    public function update(Request $request, $id_customer){
        $Customer = Customer::find($id_customer); //Mencari data customer berdasarkan id

        if(is_null($Customer)){
            return response([
                'message' => 'Customer Not Found',
                'data' => null
            ], 404);
        } //Return message saat data customer tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_customer' => 'required|regex:/^[\pL\s\-]+$/u',
            'alamat_customer' => 'required'
        ],
        [
        'nama_customer.required' => 'Inputan tidak boleh kosoong',
        'nama_customer.regex' => 'Inputan tidak boleh mengandung angka atau simbol lain',
        'alamat_customer.required' => 'Inputan tidak boleh kosong']); //Membuat rule validasi input

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400); //Return error invalid input
        }

        $Customer->nama_customer = $updateData['nama_customer']; 
        $Customer->alamat_customer = $updateData['alamat_customer'];

        if($Customer->save()){
            return response([
                'message' => 'Update Customer Success',
                'data' => $Customer
            ], 200);
        } //Return data customer yang telah di EDIT dalam bentuk JSON

        return response([
            'message' => 'Update Customer Failed',
            'data' => null
        ], 400);
    }
}
