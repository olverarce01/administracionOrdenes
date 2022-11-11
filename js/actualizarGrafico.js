function randomNumber(min, max) { 
  return Math.random() * (max - min) + min;
} 
  $(function() {    

 
  

  $("input[type='date'], input[type='time'], #fechaFiltro").on('change', function() {
    $.get(`./recursos/frecuenciaCategorias.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
                  
    if(mensaje === []){
      return;
    }

    var coloresEjemplo= ["#001BFF","#0016CE","#0012A8","#000D79","#00084D","#000531","#273EFF","#2234CE","#1928A7","#7382FF","#5761BB","#444B8E","#303562","#8700FF","#6B00CA","#54009E", "#A560FF","#874CD4","#5CA1FF","#4F8ADA","#3D6AA7","#2F4F7B","#00CAFF","#009BC4","#65DFFF","#56BBD5","#30FBCC","#29D6AE","#76F8DA","#5EC9B0","#FFF400","#CEC500","#FFF751","#DDD647","#B8B34C","#FFFA89","#DDD87A","#FFAF00","#DF9900","#C18400","#FFC139","#D5A12F","#AC8228","#FBCF6E","#D1AF65","#B29453","#FFDC90","#FF7D00","#FF9E41","#FFBD7D"];


    var categorias=[];
    var contadores=[];
    var colores= [];
    var index=0;
      JSON.parse(mensaje).forEach(element => {
          categorias.push(element.categoria);
          contadores.push(element.contador);
          index=randomNumber(0,coloresEjemplo.length-1);
          colores.push(coloresEjemplo.at(index));
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
  
      var coloresEjemplo= ["#001BFF","#0016CE","#0012A8","#000D79","#00084D","#000531","#273EFF","#2234CE","#1928A7","#7382FF","#5761BB","#444B8E","#303562","#8700FF","#6B00CA","#54009E", "#A560FF","#874CD4","#5CA1FF","#4F8ADA","#3D6AA7","#2F4F7B","#00CAFF","#009BC4","#65DFFF","#56BBD5","#30FBCC","#29D6AE","#76F8DA","#5EC9B0","#FFF400","#CEC500","#FFF751","#DDD647","#B8B34C","#FFFA89","#DDD87A","#FFAF00","#DF9900","#C18400","#FFC139","#D5A12F","#AC8228","#FBCF6E","#D1AF65","#B29453","#FFDC90","#FF7D00","#FF9E41","#FFBD7D"];

      var categorias=[];
      var contadores=[];
      var colores= [];
      var index=0;

        JSON.parse(mensaje).forEach(element => {
            categorias.push(element.categoria);
            contadores.push(element.precioMateriales);
            index=randomNumber(0,coloresEjemplo.length-1);
            colores.push(coloresEjemplo.at(index));
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
    
        var coloresEjemplo= ["#001BFF","#0016CE","#0012A8","#000D79","#00084D","#000531","#273EFF","#2234CE","#1928A7","#7382FF","#5761BB","#444B8E","#303562","#8700FF","#6B00CA","#54009E", "#A560FF","#874CD4","#5CA1FF","#4F8ADA","#3D6AA7","#2F4F7B","#00CAFF","#009BC4","#65DFFF","#56BBD5","#30FBCC","#29D6AE","#76F8DA","#5EC9B0","#FFF400","#CEC500","#FFF751","#DDD647","#B8B34C","#FFFA89","#DDD87A","#FFAF00","#DF9900","#C18400","#FFC139","#D5A12F","#AC8228","#FBCF6E","#D1AF65","#B29453","#FFDC90","#FF7D00","#FF9E41","#FFBD7D"];

        var categorias=[];
        var contadores=[];
        var colores= [];
        var index=0;

    
          JSON.parse(mensaje).forEach(element => {
              categorias.push(element.categoria);
              contadores.push(element.precioFuncionarios);
              index=randomNumber(0,coloresEjemplo.length-1);
              colores.push(coloresEjemplo.at(index));
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
      
          var coloresEjemplo= ["#001BFF","#0016CE","#0012A8","#000D79","#00084D","#000531","#273EFF","#2234CE","#1928A7","#7382FF","#5761BB","#444B8E","#303562","#8700FF","#6B00CA","#54009E", "#A560FF","#874CD4","#5CA1FF","#4F8ADA","#3D6AA7","#2F4F7B","#00CAFF","#009BC4","#65DFFF","#56BBD5","#30FBCC","#29D6AE","#76F8DA","#5EC9B0","#FFF400","#CEC500","#FFF751","#DDD647","#B8B34C","#FFFA89","#DDD87A","#FFAF00","#DF9900","#C18400","#FFC139","#D5A12F","#AC8228","#FBCF6E","#D1AF65","#B29453","#FFDC90","#FF7D00","#FF9E41","#FFBD7D"];

          var categorias=[];
          var contadores=[];
          var colores= [];
          var index=0;


            JSON.parse(mensaje).forEach(element => {
                categorias.push(element.categoria);
                contadores.push(element.costoTotal);
                index=randomNumber(0,coloresEjemplo.length-1);
                colores.push(coloresEjemplo.at(index));
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
      
          var coloresEjemplo= ["#001BFF","#0016CE","#0012A8","#000D79","#00084D","#000531","#273EFF","#2234CE","#1928A7","#7382FF","#5761BB","#444B8E","#303562","#8700FF","#6B00CA","#54009E", "#A560FF","#874CD4","#5CA1FF","#4F8ADA","#3D6AA7","#2F4F7B","#00CAFF","#009BC4","#65DFFF","#56BBD5","#30FBCC","#29D6AE","#76F8DA","#5EC9B0","#FFF400","#CEC500","#FFF751","#DDD647","#B8B34C","#FFFA89","#DDD87A","#FFAF00","#DF9900","#C18400","#FFC139","#D5A12F","#AC8228","#FBCF6E","#D1AF65","#B29453","#FFDC90","#FF7D00","#FF9E41","#FFBD7D"];

          var categorias=[];
          var contadores=[];
          var colores= [];
          var index=0;

            JSON.parse(mensaje).forEach(element => {
                categorias.push(element.horasHombre);
                contadores.push(element.frecuenciaHoras);
                index=randomNumber(0,coloresEjemplo.length-1);
                colores.push(coloresEjemplo.at(index));
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


  