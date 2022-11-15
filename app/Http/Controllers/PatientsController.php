<?php

namespace App\Http\Controllers;
use App\Models\Patients;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientsController extends Controller
{
    //fungsi index method GET
    public function index()
    {
        //model eloquent fungsi all() mendapatkan semua data
        $patients = Patients::all();

        //logic response menggunakan fungsi response() di file controller.php
        if($patients){
            
            return $this->response(200, 'Get All Resource', $patients);
            
        }else {
            
            return $this->response(200, 'Data is Empty');
            
        }
    }
    
    //fungsi show menerima param $id method GET
    public function show($id)
    {
        //model eloquent fungsi find() mencari data per baris berdasarkan param $id
        $patients = Patients::find($id);
        
        
        //logic response menggunakan fungsi response() di file controller.php
        if($patients){
            
            return $this->response(200, 'Get Detail Resource', $patients);
            
        }else {
            
            return $this->response(404, 'Resource Not Found');
            
        }
    }
    
    //fungsi store menerima param $request method POST
    public function store(Request $request)
    {
        //menggunakan eloquent validator untuk memvalidasi data yang masuk
        $validated = Validator::make($request->all(),
        
        // tersedia validator required menunjukkan data harus diisi
        // tersedia validator string sebagai penanda hanya menerima string dan date hanya untuk tanggal
        // tersedia validator max dan min sebagai batas karakter input
        // tersedia validator before_or_equal dan after_or_equal berfungsi menentukan bahwa tanggal keluar tidak kurang tanggal masuk
        [
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:50|min:11',
            'address' => 'required|string',
            'status' => 'required',
            'in_date_at' => 'required|date|before_or_equal:out_date_at',
            'out_date_at' => 'required|date|after_or_equal:in_date_at'
        ]);
        
        //logic menentukan bahwa data yang sudah divalidasi itu tersedia
        if($validated->fails())
        {
            return $this->response(400, $validated->getMessageBag()->first());
        }
        
        //model eloquent fungsi create() berfungsi membuat data baru berdasarkan input param $request yang telah divalidasi
        $create = Patients::create($request->all());
        
        
        //logic response menggunakan fungsi response() di file controller.php
        if($create){
            return $this->response(201, 'Resource is added successfully', $create);
        }
    }
    
    //fungsi update menerima param $request dan $id method PUT
    public function update(Request $request, $id)
    {
        //model eloquent fungsi find() mencari data per baris berdasarkan param $id
        $patients = Patients::find($id);
        
        //logic menentukan bahwa data yang dicari tidak kosong dan mengembalikan fungsi response di file controller.php 
        if(!$patients){
            return $this->response(400, 'Resource not found');
        }
        
        // tersedia validator nullable menunjukkan data tidak harus diisi
        // tersedia validator string sebagai penanda hanya menerima string dan date hanya untuk tanggal
        // tersedia validator max dan min sebagai batas karakter input
        // tersedia validator before_or_equal dan after_or_equal berfungsi menentukan bahwa tanggal keluar tidak kurang tanggal masuk
        $validated = Validator::make($request->all(),[
            'name' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50|min:11',
            'address' => 'nullable|string',
            'status' => 'nullable',
            'in_date_at' => 'nullable|date|before_or_equal:out_date_at',
            'out_date_at' => 'nullable|date|after_or_equal:in_date_at',
        ]);
        
        //logic menentukan bahwa data yang sudah divalidasi itu tersedia
        if($validated->fails()){
            return $this->response(400, $validated->getMessageBag()->first());
        }
        
        //mengupdate data yang sudah diterima berdasarkan input param $request yang telah divalidasi dan kembali menemukan data row berdasarkan param $id
        $update = Patients::where('id', $id)->update($request->all());
        $patients = Patients::find($id);
        
        //logic response menggunakan fungsi response() di file controller.php
        if($update){
            return $this->response(200, 'Resource is Updated Successfully', $patients);
        }
        
        //logic response menggunakan fungsi response() di file controller.php apabila tidak ditemukan
        return $this->response(404, 'Resource Not Found');
        
    }
    
    //fungsi destroy menerima param $id method DELETE
    public function destroy($id)
    {
        
    //model eloquent fungsi find() mencari data per baris berdasarkan param $id
    $patients = Patients::find($id);

        //menghapus data berdasarkan param $id 
        $delete = Patients::where('id', $id)->delete();
        
        //logic response menggunakan fungsi response() di file controller.php apabila data tersedia dan data tidak tersedia
        if($delete) {
            return $this->response(200, 'Resource is Deleted Successfully', $patients);
        }
            
            return $this->response(404, 'Resource Not Found');
    }

    //fungsi search menerima param $name method GET
    public function search($name)
    {
        //model where dan get untuk mencari berdasarkan nama dari param $nama lalu mendapatkannya
        $patients = Patients::where('name', $name)->get();
        
        //logic response menggunakan fungsi response() di file controller.php apbila nama tersedia atau tidak
        if($patients){
            
            return $this->response(200, 'Get Searched Resource', $patients);
            
        }else {
            
            return $this->response(404, 'Resource Not Found');
            
        }
    }
    
    //fungsi positive method GET
    public function positive()
    {
        
        //model where dan get untuk mencari berdasarkan status positive lalu mendapatkannya
        $patients = Patients::where('status', 'positive')->get();
        
        //logic response menggunakan fungsi responseStatus() di file controller.php apabila data tersedia atau tidak
        if($patients){
            
            return $this->responseStatus(200, 'Get Positive Resource', $patients);
            
        }else {
            
            return $this->response(404, 'Resource Not Found');
            
        }
    }
    
    //fungsi recovered method GET
    public function recovered()
    {
        //model where dan get untuk mencari berdasarkan status recovered lalu mendapatkannya
        $patients = Patients::where('status', 'recovered')->get();
        
        
        //logic response menggunakan fungsi responseStatus() di file controller.php apabila data tersedia atau tidak
        if($patients){
            
            return $this->responseStatus(200, 'Get Recovery Resource', $patients);
            
        }else {
            
            return $this->response(404, 'Resource Not Found');
            
        }
    }
    
    //fungsi dead method GET
    public function dead()
    {
        //model where dan get untuk mencari berdasarkan status dead lalu mendapatkannya
        $patients = Patients::where('status', 'dead')->get();
        
        
        //logic response menggunakan fungsi responseStatus() di file controller.php apabila data tersedia atau tidak
        if($patients){

            return $this->responseStatus(200, 'Get Dead Resource', $patients);

        }else {
            
            return $this->response(404, 'Resource Not Found');

        }
    }

}