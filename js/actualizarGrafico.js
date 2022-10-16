function random_rgba() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + '0.7' + ')';
}
  $(function() {    

 
  

  $("input[type='date'], input[type='time'], #fechaFiltro").on('change', function() {
    $.get(`./recursos/frecuenciaCategorias.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                  
    if(mensaje === []){
      return;
    }

    var categorias=[];
    var contadores=[];
    var colores= [];

      JSON.parse(mensaje).forEach(element => {
          categorias.push(element.categoria);
          contadores.push(element.contador);
          colores.push(random_rgba());
     });

   
      ChartfrecuenciaCategorias.destroy();
      ChartfrecuenciaCategorias = new Chart(frecuenciaCategorias, {
              type: 'bar',
              data: {
              labels: categorias,
              datasets: [{
              label: 'categorias',
              data: contadores,
              backgroundColor: colores, 
              borderWidth: 1
              }]
    },
      options: optionsChartfrecuenciaCategorias,
      plugins: [bgColor]
    });       
    });
    //--
    $.get(`./recursos/costoMaterialesCategorias.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                  
      if(mensaje === []){
        return;
      }
  
      var categorias=[];
      var contadores=[];
      var colores= [];
  
        JSON.parse(mensaje).forEach(element => {
            categorias.push(element.categoria);
            contadores.push(element.precioMateriales);
            colores.push(random_rgba());
       });
  
     
       ChartcostoMaterialesCategorias.destroy();
        ChartcostoMaterialesCategorias = new Chart(costoMaterialesCategorias, {
                type: 'bar',
                data: {
                labels: categorias,
                datasets: [{
                label: 'categorias',
                data: contadores,
                backgroundColor: colores, 
                borderWidth: 1
                }]
      },
        options: optionsChartcostoMaterialesCategorias,
        plugins: [bgColor]
      });       
      });
      //---
      $.get(`./recursos/costoFuncionariosEjecutores.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                  
        if(mensaje === []){
          return;
        }
    
        var categorias=[];
        var contadores=[];
        var colores= [];
    
          JSON.parse(mensaje).forEach(element => {
              categorias.push(element.categoria);
              contadores.push(element.precioFuncionarios);
              colores.push(random_rgba());
         });
    
       
         ChartcostoFuncionariosEjecutivosCategorias.destroy();
          ChartcostoFuncionariosEjecutivosCategorias = new Chart(costoFuncionariosEjecutivosCategorias, {
                  type: 'bar',
                  data: {
                  labels: categorias,
                  datasets: [{
                  label: 'categorias',
                  data: contadores,
                  backgroundColor: colores, 
                  borderWidth: 1
                  }]
        },
          options: optionsChartcostoFuncionariosEjecutivosCategorias,
          plugins: [bgColor]
        });       
        });
        //---
        $.get(`./recursos/costoTotalCategorias.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                  
          if(mensaje === []){
            return;
          }
      
          var categorias=[];
          var contadores=[];
          var colores= [];
      
            JSON.parse(mensaje).forEach(element => {
                categorias.push(element.categoria);
                contadores.push(element.costoTotal);
                colores.push(random_rgba());
           });
      
         
           ChartcostoTotalCategorias.destroy();
            ChartcostoTotalCategorias = new Chart(costoTotalCategorias, {
                    type: 'bar',
                    data: {
                    labels: categorias,
                    datasets: [{
                    label: 'categorias',
                    data: contadores,
                    backgroundColor: colores, 
                    borderWidth: 1
                    }]
          },
            options: optionsChartcostoTotalCategorias,
            plugins: [bgColor]
          });       
        });
        //--
        $.get(`./recursos/frecuenciaOrdenesPorHoras.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                  
          if(mensaje === []){
            return;
          }
          console.log(mensaje);
      
          var categorias=[];
          var contadores=[];
          var colores= [];
      
            JSON.parse(mensaje).forEach(element => {
                categorias.push(element.horasHombre);
                contadores.push(element.frecuenciaHoras);
                colores.push(random_rgba());
           });
      
         
           ChartfrecuenciaOrdenesPorHoras.destroy();
           ChartfrecuenciaOrdenesPorHoras = new Chart(frecuenciaOrdenesPorHoras, {
              type: 'line',
              data: {
                  labels: categorias,
                  datasets: [{
                      label: 'Frecuencia',
                      data: contadores,
                      backgroundColor: colores,
                      fill: {
                      target: 'origin',
                      above: 'rgba(173,216,230,0.4)',
                      below: 'rgba(255, 0, 255,1)'
                      },
                      borderWidth: 1,
                      pointRadius: 5
      
                  }]
              },
              options: optionsChartfrecuenciaOrdenesPorHoras
              ,plugins: [bgColor]
          });       
        });
  });

  });  


  