<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\produk;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProdukController extends Controller
{

    public function insertproduct(Request $request)
    {

     $validator = Validator::make($request->all(),[
            'nama' => 'required|string|max:255',
            'foto' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'stok' => 'required|max:255',
            'mingrosir' => 'required|max:255',
            'maxgrosir' => 'required|max:255',
            'harga' => 'required|max:255',
            'hargagrosir' => 'required|max:255'
            ]);

        if($validator->fails()){
             $response = [
                'message' => 'pastikan data sudah benar',
                'error'=>$validator->errors(),
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);
        }
        try {
            $produk = produk::create([
                'nama' => $request->nama,
                'foto' => $request->foto,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'mingrosir' => $request->mingrosir,
                'maxgrosir' => $request->maxgrosir,
                'harga' => $request->harga,
                'hargagrosir' => $request->hargagrosir,
                'rating' => 0,
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

    public function getproduct(Request $request)
    {
        $getdata = DB::table('produks')->orderBy('created_at','DESC')->get();
         $response = [
                'message' => 'getdata',
                'data' => $getdata
         ];        
            return response()->json($response,Response::HTTP_OK);
    }

    public function updateproduct(Request $request)
    {
    
        try {
                $updatedata = DB::table('produks')->where('id',$request->id)->update([
                 'nama' => $request->nama,
                'foto' => $request->foto,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'mingrosir' => $request->mingrosir,
                'maxgrosir' => $request->maxgrosir,
                'harga' => $request->harga,
                'hargagrosir' => $request->hargagrosir,
                'rating' => 0,
            ]);

            $response = [
                'message' => 'berhasil update',
                'data' => 1
            ];
        } catch (QueryException $th) {
             $response = [
                'message' => $th->errorInfo,
                'data' => 0
            ];     
        }
                return response()->json($response,Response::HTTP_OK);

    }

    public function deleteproduct(Request $request)
    {
        $deleteakun = DB::table('produks')->where('id',$request->id)->delete();
        if ($deleteakun > 0) {
            $response = [
                'message' => 'berhasil dihapus',
                'data' => 1
            ];
            return response()->json($response,Response::HTTP_CREATED);
        }else{
            $response = [
                'message' => 'gagal hapus',
                'data' => 0
            ];
            return response()->json($response,Response::HTTP_OK);

        }

    }
}
