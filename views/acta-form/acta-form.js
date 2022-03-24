function Unidades(num) {
  switch (num) {
    case 1:
      return "UNO";
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
          return "DIECI" + Unidades(unidad);
      }
    case 2:
      switch (unidad) {
        case 0:
          return "VEINTE";
        default:
          return "VEINTI" + Unidades(unidad);
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
  if (numUnidades > 0) return strSin + " Y " + Unidades(numUnidades);

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


let extraerNumerosFechaHoraMinutos = (fecha) =>{

    let fechaHoraMinutos = fecha.split(' ');
    let fechaHora = fechaHoraMinutos[0].split(':');
    let horaMinutos = fechaHoraMinutos[1].split(':');
    let hora = horaMinutos[0];
    let minutos = horaMinutos[1];

    let fechaFormateada = fechaHora[0].split('-');

    let dia = fechaFormateada[0];
    let mes = fechaFormateada[1];
    let anio = fechaFormateada[2]; 

    return {
        dia: dia,
        mes: mes,
        anio: anio,
        hora: hora,
        minutos: minutos
    }
}

let extraerNumerosFecha = (fecha) => {

  let fechaFormateada = fecha.split("-");

  let dia = fechaFormateada[0];
  let mes = fechaFormateada[1];
  let anio = fechaFormateada[2];

  return {
    dia: dia,
    mes: mes,
    anio: anio
  };
};


let fechaHoraMinutosEnPalabras = (fecha)=>{

    let dia = NumeroALetras(fecha.dia);

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
    let hora = NumeroALetras(fecha.hora);
    let minutos = NumeroALetras(fecha.minutos);

    return {
      dia: dia.toLowerCase(),
      mes: mes.toLowerCase(),
      anio: anio.toLowerCase(),
      hora: hora.toLowerCase(),
      minutos: minutos.toLowerCase(),
    };

}


console.log(fechaHoraMinutosEnPalabras(extraerNumerosFechaHoraMinutos('01-03-2022 00:00:00')));

$(".selectorArea").select2();

 $("#fechaElaboracion").datetimepicker({
   format: "DD-MM-YYYY HH:mm",
   icons: {
     time: "far fa-clock",
   },
 });

  $("#fechaElaboracionOficio").datetimepicker({
    format: "DD-MM-YYYY",
    icons: {
      time: "far fa-clock",
    },
  });

    $("#fechaNotificacionOficio").datetimepicker({
      format: "DD-MM-YYYY",
      icons: {
        time: "far fa-clock",
      },
    });

    $("#fechaLevantamiento").datetimepicker({
      format: "DD-MM-YYYY HH:mm",
      icons: {
        time: "far fa-clock",
      },
    });
