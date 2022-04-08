function Unidades(num) {
  switch (num) {
    case 1:
      return "UN";
    case 2:
      return "DOS";
    case 3:
      return "TRES";
    case 4:
      return "CUATRO";
    case 5:
      return "CINCO";
    case 6:
      return "SEIS";
    case 7:
      return "SIETE";
    case 8:
      return "OCHO";
    case 9:
      return "NUEVE";
  }

  return "";
} //Unidades()

function Decenas(num) {
  decena = Math.floor(num / 10);
  unidad = num - decena * 10;

  switch (decena) {
    case 1:
      switch (unidad) {
        case 0:
          return "DIEZ";
        case 1:
          return "ONCE";
        case 2:
          return "DOCE";
        case 3:
          return "TRECE";
        case 4:
          return "CATORCE";
        case 5:
          return "QUINCE";
        default:
          let uni = "";
          if(unidad == 6){
            uni = "SÉIS";
          }else{
            uni = Unidades(unidad);
          }
          return "DIECI" + uni;
      }
    case 2:
      switch (unidad) {
        case 0:
          return "VEINTE";
        default:
          let uni = "";
          if(unidad == 2){
            uni = "DÓS";
          }else if(unidad == 3){
            uni = "TRÉS";
          }else if(unidad == 6){
            uni = "SÉIS";
          }else{
            uni = Unidades(unidad);
          }
          return "VEINTI" + uni;
      }
    case 3:
      return DecenasY("TREINTA", unidad);
    case 4:
      return DecenasY("CUARENTA", unidad);
    case 5:
      return DecenasY("CINCUENTA", unidad);
    case 6:
      return DecenasY("SESENTA", unidad);
    case 7:
      return DecenasY("SETENTA", unidad);
    case 8:
      return DecenasY("OCHENTA", unidad);
    case 9:
      return DecenasY("NOVENTA", unidad);
    case 0:
      return Unidades(unidad);
  }
} //Unidades()

function DecenasY(strSin, numUnidades) {
  
  let uni = "";

  if (numUnidades == 2) {
    uni = "DÓS";
  } else if (numUnidades == 3) {
    uni = "TRÉS";
  } else if (numUnidades == 6) {
    uni = "SÉIS";
  } else {
    uni = Unidades(numUnidades);
  }

  if (numUnidades > 0) return strSin + " Y " + uni;

  return strSin;
} //DecenasY()

function Centenas(num) {
  centenas = Math.floor(num / 100);
  decenas = num - centenas * 100;

  switch (centenas) {
    case 1:
      if (decenas > 0) return "CIENTO " + Decenas(decenas);
      return "CIEN";
    case 2:
      return "DOSCIENTOS " + Decenas(decenas);
    case 3:
      return "TRESCIENTOS " + Decenas(decenas);
    case 4:
      return "CUATROCIENTOS " + Decenas(decenas);
    case 5:
      return "QUINIENTOS " + Decenas(decenas);
    case 6:
      return "SEISCIENTOS " + Decenas(decenas);
    case 7:
      return "SETECIENTOS " + Decenas(decenas);
    case 8:
      return "OCHOCIENTOS " + Decenas(decenas);
    case 9:
      return "NOVECIENTOS " + Decenas(decenas);
  }

  return Decenas(decenas);
} //Centenas()

function Seccion(num, divisor, strSingular, strPlural) {
  cientos = Math.floor(num / divisor);
  resto = num - cientos * divisor;

  letras = "";

  if (cientos > 0)
    if (cientos > 1) letras = Centenas(cientos) + " " + strPlural;
    else letras = strSingular;

  if (resto > 0) letras += "";

  return letras;
} //Seccion()

function Miles(num) {
  divisor = 1000;
  cientos = Math.floor(num / divisor);
  resto = num - cientos * divisor;

  strMiles = Seccion(num, divisor, "UN MIL", "MIL");
  strCentenas = Centenas(resto);

  if (strMiles == "") return strCentenas;

  return strMiles + " " + strCentenas;
} //Miles()

function Millones(num) {
  divisor = 1000000;
  cientos = Math.floor(num / divisor);
  resto = num - cientos * divisor;

  strMillones = Seccion(num, divisor, "UN MILLON DE", "MILLONES DE");
  strMiles = Miles(resto);

  if (strMillones == "") return strMiles;

  return strMillones + " " + strMiles;
} //Millones()

