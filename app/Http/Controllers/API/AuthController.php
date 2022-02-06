<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
          $validator = Validator::make($request->all(),[
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomorwa' => 'required|string|max:255',
            'password' => 'required|string|max:255'
            ]);

        if($validator->fails()){
             $response = [
                'message' => 'pastikan data sudah benar',
                'error'=>$validator->errors(),
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);
        }

        $ceknik = DB::table('users')->where('nomorwa',$request->nomorwa)->first();
        if($ceknik==null){
           
        }else {
            $response = [
                'message' => 'nomor wa terdaftar',
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);  
        }

         $user = User::create([
             'nama' => $request->nama,
             'alamat' => $request->alamat,
             'nomorwa' => $request->nomorwa,
             'password' => Hash::make($request->password),
         ]);
         $token = $user->createToken('auth_token')->plainTextToken;
                    $response = [
                                    'message' => $user['nomorwa'],
                                    'data' => 1,
                                    'token' => $token,
                                    'id' => $user['id']
                                ];   
        return response()->json($response,Response::HTTP_OK);  
    }

      //Proses Login
     public function login(Request $request)
    {
        if (!Auth::attempt($request->only('nomorwa', 'password')))
        {
             $response = [
                'message' => 'nomorwa atau password salah',
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);  
        }

        $user = User::where('nomorwa', $request['nomorwa'])->first();
        if ($user==null) {
            $response = [
                'message' => 'nomorwa atau password salah',
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);  
        }
        $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
                'message' => $user->nomorwa,
                'token' => $token,
                'data' => 1,
                'id' => $user->id
            ];        
            return response()->json($response,Response::HTTP_OK);  

    }
    //End Proses Login

     
}
