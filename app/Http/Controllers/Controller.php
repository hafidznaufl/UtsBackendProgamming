<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //fungsi response untuk menampilkan response yang dibutuhkan menerima param $status, $message, $data
    public function response($status, $message, $data = null)
    {
        //array berisi status dan message
        $array = [
            'status' => $status,
            'message' => $message,
        ];
        
        //logic apabila data tidak terisi/ null maka data tidak ditampilkan
        if ($data != null) {
            
            $array['data'] = $data;
            
        } 
        
        //mengembalikan nilai response yang telah ditangkap lalu mengubahnya ke dalam format JSON
        return response()->json($array, $status);
    }
    
    //fungsi response untuk menampilkan response yang dibutuhkan menerima param $status, $message, $data
    public function responseStatus($status, $message, $data = null)
    {
        //array berisi status dan message
        $array = [
            'status' => $status,
            'message' => $message,
        ];
        
        //logic apabila data tidak terisi/null maka data tidak ditampilkan
        //menampilkan juga total dari data yang didapat apabila $data tersedia dan tidak bernilai null
        if ($data != null) {
            
            $array['total'] = $data->count();
            $array['data'] = $data;
            
        }    
        
        //mengembalikan nilai response yang telah ditangkap lalu mengubahnya ke dalam format JSON
        return response()->json($array, $status);
    }
}
