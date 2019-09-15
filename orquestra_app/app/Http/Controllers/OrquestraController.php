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
        
        
        #CLONE repositorio PR 
        exec('git clone -b '.$branche.' '.$cloneUrl);
        Log::info('Clone respositorio PR '.$branche);
        #BUILD apirest 
        exec('mvn clean package -Dmaven.test.skip=true -f desafio/apirest/pom.xml');
        Log::info('Build project apirest');
        #BUILD apirestteste 
        exec('mvn clean package -Dmaven.test.skip=true -f desafio/apirestteste/pom.xml');
        Log::info('Build project apirestteste');

        #BUILD dockerfiles
        exec('docker-compose -f desafio/docker-compose.yml build');
        Log::info('Build dockerfiles');
        #Pull image postgres
        exec('docker pull postgres:10.4');
        Log::info('Pull image postgres');
        #BUILD docker-compose up
        Log::info('Run docker-compose up init');
        exec('docker-compose -f desafio/docker-compose.yml up -d');
        Log::info('Run docker-compose up finish');

        Log::info('check status services');
        $statusTest = $this->statusServicesTest();        
        while($statusTest != true)
            $statusTest = $this->statusServicesTest();
        Log::info('status service test:'.$statusTest);
        
        $statusAPI = $this->statusServicesAPI();
        while($statusAPI != true)
            $statusAPI = $this->statusServicesAPI();
        Log::info('status service test:'.$statusAPI);

        Log::info('Start test container: localhost:9000 init');
        
        $responseObj = $this->startTeste();             
        Log::info('test container: localhost:9000 finish: '.$responseObj);
        
        
        Log::info('comment result test in PR gitHub');
        $this->comentResultTest($comentUrl,$responseObj);
        Log::info('set status in PR gitHub');
        $this->statusSetPR($statusesUrl,$responseObj,$branche);
        
        Log::info('stop containers');
        exec('docker-compose -f desafio/docker-compose.yml stop');
        Log::info('rm containers');
        exec('docker-compose -f desafio/docker-compose.yml rm -f');
        Log::info('rmi images');
        exec('docker rmi app');        
        exec('docker rmi apptest');        
        return response()->json(['status' => "status_OK",'resultado'=>$responseObj], 200); 
    }

    public function statusServicesTest(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_PORT => "9000",
        CURLOPT_URL => "http://localhost:9000/api/v1/status",
        CURLOPT_RETURNTRANSFER => true,        
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Accept: */*"            
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        
        if($err)            
            return false;        
        else
            return true;
    }

    public function statusServicesAPI(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8080",
            CURLOPT_URL => "http://localhost:8080/api/v1/status",
            CURLOPT_RETURNTRANSFER => true,            
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
              "Accept: */*"              
            ),
          ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        
        if($err)            
            return false;        
        else
            return true;
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
        curl_close($curl);
        return $response;
    }

    public function statusSetPR($statusesUrl,$responseObj,$branche){
        $curl = curl_init();

        try{
            $erros = explode(':',explode(';',$responseObj)[1])[1];
            if($erros == 0){
                $description = 'Sucesso no teste';
                $state = 'success';
            }
            elseif($erros > 0){
                $description = 'Falha no teste';
                $state = 'failure';
            }
        }catch(Exception $e){ 
            $description = 'Service test return inesperado';
            $state = 'error';
        }
                
              
        $body = [
            "state" => $state,
            "target_url" => 'https://github.com/filipe-damasceno/desafio/tree/'.$branche,
            "description" => $description,
            "context" => "test container junit"
        ];

        Log::info('body status PR:'.json_encode($body));
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
        curl_close($curl);
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
        $err = curl_error($curl);
        curl_close($curl);
        return $responseObj;
    }
}
