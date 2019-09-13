package com.coordenadas.teste.apirestteste.helper;

import com.squareup.okhttp.MediaType;
import com.squareup.okhttp.OkHttpClient;
import com.squareup.okhttp.Request;
import com.squareup.okhttp.RequestBody;
import com.squareup.okhttp.Response;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Random;

/**
 *
 * @author filip
 */
public class Util {
    public int vehicleIdA;
    public int vehicleIdB;
    public String urlBase;
    
    private static Util singleton = new Util();
    
    public static Util getInstance(){
        return singleton;
    }
    
    public void init(String urlBase, int vehicleIdA,int vehicleIdB){
        this.urlBase = urlBase;
        this.vehicleIdA = vehicleIdA;
        this.vehicleIdB = vehicleIdB;
    }
    
    public List<String> initCoordenadasVehicleIdA(){
        List<String> listaCoordenadas = new ArrayList<>();        
        
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T20:48:15+00:00\", \"vehicleId\": "+vehicleIdA+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T21:48:15+00:00\", \"vehicleId\": "+vehicleIdA+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T21:50:15+00:00\", \"vehicleId\": "+vehicleIdA+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T22:18:15+00:00\", \"vehicleId\": "+vehicleIdA+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T22:28:15+00:00\", \"vehicleId\": "+vehicleIdA+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T22:48:15+00:00\", \"vehicleId\": "+vehicleIdA+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T23:48:15+00:00\", \"vehicleId\": "+vehicleIdA+"}");
        
        return listaCoordenadas;
    }
    
    public List<String> initCoordenadasVehicleIdB(){
        List<String> listaCoordenadas = new ArrayList<>();        
        
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T20:48:15+00:00\", \"vehicleId\": "+vehicleIdB+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T21:48:15+00:00\", \"vehicleId\": "+vehicleIdB+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T21:50:15+00:00\", \"vehicleId\": "+vehicleIdB+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T22:18:15+00:00\", \"vehicleId\": "+vehicleIdB+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T22:28:15+00:00\", \"vehicleId\": "+vehicleIdB+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T22:48:15+00:00\", \"vehicleId\": "+vehicleIdB+"}");
        listaCoordenadas.add("{\"lat\": -3.734652, \"long\": -38.469755, \"instant\": \"2018-08-08T23:48:15+00:00\", \"vehicleId\": "+vehicleIdB+"}");
        return listaCoordenadas;
    }

    public int indexRandom(int size){
        Random gerador;
        
        gerador = new Random();
        int index = gerador.nextInt(size);
        
        return index;
    }
    
    public Response sendPost(String json) throws IOException{
        OkHttpClient client = new OkHttpClient();

        MediaType mediaType = MediaType.parse("application/json");
        RequestBody body = RequestBody.create(mediaType, json);
        Request request = new Request.Builder()
          .url(urlBase+"/coordenada")
          .post(body)
          .addHeader("Content-Type", "application/json")
          .build();

        Response response = client.newCall(request).execute();
        return response;
    }
    
    public Response sendGet(int vehicleId) throws IOException{
        OkHttpClient client = new OkHttpClient();

        Request request = new Request.Builder()
          .url(urlBase+"/vehicleId/"+vehicleId)
          .get()
          .build();

        Response response = client.newCall(request).execute();
        return response;
    }

}
