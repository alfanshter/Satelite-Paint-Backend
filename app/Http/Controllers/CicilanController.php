<?php

namespace App\Http\Controllers;

use App\Models\Cicilan;
use App\Models\transaksi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CicilanController extends Controller
{

    //0 = dalam proses
    //1 = cicilan diterima
    //2 = selesai
    //3 = ditolak
    public function cicilan(Request $request)
    {
            $validator = Validator::make($request->all(),[
            'idusers' => 'required|max:255',
            'nama' => 'required|string|max:255',
            'telepon' => 'required|max:255',
            'alamat' => 'required|max:255',
            'metodepembayaran' => 'required|max:255',
            'totalharga' => 'required|max:255',
            'diskon' => 'required|max:255',
            'nomorpesanan' => 'required|max:255',
            'hargacicilan' => 'required|max:255',
            'jumlahcicilan' => 'required|max:255',
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
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d', time());
            $jam = date('h:i:s', time());
            $cartcheckout = DB::table('carts')->where('idusers',$request->idusers)->where('pickcart',1)->where('status',0)->update(
                ['status'=>1,'nomorpesanan'=>$request->nomorpesanan]
            );
            $tempo1 = date('Y-m-d', time());
            $jatuhtempo1 = date('Y-m-d', strtotime($tempo1. ' + 7 days'));
            $jatuhtempo2 = date('Y-m-d', strtotime($jatuhtempo1. ' + 7 days'));
            $jatuhtempo3 = date('Y-m-d', strtotime($jatuhtempo2. ' + 7 days'));
            $jatuhtempo4 = date('Y-m-d', strtotime($jatuhtempo3. ' + 7 days'));

        
            $user = Cicilan::create([
                        'nama' => $request->nama,
                        'idusers' => $request->idusers,
                        'telepon' => $request->telepon,
                        'alamat' => $request->alamat,
                        'nomorpesanan' => $request->nomorpesanan,
                        'metodepembayaran' => $request->metodepembayaran,
                        'totalharga' => $request->totalharga,
                        'diskon' => $request->diskon,
                        'tanggal' => $tanggal,
                        'jam' => $jam,
                        'status'=> 0,
                        'jatuhtempo1'=> $jatuhtempo1,
                        'jatuhtempo2'=> $jatuhtempo2,
                        'jatuhtempo3'=> $jatuhtempo3,
                        'jatuhtempo4'=> $jatuhtempo4,
                        'foto'=> $request->foto,
                        'statuscicilan'=> 1,
                        'hargacicilan'=> $request->hargacicilan,
                        'jumlahcicilan'=> $request->jumlahcicilan,
                    ]);
            $response = [
                'message' => 'Checkout data berhasil',
                'data' => 1             ];   
                return response()->json($response,Response::HTTP_OK);  

        } catch (QueryException $th) {
            $response = [
                'message' => 'Checkout data gagal',
                'data' => $th->errorInfo ];  
            return response()->json($response,Response::HTTP_OK);  
 
        }
        

    }

    public function getcicilan(Request $request)
    {
        try {
            $getdata = DB::table('cicilans')->orderBy('status','ASC')->orderBy('created_at','ASC') ->get(); 
            $response = [
                    'message' => 'get data berhasil',
                    'data' => $getdata];  
        } catch (QueryException $th) {
            $response = [
                    'message' => 'get data gagal',
                    'data' => $th->errorInfo];  
        }
          return response()->json($response,Response::HTTP_OK);
    }

    public function getcicilanakun(Request $request)
    {
        try {
            $getdata = DB::table('cicilans')->where('idusers',$request->input('idusers'))->orderBy('status','ASC')->orderBy('created_at','ASC') ->get(); 
            $response = [
                    'message' => 'get data berhasil',
                    'data' => $getdata];  
        } catch (QueryException $th) {
            $response = [
                    'message' => 'get data gagal',
                    'data' => $th->errorInfo];  
        }
          return response()->json($response,Response::HTTP_OK);
    }

    
    public function updatestatuscicilan(Request $request)
    {   
           try {
                
                $getcicilan = DB::table('cicilans')->where('id',$request->id)->first();
                $pilihan = $request->status;
                
                if($pilihan == 1){
                    if ($getcicilan->jumlahcicilan == 1) {
                            $insertbayarcicilan = DB::table('bayar_cicilans')->insert([
                                'nomorpesanan' => $getcicilan->nomorpesanan,
                                'jumlahbayar' => $getcicilan->hargacicilan,
                                'jatuhtempo' => $getcicilan->jatuhtempo1,
                                'status' => 0
                            ]);
                    }
                    else if ($getcicilan->jumlahcicilan ==2){
                        $insertbayarcicilan = DB::table('bayar_cicilans')->insert([
                            'nomorpesanan' => $getcicilan->nomorpesanan,
                            'jumlahbayar' => $getcicilan->hargacicilan,
                            'jatuhtempo' => $getcicilan->jatuhtempo1,
                            'status' => 0
                        ]);

                        $insertbayarcicilan2 = DB::table('bayar_cicilans')->insert([
                            'nomorpesanan' => $getcicilan->nomorpesanan,
                            'jumlahbayar' => $getcicilan->hargacicilan,
                            'jatuhtempo' => $getcicilan->jatuhtempo2,
                            'status' => 0
                        ]);
                    }
                    else if ($getcicilan->jumlahcicilan ==3) {
                        $insertbayarcicilan = DB::table('bayar_cicilans')->insert([
                            'nomorpesanan' => $getcicilan->nomorpesanan,
                            'jumlahbayar' => $getcicilan->hargacicilan,
                            'jatuhtempo' => $getcicilan->jatuhtempo1,
                            'status' => 0
                        ]);

                        $insertbayarcicilan2 = DB::table('bayar_cicilans')->insert([
                            'nomorpesanan' => $getcicilan->nomorpesanan,
                            'jumlahbayar' => $getcicilan->hargacicilan,
                            'jatuhtempo' => $getcicilan->jatuhtempo2,
                            'status' => 0
                        ]);

                        $insertbayarcicilan3 = DB::table('bayar_cicilans')->insert([
                            'nomorpesanan' => $getcicilan->nomorpesanan,
                            'jumlahbayar' => $getcicilan->hargacicilan,
                            'jatuhtempo' => $getcicilan->jatuhtempo3,
                            'status' => 0
                        ]);

                    }
                    else if($getcicilan->jumlahcicilan ==4){
                        $insertbayarcicilan = DB::table('bayar_cicilans')->insert([
                            'nomorpesanan' => $getcicilan->nomorpesanan,
                            'jumlahbayar' => $getcicilan->hargacicilan,
                            'jatuhtempo' => $getcicilan->jatuhtempo1,
                            'status' => 0
                        ]);

                        $insertbayarcicilan2 = DB::table('bayar_cicilans')->insert([
                            'nomorpesanan' => $getcicilan->nomorpesanan,
                            'jumlahbayar' => $getcicilan->hargacicilan,
                            'jatuhtempo' => $getcicilan->jatuhtempo2,
                            'status' => 0
                        ]);

                        $insertbayarcicilan3 = DB::table('bayar_cicilans')->insert([
                            'nomorpesanan' => $getcicilan->nomorpesanan,
                            'jumlahbayar' => $getcicilan->hargacicilan,
                            'jatuhtempo' => $getcicilan->jatuhtempo3,
                            'status' => 0
                        ]);

                        $insertbayarcicilan4 = DB::table('bayar_cicilans')->insert([
                            'nomorpesanan' => $getcicilan->nomorpesanan,
                            'jumlahbayar' => $getcicilan->hargacicilan,
                            'jatuhtempo' => $getcicilan->jatuhtempo4,
                            'status' => 0
                        ]);
                    }
                

                }

                $update = DB::table('cicilans')->where('id',$request->id)->update(
                    ['status'=>$request->status]
                );

            
                $response = [
                    'message' => 'Diterima',
                    'data' => 1 ];   
            } catch (QueryException $th) {
                $response = [
                    'message' => 'Checkout data gagal',
                    'data' => $th->errorInfo ];   
            }
            
            return response()->json($response,Response::HTTP_OK);  

    }

    public function updatejatuhtempo(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'id' => 'required|max:255',
                'jatuhtempo' => 'required|string|max:255'
                ]);
    
            if($validator->fails()){
                $response = [
                    'message' => 'pastikan data sudah benar',
                    'error'=>$validator->errors(),
                    'data' => 0
                ];        
                return response()->json($response,Response::HTTP_OK);
            }
    
                $update = DB::table('bayar_cicilans')->where('id',$request->id)->update(
                    ['jatuhtempo'=>$request->jatuhtempo]
                );
                $response = [
                    'message' => 'update sukse',
                    'data' => 1
                ];        
                return response()->json($response,Response::HTTP_OK);


        } catch (QueryException $th) {
            $response = [
                'message' => 'Checkout data gagal',
                'data' => $th->errorInfo ];   
            return response()->json($response,Response::HTTP_OK);

        }
    }

    public function getsumcicilanakun(Request $request)
    {
        try {
            $getpesanan = DB::table('cicilans')->where('nomorpesanan',$request->input('nomorpesanan'))->first();
            $getdata = DB::table('bayar_cicilans')->where('nomorpesanan',$request->input('nomorpesanan'))->sum('status'); 
            if ($getpesanan->jumlahcicilan == $getdata) {
                $response = [
                    'message' => 'get data berhasil',
                    'data' => 1];  
            }else{
                $response = [
                    'message' => 'get data berhasil',
                    'data' => 0];  
            }

        } catch (QueryException $th) {
            $response = [
                    'message' => 'get data gagal',
                    'data' => $th->errorInfo];  
        }
          return response()->json($response,Response::HTTP_OK);
    }


    public function updatesudahbayar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'id' => 'required|max:255',
                'status' => 'required|string|max:255'
                ]);
    
            if($validator->fails()){
                $response = [
                    'message' => 'pastikan data sudah benar',
                    'error'=>$validator->errors(),
                    'data' => 0
                ];        
                return response()->json($response,Response::HTTP_OK);
            }
    
                $update = DB::table('bayar_cicilans')->where('id',$request->id)->update(
                    ['status'=>$request->status]
                );
                $response = [
                    'message' => 'update sukse',
                    'data' => 1
                ];        
                return response()->json($response,Response::HTTP_OK);


        } catch (QueryException $th) {
            $response = [
                'message' => 'Checkout data gagal',
                'data' => $th->errorInfo ];   
            return response()->json($response,Response::HTTP_OK);

        }
    }
    public function readbayarcicilan(Request $request)
    {
        try {
            $getcicilan = DB::table('bayar_cicilans')
            ->where('nomorpesanan',$request->input('nomorpesanan'))
            ->orderBy('jatuhtempo','ASC')
            ->get();

            $response = [
                'message' => 'datacicilan',
                'data' => $getcicilan ];   
            return response()->json($response,Response::HTTP_OK);  


        } catch (QueryException $th) {
            $response = [
                'message' => 'get cicilan gagal',
                'data' => $th->errorInfo ];   
            return response()->json($response,Response::HTTP_OK);  

        }
    }

    public function finishcicilan(Request $request)
    {
            $validator = Validator::make($request->all(),[
            'nomorpesanan' => 'required|max:255'
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
            $nomorpesanan = DB::table('transaksis')->where('nomorpesanan',$request->nomorpesanan)->first();
            if ($nomorpesanan !=null) {
                $response = [
                    'message' => 'data ada',
                    'data' => 0 ];   
                return response()->json($response,Response::HTTP_OK);  
            }
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date('Y-m-d', time());
            $jam = date('h:i:s', time());

            $getcicilan = DB::table('cicilans')->where('nomorpesanan',$request->nomorpesanan)->first();

            $cartcheckout = DB::table('carts')->where('idusers',$getcicilan->idusers)->where('pickcart',1)->where('status',0)->update(
                ['status'=>1,'nomorpesanan'=>$getcicilan->nomorpesanan]
            );
        
            $user = transaksi::create([
                        'nama' => $getcicilan->nama,
                        'idusers' => $getcicilan->idusers,
                        'telepon' => $getcicilan->telepon,
                        'alamat' => $getcicilan->alamat,
                        'nomorpesanan' => $getcicilan->nomorpesanan,
                        'metodepembayaran' => $getcicilan->metodepembayaran,
                        'totalharga' => $getcicilan->totalharga,
                        'diskon' => $getcicilan->diskon,
                        'tanggal' => $tanggal,
                        'jam' => $jam,
                        'status'=> 2,
                        'foto'=> $getcicilan->foto,
                        'hargacicilan'=> $getcicilan->hargacicilan,
                        'jumlahcicilan'=> $getcicilan->jumlahcicilan,
                    ]);

                    $update = DB::table('cicilans')->where('nomorpesanan',$getcicilan->nomorpesanan)->update(
                        ['status'=>2]
                    );
    
            $response = [
                'message' => 'Checkout data berhasil',
                'data' => 1 ];   
                
        } catch (QueryException $th) {
            $response = [
                'message' => 'Checkout data gagal',
                'data' => $th->errorInfo ];   
        }
        
        return response()->json($response,Response::HTTP_OK);  

    }


}
