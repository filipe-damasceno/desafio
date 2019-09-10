
package com.coordenadas.teste.apirestteste.helper;

import com.fasterxml.jackson.annotation.JsonProperty;
import java.sql.Timestamp;

/**
 *
 * @author filip
 */
public class Veiculo {
    private long id;
    @JsonProperty("lat")
    private Double latitude;
    @JsonProperty("long")
    private Double longitude;    
    private Timestamp instant;
    private long vehicleId;

    /**
     * @return the id
     */
    public long getId() {
        return id;
    }

    /**
     * @param id the id to set
     */
    public void setId(long id) {
        this.id = id;
    }

    /**
     * @return the latitude
     */
    public Double getLatitude() {
        return latitude;
    }

    /**
     * @param latitude the latitude to set
     */
    public void setLatitude(Double latitude) {
        this.latitude = latitude;
    }

    /**
     * @return the longitude
     */
    public Double getLongitude() {
        return longitude;
    }

    /**
     * @param longitude the longitude to set
     */
    public void setLongitude(Double longitude) {
        this.longitude = longitude;
    }

    /**
     * @return the instant
     */
    public Timestamp getInstant() {
        return instant;
    }

    /**
     * @param instant the instant to set
     */
    public void setInstant(Timestamp instant) {
        this.instant = instant;
    }

    /**
     * @return the vehicleId
     */
    public long getVehicleId() {
        return vehicleId;
    }

    /**
     * @param vehicleId the vehicleId to set
     */
    public void setVehicleId(long vehicleId) {
        this.vehicleId = vehicleId;
    }
}
