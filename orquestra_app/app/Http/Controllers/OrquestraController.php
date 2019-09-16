<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Jobs\OrquestracaoJob;


use Illuminate\Http\Request;

class OrquestraController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    /**
     * Receive payload and dispach JOB on QUEUE.
     *
     * @return Responser
     */
    public function payload(Request $request){
        $dados =(object) $request->all();
        OrquestracaoJob::dispatch($dados);   //JOB  
        return response()->json(['status' => "status_OK"], 202); 
    }
}
