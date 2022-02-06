<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProdukCheckout;
use App\Models\transaksi;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{


    //0 = dalam proses
    //1 = sedang dikirim
    //2 = selesai
    //3 = ditolak
     public function checkout(Request $request)
        {
                $validator = Validator::make($request->all(),[
                'idusers' => 'required|max:255',
                'nama' => 'required|string|max:255',
                'telepon' => 'required|max:255',
                'alamat' => 'required|max:255',
                'metodepembayaran' => 'required|max:255',
                'totalharga' => 'required|max:255',
                'diskon' => 'required|max:255',
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
                date_default_timezone_set('Asia/Jakarta');
                $tanggal = date('Y-m-d', time());
                $jam = date('h:i:s', time());
                $cartcheckout = DB::table('carts')->where('idusers',$request->idusers)->where('pickcart',1)->where('status',0)->update(
                    ['status'=>1,'nomorpesanan'=>$request->nomorpesanan]
                );
            
                $user = transaksi::create([
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
                            'foto'=> $request->foto,
                        ]);
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

    public function getprodukcheckout(Request $request)
        {
            $getdata = DB::table('carts')->where('idusers',$request->input('idusers'))->where('nomorpesanan',$request->input('nomorpesanan'))->get();          
            $response = [
                    'message' => 'getdata',
                    'data' => $getdata
            ];        
                return response()->json($response,Response::HTTP_OK);
        }


    public function getdetailtransaksi(Request $request)
    {
            try {
                $getdata = DB::table('transaksis')->where('idusers',$request->input('idusers'))->where('nomorpesanan',$request->input('nomorpesanan'))->first(); 
                $response = [
                        'message' => 'get data berhasil',
                        'data' => $getdata];  
            } catch (QueryException $th) {
              $response = [
                'message' => 'get data gagal',
                'data' => $th->errorInfo ];   
        }
      return response()->json($response,Response::HTTP_OK);  

    }

    public function gettransaksibyidusers(Request $request)
    {
            $getdata = DB::table('transaksis')->where('idusers',$request->input('idusers'))->orderBy('created_at','DESC')->get();          
            $response = [
                    'message' => 'getdata',
                    'data' => $getdata
            ];        
                return response()->json($response,Response::HTTP_OK);
    }
    
    public function gettransaksiadmin(Request $request)
    {
        try {
            $getdata = DB::table('transaksis')->orderBy('status','ASC')->orderBy('created_at','ASC') ->get(); 
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

    public function gettransaksibystatusadmin(Request $request)
    {
        try {
            $getdata = DB::table('transaksis')->where('status',$request->input('status'))->orderBy('created_at','ASC') ->get(); 
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

    public function updatestatuscheckout(Request $request)
    {
           try {
                $update = DB::table('transaksis')->where('id',$request->id)->update(
                    ['status'=>$request->status]
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
 
    public function totalpenghasilan()
    {
           try {
                $total = DB::table('transaksis')->where('status',2)->sum('totalharga');
                $response = [
                    'message' => 'Checkout data berhasil',
                    'data' => $total ];   
            } catch (QueryException $th) {
                $response = [
                    'message' => 'Checkout data gagal',
                    'data' => $th->errorInfo ];   
            }
            
            return response()->json($response,Response::HTTP_OK);  
    }

   public function totalpenghasilantahunini(Request $request)
    {
         try {
            $revenues = DB::table('transaksis')->where('status',2)->whereYear('updated_at', $request->input('tahun'))
            ->sum('totalharga');

            $response = [
                        'message' => 'Jumlah penghasilan tahun ini',
                        'data' => $revenues ];  
            } catch (QueryException $th) {
                $response = [
                    'message' => 'Checkout data gagal',
                    'data' => $th->errorInfo ];   
            }
            
            return response()->json($response,Response::HTTP_OK);   
    }

    public function totalpenghasilanbulanini(Request $request)
    {
         try {
            $revenues = DB::table('transaksis')->where('status',2)->whereYear('updated_at', $request->input('tahun'))
            ->whereMonth('updated_at',$request->input('bulan'))->sum('totalharga');

            $response = [
                        'message' => 'Jumlah penghasilan bulan ini',
                        'data' => $revenues ];  
            } catch (QueryException $th) {
                $response = [
                    'message' => 'Checkout data gagal',
                    'data' => $th->errorInfo ];   
            }
            
            return response()->json($response,Response::HTTP_OK);   
    }

    public function totalpenghasilanhariini(Request $request)
    {
         try {
            $revenues = DB::table('transaksis')->where('status',2)->whereYear('updated_at', $request->input('tahun'))
            ->whereMonth('updated_at',$request->input('bulan'))->whereDay('updated_at',$request->input('hari'))->sum('totalharga');

            $response = [
                        'message' => 'Jumlah penghasilan bulan ini',
                        'data' => $revenues ];  
            } catch (QueryException $th) {
                $response = [
                    'message' => 'Checkout data gagal',
                    'data' => $th->errorInfo ];   
            }
            
            return response()->json($response,Response::HTTP_OK);   
    }
}
