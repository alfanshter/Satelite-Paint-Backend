<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Gambar;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class GambarController extends Controller
{
  public function insertgambar(Request $request)
    {
        try {
            $getgambar = DB::table('gambars')->first();
            if ($getgambar!=null) {
                $updategambar = DB::table('gambars')->where('kode','foto')->update([
                    'foto' => $request->foto
                ]);

                $response = [
                'message' => 'update foto',
                'data' => 1 ]; 
            }else{
                $slider = Gambar::create([
                            'foto' => $request->foto,
                            'kode' => 'foto'
                            ]);

                $response = [
                'message' => 'Input data berhasil',
                'data' => 1 ]; 

            }

        } catch (QueryException $th) {
                $response = [
                'message' => 'Input data gagal',
                'data' => 0 ]; 

        }

        return response()->json($response,Response::HTTP_OK);  

    }

    public function getgambar()
    {
        try {
            $getdata = DB::table('gambars')->first();
            if ($getdata!=null) {
                $response = [
                        'message' => 'getdata',
                        'foto' => $getdata->foto
                ];        
            }else{
                    $response = [
                    'message' => 'foto kosong',
                    'foto' => ''
            ];        

            }
                return response()->json($response,Response::HTTP_OK);

        } catch (QueryException $th) {
            $response = [
                    'message' => 'getdata',
                    'data' => $th->errorInfo
            ];        
                return response()->json($response,Response::HTTP_OK);

        }
    }

      public function getgambarcustomer()
    {
        try {
            $getdata = DB::table('gambars')->first();
            if ($getdata!=null) {
                $response = [
                        'message' => 'getdata',
                        'foto' => $getdata->foto
                ];        
            }else{
                    $response = [
                    'message' => 'foto kosong',
                    'foto' => ''
            ];        

            }
                return response()->json($response,Response::HTTP_OK);

        } catch (QueryException $th) {
            $response = [
                    'message' => 'getdata',
                    'data' => $th->errorInfo
            ];        
                return response()->json($response,Response::HTTP_OK);

        }
    }

    public function deletegambar(Request $request)
    {

        try {
            $deleteakun = DB::table('gambars')->where('kode','foto')->delete();
            $response = [
                'message' => 'berhasil dihapus',
                'data' => 1
            ];
            return response()->json($response,Response::HTTP_CREATED);

        } catch (QueryException $th) {
            $response = [
                'message' => 'gagal hapus',
                'data' => $th->errorInfo
            ];
            return response()->json($response,Response::HTTP_OK);
        }

    }
}
