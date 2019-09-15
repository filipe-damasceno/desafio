package com.coordenadas.teste.apirestteste.teste;

import com.coordenadas.teste.apirestteste.*;
import com.coordenadas.teste.apirestteste.helper.Util;
import com.coordenadas.teste.apirestteste.helper.Veiculo;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.squareup.okhttp.Response;
import java.io.IOException;
import java.util.List;
import junit.framework.TestCase;
import org.junit.Test;
import org.junit.Assert.*;

/**
 *
 * @author Filipe
 */
public class TesteAPIJUnitTest extends TestCase{
  
     @Test
     public void testeOrderByAsc() {
        List<String> listaCoordenadas;
        listaCoordenadas = Util.getInstance().initCoordenadasVehicleIdA();
        listaCoordenadas.addAll(Util.getInstance().initCoordenadasVehicleIdB());

        while(!listaCoordenadas.isEmpty()){
            int index = Util.getInstance().indexRandom(listaCoordenadas.size());
            String json = listaCoordenadas.get(index);
            try {
               Response response = Util.getInstance().sendPost(json);
               while(response.code() != 200)
                   response = Util.getInstance().sendPost(json);               
               listaCoordenadas.remove(index);
            } catch (IOException ex) {
               assertTrue("IOException in post",false);
            }             
        }
         
         
        try {            
            Response response = Util.getInstance().sendGet( Util.getInstance().vehicleIdA);
            assertEquals(response.code(),200);
            ObjectMapper objectMapper = new ObjectMapper();
            Veiculo[] coordenadas = objectMapper.readValue(response.body().string(), Veiculo[].class);
            for(int i = 1;i < coordenadas.length;i++){
                if(coordenadas[i-1].getInstant().after(coordenadas[i].getInstant()))
                    assertTrue("listagem desordenada", false);
            }            
            response = Util.getInstance().sendGet(Util.getInstance().vehicleIdB);
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
