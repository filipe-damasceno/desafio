package com.coordenadas.apirest.repository;

import com.coordenadas.apirest.models.Coordenadas;
import java.util.List;
import org.springframework.data.jpa.repository.JpaRepository;

/**
 *
 * @author Filipe
 */
public interface CoordenadasRepository extends JpaRepository<Coordenadas,Long>{
    //List<Coordenadas> findByVehicleId(long id);
    List<Coordenadas> findByVehicleIdOrderByInstantAsc(long id);
}
