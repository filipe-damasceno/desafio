<?php
    /**
     * Check status service container Port 9000
     *
     * @return boolean
     */
    function statusServicesTest(){
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
    /**
     * Check status service container Port 8080
     *
     * @return boolean
     */
    function statusServicesAPI(){
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

    /**
     * Comment result in PR gitHub
     *
     * @return Response
     */
    function comentResultTest($urlComent,$result){
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
    /**
     * set status check in PR gitHub
     *
     * @return Response
     */
    function statusSetPR($statusesUrl,$responseObj,$branche){
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
    /**
     * start test in container port 9000
     *
     * @return Response
     */
    function startTeste(){
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