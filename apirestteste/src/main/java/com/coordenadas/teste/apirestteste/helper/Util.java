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
    private int vehicleIdA;
    private int vehicleIdB;
    private String urlBase;
    
    public Util(String urlBase, int vehicleIdA,int vehicleIdB){
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

    /**
     * @return the vehicleIdA
     */
    public int getVehicleIdA() {
        return vehicleIdA;
    }

    /**
     * @param vehicleIdA the vehicleIdA to set
     */
    public void setVehicleIdA(int vehicleIdA) {
        this.vehicleIdA = vehicleIdA;
    }

    /**
     * @return the vehicleIdB
     */
    public int getVehicleIdB() {
        return vehicleIdB;
    }

    /**
     * @param vehicleIdB the vehicleIdB to set
     */
    public void setVehicleIdB(int vehicleIdB) {
        this.vehicleIdB = vehicleIdB;
    }

    /**
     * @return the urlBase
     */
    public String getUrlBase() {
        return urlBase;
    }

    /**
     * @param urlBase the urlBase to set
     */
    public void setUrlBase(String urlBase) {
        this.urlBase = urlBase;
    }
}