function NumeroALetras(num) {
  var data = {
    numero: num,
    enteros: Math.floor(num),
    centavos: Math.round(num * 100) - Math.floor(num) * 100,
    letrasCentavos: "",
    letrasMonedaPlural: "", //'PESOS', 'Dólares', 'Bolívares', 'etcs'
    letrasMonedaSingular: "", //'PESO', 'Dólar', 'Bolivar', 'etc'

    letrasMonedaCentavoPlural: "CENTAVOS",
    letrasMonedaCentavoSingular: "CENTAVO",
  };

  if (data.centavos > 0) {
    data.letrasCentavos =
      "CON " +
      (function () {
        if (data.centavos == 1)
          return (
            Millones(data.centavos) + " " + data.letrasMonedaCentavoSingular
          );
        else
          return Millones(data.centavos) + " " + data.letrasMonedaCentavoPlural;
      })();
  }

  if (data.enteros == 0)
    return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos;
  if (data.enteros == 1)
    return (
      Millones(data.enteros) +
      " " +
      data.letrasMonedaSingular +
      " " +
      data.letrasCentavos
    );
  else
    return (
      Millones(data.enteros) +
      " " +
      data.letrasMonedaPlural +
      " " +
      data.letrasCentavos
    );
}


let extraerNumerosFecha = (fecha, tiempo) =>{
    try {
      let fechaHora = "";
      let hora = "";
      let minutos = "";
      let fechaFormateada = "";

      if(tiempo){

        let fechaHoraMinutos = fecha.split(' ');
        fechaHora = fechaHoraMinutos[0].split(':');
        let horaMinutos = fechaHoraMinutos[1].split(':');
        hora = horaMinutos[0];
        minutos = horaMinutos[1];
        fechaFormateada = fechaHora[0].split('-');
      }else{
        fechaFormateada = fecha.split('-');
      }

      let anio = fechaFormateada[0];
      let mes = fechaFormateada[1];
      let dia = fechaFormateada[2]; 

      if(tiempo){
        return {
            dia: dia,
            mes: mes,
            anio: anio,
            hora: hora,
            minutos: minutos
        }
      }else{
        return {
            dia: dia,
            mes: mes,
            anio: anio
        }
      }
    } catch (error) {
      console.log("Error formato de fecha incorrecto");
      return{ 
        dia: "",
        mes: "",
        anio: "",
        hora: "",
        minutos: ""
      }
    }
    
}


let fechaEnPalabras = (fecha, tiempo)=>{

    if(fecha.dia != ""){
      let dia = NumeroALetras(fecha.dia);
      

      if(dia == "UN  "){

        dia = "UNO  ";
        
      }
      dia = dia.slice(0, -2);

      let mes = "";

      if(fecha.mes == 1){
          mes = "enero";
      }else if(fecha.mes == 2){
          mes = "febrero";
      }else if(fecha.mes == 3){
          mes = "marzo";
      }else if(fecha.mes == 4){
          mes = "abril";
      }else if(fecha.mes == 5){
          mes = "mayo";
      }else if(fecha.mes == 6){
          mes = "junio";
      }else if(fecha.mes == 7){
          mes = "julio";
      }else if(fecha.mes == 8){
          mes = "agosto";
      }else if(fecha.mes == 9){
          mes = "septiembre";
      }else if(fecha.mes == 10){
          mes = "octubre";
      }else if(fecha.mes == 11){
          mes = "noviembre";
      }else if(fecha.mes == 12){
          mes = "diciembre";
      }

      let anio = NumeroALetras(fecha.anio);
      anio = anio.slice(0, -2);
      let hora = NumeroALetras(fecha.hora);
      hora = hora.slice(0, -2);
      let minutos = NumeroALetras(fecha.minutos);
      minutos = minutos.slice(0, -2);

      if(tiempo){

        return {
          dia: dia.toLowerCase(),
          mes: mes.toLowerCase(),
          anio: anio.toLowerCase(),
          hora: hora.toLowerCase(),
          minutos: minutos.toLowerCase(),
        };
      } else{

        return {
          dia: dia.toLowerCase(),
          mes: mes.toLowerCase(),
          anio: anio.toLowerCase(),
        };
      }
    }else{
      return {
        dia: "",
        mes: "",
        anio: "",
        hora: "",
        minutos: ""
      }
    }

}

console.log(
  fechaEnPalabras(extraerNumerosFecha("2022-03-01 12:35", true), true)
);

