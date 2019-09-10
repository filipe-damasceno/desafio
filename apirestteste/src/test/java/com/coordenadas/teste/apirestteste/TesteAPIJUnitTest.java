package com.coordenadas.teste.apirestteste;

import com.coordenadas.teste.apirestteste.helper.Util;
import com.coordenadas.teste.apirestteste.helper.Veiculo;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.squareup.okhttp.Response;
import java.io.IOException;
import java.util.List;
import org.junit.Test;
import static org.junit.Assert.*;

/**
 *
 * @author Filipe
 */
public class TesteAPIJUnitTest {
    
    Util util = new Util("http://localhost:8080/api/v1", 12345,999);
    
    
     @Test
     public void testeEnvioCoordenadas() {
        List<String> listaCoordenadas;
        listaCoordenadas = util.initCoordenadasVehicleIdA();
        listaCoordenadas.addAll(util.initCoordenadasVehicleIdB());

        while(!listaCoordenadas.isEmpty()){
            int index = util.indexRandom(listaCoordenadas.size());
            String json = listaCoordenadas.get(index);
            try {
               Response response = util.sendPost(json);
               assertEquals(response.code(),200);
               listaCoordenadas.remove(index);
            } catch (IOException ex) {
               assertTrue("IOException in post",false);
            }             
        }
     }
     
     @Test
     public void testeOrderByAsc() {
        try {            
            Response response = util.sendGet( util.getVehicleIdA());
            assertEquals(response.code(),200);
            ObjectMapper objectMapper = new ObjectMapper();
            Veiculo[] coordenadas = objectMapper.readValue(response.body().string(), Veiculo[].class);
            for(int i = 1;i < coordenadas.length;i++){
                if(coordenadas[i-1].getInstant().after(coordenadas[i].getInstant()))
                    assertTrue("listagem desordenada", false);
            }            
            response = util.sendGet(util.getVehicleIdB());
            assertEquals(response.code(),200);
            objectMapper = new ObjectMapper();
            coordenadas = objectMapper.readValue(response.body().string(), Veiculo[].class);
            for(int i = 1;i < coordenadas.length;i++){
                if(coordenadas[i-1].getInstant().after(coordenadas[i].getInstant()))
                    assertTrue("listagem desordenada", false);
            }
            assertTrue("listagem ordenada", true);
        } catch (IOException ex) {
            assertTrue("IOException in get",false);
        }
     }
}
