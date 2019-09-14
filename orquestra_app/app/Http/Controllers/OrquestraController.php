<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


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
        set_time_limit(8000000);
    }



    public function payload(Request $request){
        $dados =(object) $request->all();
        $branche = $dados->pull_request['head']['ref'];
        $cloneUrl = $dados->repository['clone_url'];
        $comentUrl = $dados->pull_request['comments_url'];
        $shaPR = $dados->pull_request['head']['sha'];
        $statusesUrl = $dados->pull_request['statuses_url'];
        
        
        
        exec('git clone -b '.$branche.' '.$cloneUrl);
        exec('mvn clean package -Dmaven.test.skip=true -f desafio/apirest/pom.xml');
        exec('mvn clean package -Dmaven.test.skip=true -f desafio/apirestteste/pom.xml');
        exec('docker-compose -f desafio/docker-compose.yml up -d');
        $responseObj = $this->startTeste();

        
        exec('docker-compose -f desafio/docker-compose.yml stop');
        exec('docker-compose -f desafio/docker-compose.yml rm -f');
        exec('docker rmi $(docker images -q)');
        $this->comentResultTest($comentUrl,$responseObj);
        $this->statusSetPR($statusesUrl,$responseObj,$branche);
        
        Log::info('Payload '.json_encode($dados));
        return response()->json(['status' => "status_OK",'resultado'=>$responseObj], 202); 
    }

    public function comentResultTest($urlComent,$result){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $urlComent,
        CURLOPT_RETURNTRANSFER => true,        
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode(['body' => 'resultado teste: '.$result]),
        CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            "Authorization: token 0f1de63eacd8768367cb20c3a5ccee5c38345cd0",            
            "Content-Type: application/json",
            "User-Agent: Awesome-Octocat-App"            
        ),
        ));

        $response = curl_exec($curl);
        return $response;
    }

    public function statusSetPR($statusesUrl,$responseObj,$branche){
        $curl = curl_init();

        if(explode(':',explode(';',$responseObj)[1])[1] == 0){
            $description = 'Sucesso no teste';
            $state = 'success';
        }
        elseif(explode(':',explode(';',$responseObj)[1])[1] > 0){
            $description = 'Falha no teste';
            $state = 'failure';
        }
        else{
            $description = 'Serviço de teste inacessivel';
            $state = 'error';
        }


            
                
              
        $body = [
            "state" => $state,
            "target_url" => 'https://github.com/filipe-damasceno/desafio/tree/'.$branche,
            "description" => $description,
            "context" => "test container junit"
        ];






        curl_setopt_array($curl, array(
        CURLOPT_URL => $statusesUrl,
        CURLOPT_RETURNTRANSFER => true,        
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => array(
            "Accept: */*",            
            "Authorization: token 0f1de63eacd8768367cb20c3a5ccee5c38345cd0",            
            "Content-Type: application/json",            
            "User-Agent: Awesome-Octocat-App"      
        ),
        ));

        $response = curl_exec($curl);
        return $response;
    }

    public function startTeste(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_PORT => "9000",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_URL => "http://localhost:9000/api/v1/testApi",        
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "http://docker-app:8080/api/v1/",
        CURLOPT_HTTPHEADER => array(
            "Accept: */*",            
            
            "Content-Type: text/plain",
            "Host: localhost:9000",            
        ),
        ));

        $responseObj = curl_exec($curl);
        curl_close($curl);
        return $responseObj;
    }
}
