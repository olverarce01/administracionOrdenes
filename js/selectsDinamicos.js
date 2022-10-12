$(function() {
  


    $("#selectMateriales").on("change",function(e){
        var optionsSelected=$("#selectMateriales option:selected",this);

        precioTotal=0;
        $("#cantidadMateriales").empty();
        materiales.clear();
        for (let index = 0; index < optionsSelected.prevObject[0].options.length; index++) {
          if(optionsSelected.prevObject[0].options[index].selected){

            materiales.set(optionsSelected.prevObject[0].options[index].value, optionsSelected.prevObject[0].options[index].attributes.precio.value);
            $("#cantidadMateriales").append( `material: ${optionsSelected.prevObject[0].options[index].value} cantidad : <input type='number' value='1' onChange='cantidadMaterial(value,${optionsSelected.prevObject[0].options[index].attributes.precio.value},"${optionsSelected.prevObject[0].options[index].value}")'/> <br>` );
          }
        }
        materiales.forEach((values,keys)=>{
              precioTotal+=parseInt(values);
            });
        $("#precioMateriales").val(precioTotal);


      });


      $("#selectFuncionariosEjecutores").on("change",function(e){
        var optionsSelected=$("#selectFuncionariosEjecutores option:selected",this);

        precioTotal=0;
        $("#cantidadFuncionariosEjecutores").empty();
        funcionariosEjecutores.clear();
        for (let index = 0; index < optionsSelected.prevObject[0].options.length; index++) {
          if(optionsSelected.prevObject[0].options[index].selected){
            funcionariosEjecutores.set(optionsSelected.prevObject[0].options[index].value, optionsSelected.prevObject[0].options[index].attributes.precioHora.value);

            $("#cantidadFuncionariosEjecutores").append( `funcionario: ${optionsSelected.prevObject[0].options[index].value} precioHora : ${optionsSelected.prevObject[0].options[index].attributes.precioHora.value} <br>` );
          }
        }
        funcionariosEjecutores.forEach((values,keys)=>{
              precioTotal+=parseInt(values);
            });
        $("#cantidadPersonas").val(funcionariosEjecutores.size);
        $("#precioFuncionariosEjecutores").val(precioTotal);

      });

  });