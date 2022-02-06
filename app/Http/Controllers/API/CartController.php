<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function addcart(Request $request)
    {

         $validator = Validator::make($request->all(),[
            'idusers' => 'required|max:255',
            'idproduk' => 'required|max:255',
            'nama' => 'required|string|max:255',
            'foto' => 'required|max:255',
            'deskripsi' => 'required|max:255',
            'harga' => 'required|max:255'
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
            $data = DB::table('carts')->where('idusers',$request->idusers)->where('idproduk',$request->idproduk)->where('status',0)->first();
            if($data!=null){
                $jumlah = $data->jumlah + 1;
                $totalharga = $jumlah * $data->harga;
                $update = DB::table('carts')->where('idproduk',$request->idproduk)->where('idusers',$request->idusers)->update(['jumlah'=>$jumlah,'totalharga'=>$totalharga]);                
                $response = [
                    'message' => 'update data berhasil',
                    'data' => 1 ];   
            }else{
                $totalharga = $request->harga * 1;
            $keranjang = Cart::create([
                'idusers' => $request->idusers,
                'idproduk' => $request->idproduk,
                'nomorpesanan' => $request->nomorpesanan,
                'nama' => $request->nama,
                'foto' => $request->foto,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'jumlah' => 1,
                'status' => false,
                'pickcart' => true,
                'totalharga' => $totalharga
            ]);
              $response = [
                'message' => 'Checkout data berhasil',
                'data' => 1 ];   

            }  
        } catch (QueryException $th) {
              $response = [
                'message' => 'Checkout data gagal',
                'data' => 0 ];   
        }

        return response()->json($response,Response::HTTP_OK);  

    }

    public function getcart(Request $request)
    {
        $getdata = DB::table('carts')->where('idusers',$request->input('idusers'))->where('status',false)->get();          
        $response = [
                'message' => 'getdata',
                'data' => $getdata
         ];        
            return response()->json($response,Response::HTTP_OK);
    }

    public function updatejumlah(Request $request)
    {
          $validator = Validator::make($request->all(),[
            'id' => 'required|max:255',
            'jumlah' => 'required|max:255',
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
                $data = DB::table('carts')->where('id',$request->id)->first();
                $totalharga = $request->jumlah * $data->harga;
                $update = DB::table('carts')->where('id',$request->id)->update(['jumlah'=>$request->jumlah,'totalharga'=>$totalharga]);                
                $response = [
                    'message' => 'update data berhasil',
                    'data' => 1 ];   
            } catch (QueryException $th) {
                $response = [
                    'message' => 'update data gagal',
                    'data' => 0 ];   
            }

        return response()->json($response,Response::HTTP_OK);  


    }

    public function deletecart(Request $request)
    {
           try {
                $hapus = DB::table('carts')->where('id',$request->id)->delete();
                $response = [
                    'message' => 'update data berhasil',
                    'data' => 1 ];   
            } catch (QueryException $th) {
                $response = [
                    'message' => 'update data gagal',
                    'data' => 0 ];   
            }
            return response()->json($response,Response::HTTP_OK);

    }

    public function pickcart(Request $request)
    {
            try {
                $update = DB::table('carts')->where('id',$request->id)->update(['pickcart'=>$request->pickcart]);                
                $response = [
                    'message' => 'update data berhasil',
                    'data' => 1 ];   
            } catch (QueryException $th) {
                $response = [
                    'message' => 'update data gagal',
                    'data' => 0 ];   
            }
            return response()->json($response,Response::HTTP_OK);

    }
    
    public function sumcart(Request $request)
    {
          try {
        $data = DB::table('carts')->where('idusers',$request->idusers)->where('pickcart',1)->where('status',0)->sum('totalharga');
                $response = [
                    'message' => 'jumlah total',
                    'data' => (int)$data ];   
            } catch (QueryException $th) {
                $response = [
                    'message' => 'jumlah data gagal',
                    'data' => 0 ];   
            }
            return response()->json($response,Response::HTTP_OK);

    }

}
