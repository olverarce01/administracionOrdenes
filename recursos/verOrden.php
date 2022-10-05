<?php
        include "./conexion.php";
        $id= $_GET['ver'];
        $sql = "SELECT ordenes.id, nombre, idCategoria, categorias.categoria as categoria, fechaCreacion, fechaEdicion, terminada, fechaTermino FROM ordenes, categorias WHERE ordenes.id=".$id." && categorias.id=idCategoria";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
            if($row["terminada"]==0){
                echo "<div id='".$row["id"]."'> NºSolicitud: " . $row["id"]. " Nombre: " . $row["nombre"]. " Categoria:" . $row["categoria"]. " Fecha Solicitud:" . $row["fechaCreacion"]. " Edicion:" . $row["fechaEdicion"]. "</div> <br>";
            }else{
                echo "<div id='".$row["id"]."'> NºSolicitud: " . $row["id"]. " Nombre: " . $row["nombre"]. " Categoria:" . $row["categoria"]. " Fecha Solicitud:" . $row["fechaCreacion"]. " Edicion:" . $row["fechaEdicion"]. " Fecha de Termino:" . $row["fechaTermino"]."</div> <br>";
            }

            }
          } else {
            echo "0 resultados";
          }
         
    ?>