$(".selectorArea").select2();
$(".selectorSindicatura").select2();


 $("#fechaElaboracion").datetimepicker({
   format: "YYYY-MM-DD HH:mm",
   icons: {
     time: "far fa-clock",
   },
 });

  $("#fechaFinElaboracion").datetimepicker({
    format: "YYYY-MM-DD HH:mm",
    icons: {
      time: "far fa-clock",
    },
  });

$("#fechaElaboracionOficio").datetimepicker({
  format: "YYYY-MM-DD",
  icons: {
    time: "far fa-clock",
  },
});

$("#fechaNotificacionOficio").datetimepicker({
  format: "YYYY-MM-DD",
  icons: {
    time: "far fa-clock",
  },
});

$("#fechaInicioLevantamiento").datetimepicker({
  format: "YYYY-MM-DD HH:mm",
  icons: {
    time: "far fa-clock",
  },
});

$("#fechaFinLevantamiento").datetimepicker({
  format: "YYYY-MM-DD HH:mm",
  icons: {
    time: "far fa-clock",
  },
});

let validarDatos = () => {
  let validacion = true;

  if ($(".fechaElaboracion").val() == "") {
    validacion = false;
    $(".fechaElaboracion").addClass("is-invalid");
  } else {
    $(".fechaElaboracion").removeClass("is-invalid");
  }

  if ($(".fechaElaboracionOficio").val() == "") {
    validacion = false;
    $(".fechaElaboracionOficio").addClass("is-invalid");
  } else {
    $(".fechaElaboracionOficio").removeClass("is-invalid");
  }

  if ($(".fechaNotificacionOficio").val() == "") {
    validacion = false;
    $(".fechaNotificacionOficio").addClass("is-invalid");
  } else {
    $(".fechaNotificacionOficio").removeClass("is-invalid");
  }

  if ($(".fechaInicioLevantamiento").val() == "") {
    validacion = false;
    $(".fechaInicioLevantamiento").addClass("is-invalid");
  } else {
    $(".fechaInicioLevantamiento").removeClass("is-invalid");
  }

  if ($(".fechaFinLevantamiento").val() == "") {
    validacion = false;
    $(".fechaFinLevantamiento").addClass("is-invalid");
  } else {
    $(".fechaFinLevantamiento").removeClass("is-invalid");
  }

  if ($(".selectorArea").val() == "") {
    validacion = false;
    $("#area > span > span.selection > span").addClass("has-error");
  } else {
    $("#area > span > span.selection > span").removeClass("has-error");
  }

  if ($(".selectorSindicatura").val() == "") {
    validacion = false;
    $("#sindicatura > span > span.selection > span").addClass("has-error");
  }else{
    $("#sindicatura > span > span.selection > span").removeClass("has-error");
  }


  if($(".folio").val() == ""){
    validacion = false;
    $(".folio").addClass("is-invalid");
  }else{
    $(".folio").removeClass("is-invalid");
  }
}

$(".formulario").on("change", () => {
  validarDatos();
});


