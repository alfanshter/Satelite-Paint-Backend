<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\slider;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SliderController extends Controller
{
    public function insertslider(Request $request)
    {
        try {
                $slider = slider::create([
                            'nama' => $request->nama,
                            'foto' => $request->foto,
                            'tujuan' => $request->deskripsi,
                            'nomorpesanan' => $request->stok   
                            ]);

                $response = [
                'message' => 'Input data berhasil',
                'data' => 1 ]; 

        } catch (QueryException $th) {
                $response = [
                'message' => 'Input data gagal',
                'data' => 0 ]; 

        }

        return response()->json($response,Response::HTTP_OK);  

    }

    public function getslider()
    {
        try {
            $getdata = DB::table('sliders')->orderBy('created_at','DESC')->get();
            $response = [
                    'message' => 'getdata',
                    'data' => $getdata
            ];        
                return response()->json($response,Response::HTTP_OK);

        } catch (QueryException $th) {
            $response = [
                    'message' => 'getdata',
                    'data' => $th->errorInfo
            ];        
                return response()->json($response,Response::HTTP_OK);

        }
    }

    public function deleteslider(Request $request)
    {

        try {
            $deleteakun = DB::table('sliders')->where('id',$request->id)->delete();
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
