
async function  eliminarCategoria(id){
    await $.get(`./recursos/categorias.php?modo=eliminar&id=${id}`, function(mensaje, estado){   
   $("div").remove(".categorias");  
   $("option").remove(".categorias");            
     
   JSON.parse(mensaje).forEach(element => {
           $("#opcionesCategorias").append(`<div class='categorias'>${element.categoria} <button type='button' onclick='eliminarCategoria(${element.id})'>Eliminar</button> </div>`);
           $("#categoria").append(`<option value='${element.id}' class='categorias'>${element.categoria}</option>`);
           $("#categoriaFiltro").append(`<option value='${element.id}' class='categorias'>${element.categoria}</option>`);
   });
   });
   $.get(`./recursos/ordenesGrafico.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
               
               console.log(mensaje);
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
     
              
                 myChart.destroy();
                 myChart = new Chart(ctx, {
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
                 options: {
                   scales: {
                     yAxes: {
                       ticks: {
                          stepSize: 1,
                       }
                     }
                   }
                 }
               });   
     
               
               });
 }
 async function agregarCategoria(){
   var Nombrecategoria=$("#nombreCategoria").val();
   await $.get(`./recursos/categorias.php?modo=agregar&nombre=${Nombrecategoria}`, function(mensaje, estado){   
   
   $("div").remove(".categorias");    
   $("option").remove(".categorias");            
   
   JSON.parse(mensaje).forEach(element => {
           $("#opcionesCategorias").append(`<div class='categorias'>${element.categoria} <button type='button' onclick='eliminarCategoria(${element.id})'>Eliminar</button> </div>`);
           $("#categoria").append(`<option value='${element.id}' class='categorias'>${element.categoria}</option>`);
           $("#categoriaFiltro").append(`<option value='${element.id}' class='categorias'>${element.categoria}</option>`);


   });
   });
   $.get(`./recursos/ordenesGrafico.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
               
               console.log(mensaje);
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
     
              
                 myChart.destroy();
                 myChart = new Chart(ctx, {
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
                 options: {
                   scales: {
                     yAxes: {
                       ticks: {
                          stepSize: 1,
                       }
                     }
                   }
                 }
               });   
     
               
               });
   $("#nombreCategoria").val("");
 }