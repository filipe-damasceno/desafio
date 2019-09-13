<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class OrquestraController extends Controller
{
    public function payload(Request $request){
        $dados =(object) $request->all();
        dd($dados);

        Log::info('Payload '.$dados);
        return response()->json(['status' => "status_OK"], 200); 
    }
}
