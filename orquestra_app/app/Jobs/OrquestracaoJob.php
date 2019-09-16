<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrquestracaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $dados;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dados = $this->dados;     
        #extract branche   
        $branche = $dados->pull_request['head']['ref'];
        #extract clone url
        $cloneUrl = $dados->repository['clone_url'];
        #extract comment url
        $comentUrl = $dados->pull_request['comments_url'];
        #extract sha PR
        $shaPR = $dados->pull_request['head']['sha'];
        #extract url status
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

        #Check status services containers
        Log::info('check status services');
        $statusTest = statusServicesTest(); //function Helper in app/Helpers       
        while($statusTest != true)
            $statusTest = statusServicesTest();
        Log::info('status service test:'.$statusTest);
        
        $statusAPI = statusServicesAPI(); //function Helper in app/Helpers   
        while($statusAPI != true)
            $statusAPI = statusServicesAPI();//function Helper in app/Helpers   
        Log::info('status service test:'.$statusAPI);

        #start test container 
        Log::info('Start test container: localhost:9000 init');        
        $responseObj = startTeste();             
        Log::info('test container: localhost:9000 finish: '.$responseObj);
        
        #comment result in PR
        Log::info('comment result test in PR gitHub');
        comentResultTest($comentUrl,$responseObj);
        #set status check in PR
        Log::info('set status in PR gitHub');
        statusSetPR($statusesUrl,$responseObj,$branche);
        
        #stoping containers
        Log::info('stop containers');
        exec('docker-compose -f desafio/docker-compose.yml stop');
        #remove containers
        Log::info('rm containers');
        exec('docker-compose -f desafio/docker-compose.yml rm -f');
        #remove images
        Log::info('rmi images');
        exec('docker rmi app');        
        exec('docker rmi apptest');        
        //remove folder project  
        exec('rm -r desafio -f');  
    }


    
}
