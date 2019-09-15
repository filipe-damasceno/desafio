package com.coordenadas.teste.apirestteste.endpoints;

import com.coordenadas.teste.apirestteste.helper.Util;
import com.coordenadas.teste.apirestteste.teste.TesteAPIJUnitTest;

import java.util.List;
import javax.xml.ws.Response;

import org.junit.runner.JUnitCore;
import org.junit.runner.Result;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

/**
 *
 * @author giselly_damasceno
 */
@RestController
@RequestMapping(value="/api/v1")
public class StartTestResource {
    @PostMapping("/testApi")
    public String listaCoordenadas(@RequestBody String baseUrl){
        Util.getInstance().init(baseUrl, 12345,999);
        Result result = JUnitCore.runClasses(TesteAPIJUnitTest.class);
        
        return "Executados: " + result.getRunCount()+";Falhas: " + result.getFailureCount();
    }
    @GetMapping("/status")
    public ResponseEntity status(){
        return new ResponseEntity(HttpStatus.OK);
    }
}
