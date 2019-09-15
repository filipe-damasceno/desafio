package com.coordenadas.apirest.endpoints;

import com.coordenadas.apirest.models.Coordenadas;
import com.coordenadas.apirest.repository.CoordenadasRepository;
import java.util.List;
import org.springframework.beans.factory.annotation.Autowired;
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
 * @author Filipe
 */
@RestController
@RequestMapping(value="/api/v1")
public class CoordenadasResource {
    @Autowired
    CoordenadasRepository coordenadasRepository;
    
    @GetMapping("/vehicleId/{vehicleId}")
    public List<Coordenadas> listaCoordenadas(@PathVariable(value="vehicleId") long vehicleId){
        return coordenadasRepository.findByVehicleId(vehicleId);
        //return coordenadasRepository.findByVehicleIdOrderByInstantAsc(vehicleId);
    }
 
    @PostMapping("/coordenada")
    public Coordenadas salvaCoordenada(@RequestBody Coordenadas Coordenada){
        return coordenadasRepository.save(Coordenada);
    }
    
    @GetMapping("/status")
    public ResponseEntity status(){
        return new ResponseEntity(HttpStatus.OK);
    }
}
