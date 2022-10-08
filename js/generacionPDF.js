    $("#descargarCanvas").click(async function(){
        var doc = new jsPDF('p','pt', 'letter');
        await crearDocumento(doc);
        doc.save('sample.pdf');
    });
    $("#verCanvas").click(async function(){
        var doc = new jsPDF('p','pt', 'letter');
        await crearDocumento(doc);
        var string = doc.output('datauristring');
        var embed = "<embed width='100%' height='100%' src='" + string + "'/>"
        var x = window.open();
        x.document.open();
        x.document.write(embed);
        x.document.close();
    });

    async function crearDocumento(doc) {
        var canvas=$("#frecuenciaCategorias");
        var canvas2=$("#costoMaterialesCategorias");
        var canvas3=$("#costoFuncionariosEjecutivosCategorias");
        var canvas4=$("#costoTotalCategorias");
        var canvas5=$("#frecuenciaOrdenesPorHoras");
        

        var canvasImg = canvas[0].toDataURL("image/jpeg", 1.0);
        var canvasImg2 = canvas2[0].toDataURL("image/jpeg", 1.0);
        var canvasImg3 = canvas3[0].toDataURL("image/jpeg", 1.0);
        var canvasImg4 = canvas4[0].toDataURL("image/jpeg", 1.0);
        var canvasImg5 = canvas5[0].toDataURL("image/jpeg", 1.0);

    
        doc.setFontSize(10);
        doc.text("Reporte", 20,20);
        doc.text(`Inicio: ${$("#dateInicio").val()}-${$("#timeInicio").val()}`, 20,40);
        doc.text(`Fin: ${$("#dateFin").val()}-${$("#timeFin").val()}`, 20,60);
        doc.text(`Filtro: ${$("#fechaFiltro").val()}`, 20,80);

       doc.addImage(canvasImg, 'JPEG', 20, 100, 450,300);
       doc.addPage();
       doc.addImage(canvasImg2, 'JPEG', 20, 0, 450,300);
       doc.addPage();
       doc.addImage(canvasImg3, 'JPEG', 20, 0, 450,300);
       doc.addPage();
       doc.addImage(canvasImg4, 'JPEG', 20, 0, 450,300);
       doc.addPage();
       doc.addImage(canvasImg5, 'JPEG', 20, 0, 450,300);


       var data;

        await $.get(`./recursos/ordenesDataReporte.php?dateInicio=${$("#dateInicio").val()}&dateFin=${$("#dateFin").val()}&timeInicio=${$("#timeInicio").val()}&timeFin=${$("#timeFin").val()}&fechaFiltro=${$("#fechaFiltro").val()}`, function(mensaje, estado){
            data=JSON.parse(mensaje);
        });

        var contElements=0; 
        doc.addPage();

        data.forEach(element => {
            doc.text(`nombre: ${element.nombre},  categoria: ${element.categoria} fechaCreacion: ${element.fechaCreacion}`, 20,20+(contElements*20));
            contElements++

       });
    }