$("#generarActa")
  .click(function () {

    //if (!validarDatos()) {
      //alert("Faltan datos por llenar");

      //return;
    //}
    
    let area = $(".selectorArea option:selected").html();
    area = area.split('-')[1];
    area = area.slice(0, -1);

    let sindicaturaId = $(".selectorSindicatura").val();
    let fechaElaboracion = $(".fechaElaboracion").val();
    let fechaFinElaboracion = $(".fechaFinElaboracion").val();
    let folio = $(".folio").val();
    let fechaElaboracionOficio = $(".fechaElaboracionOficio").val();
    let fechaNotificacionOficio = $(".fechaNotificacionOficio").val();
    let fechaInicioLevantamiento = $(".fechaInicioLevantamiento").val();
    let fechaFinLevantamiento = $(".fechaFinLevantamiento").val();
    
    

    let fcFechaElaboracionOficio = fechaEnPalabras(
      extraerNumerosFecha(fechaElaboracionOficio, false),
      false
    );
    fcFechaElaboracionOficio = JSON.stringify(fcFechaElaboracionOficio);
    let fdFechaElaboracionOficio = fechaElaboracionOficio;

    let fcFechaNotificacionOficio = fechaEnPalabras(
      extraerNumerosFecha(fechaNotificacionOficio, false),
      false
    );
    fcFechaNotificacionOficio = JSON.stringify(fcFechaNotificacionOficio);

    let fdFechaNotificacionOficio = fechaNotificacionOficio;

    let fcFechaInicioLevantamiento = fechaEnPalabras(
      extraerNumerosFecha(fechaInicioLevantamiento, true),
      true
    );
    fcFechaInicioLevantamiento = JSON.stringify(fcFechaInicioLevantamiento);

    let fdFechaInicioLevantamiento = fechaInicioLevantamiento;

    let fcFechaFinLevantamiento = fechaEnPalabras(
      extraerNumerosFecha(fechaFinLevantamiento, true),
      true
    );
    fcFechaFinLevantamiento = JSON.stringify(fcFechaFinLevantamiento);

    let fdFechaFinLevantamiento = fechaFinLevantamiento;

    let areaFolio = "";

    if(area.toString().length == 1){
      areaFolio = "0"+area;
    }else{
      areaFolio = area;
    }

    let folioActa = "LFBM/CIM/1RO/" + areaFolio + "/" + fechaElaboracion.substring(0, 4);
    let areaId = $(".selectorArea").val();

    let fcFechaElaboracion = fechaEnPalabras(
      extraerNumerosFecha(fechaElaboracion, true),
      true
    );
    
    fcFechaElaboracion = JSON.stringify(fcFechaElaboracion);
    let fdFechaElaboracion = fechaElaboracion;


    let fcFechaFinElaboracion = fechaEnPalabras(
      extraerNumerosFecha(fechaFinElaboracion, true),
      true
    );

    fcFechaFinElaboracion = JSON.stringify(fcFechaFinElaboracion);
    let fdFechaFinElaboracion = fechaFinElaboracion;

    let bmpActivoFijo = $("#BMPActivoFijo").val();
    let bmpBajoCosto = $("#BMPBajoCosto").val();
    let bmfActivoFijo = $("#BMFActivoFijo").val();
    let bmfBajoCosto = $("#BMFBajoCosto").val();


    var datos = new FormData();
    datos.append("FCOFICIO", folio);
    datos.append("FCFECHANOTIFICACION", fcFechaNotificacionOficio);
    datos.append("FDFECHANOTIFICACION", fdFechaNotificacionOficio);
    datos.append("FCFECHAOFICIO", fcFechaElaboracionOficio);
    datos.append("FDFECHAOFICIO", fdFechaElaboracionOficio);
    datos.append("FCFECHAINICIOLEVANTAMIENTO", fcFechaInicioLevantamiento);
    datos.append("FDFECHAINICIOLEVANTAMIENTO", fdFechaInicioLevantamiento);
    datos.append("FCFECHAFINLEVANTAMIENTO", fcFechaFinLevantamiento);
    datos.append("FDFECHAFINLEVANTAMIENTO", fdFechaFinLevantamiento);
    datos.append("FCFOLIOACTA", folioActa);
    datos.append("FIAREAIDACTA", areaId);
    datos.append("FCFECHAELABORACIONACTA", fcFechaElaboracion);
    datos.append("FDFECHAELABORACIONACTA", fdFechaElaboracion);
    datos.append("FCFECHAFINELABORACIONACTA", fcFechaFinElaboracion);
    datos.append("FDFECHAFINELABORACIONACTA", fdFechaFinElaboracion);
    datos.append("FIBMPACTIVOFIJO", bmpActivoFijo);
    datos.append("FIBMPBAJOCOSTO", bmpBajoCosto);
    datos.append("FIBMFACTIVOFIJO", bmfActivoFijo);
    datos.append("FIBMFBAJOCOSTO", bmfBajoCosto);
    
    $.ajax({
      url: "ajax/generar-acta.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
       if(respuesta){
         $("#descargarWord").attr(
           "href",
           "views/modules/descargar-word.php?actaId=" +
             respuesta +
             "&sindicaturaId=" +
             sindicaturaId
         );
         
         window.open("views/modules/descargar-word.php?idActa="+respuesta+"&sindicaturaId=" +
             sindicaturaId);
         //$("#descargarWord").click();
         /*Swal.fire({
           icon: "success",
           title: "¡El acta ha sido guardada correctamente!",
           showConfirmButton: true,
           confirmButtonText: "Cerrar",
         }).then(function (result) {
           if (result.value) {
             window.location = "inicio";
           }
         });*/
       }else{
         Swal.fire({
           icon: "error",
           title: "¡El acta no pudo ser guardada correctamente!",
           showConfirmButton: true,
           confirmButtonText: "Cerrar",
         }).then(function (result) {
           if (result.value) {
             window.location = "inicio";
           }
         });
       }
      },
    });
  });
