//Funcion para obtener los utms
function getGET() {
    var loc = document.location.href;
    var getString = loc.split("?")[1];
    if (!getString) return {};
  
    var GET = getString.split("&");
  
    let utms = {
      cUtmSource: "",
      cUtmMedium: "",
      cUtmCampaign: "",
      cGclid: "",
    };
  
    for (var i = 0, l = GET.length; i < l; i++) {
      let utmstring = GET[i];
  
      if (utmstring.includes("utm_source")) {
        var arr = utmstring.split("=");
        utms.cUtmSource = arr.length > 1 ? decodeURIComponent(arr[1]) : "";
      }
  
      if (utmstring.includes("utm_medium")) {
        var arr = utmstring.split("=");
        utms.cUtmMedium = arr.length > 1 ? decodeURIComponent(arr[1]) : "";
      }
  
      if (utmstring.includes("utm_campaign")) {
        var arr = utmstring.split("=");
        utms.cUtmCampaign = arr.length > 1 ? decodeURIComponent(arr[1]) : "";
      }
  
      if (utmstring.includes("gclid")) {
        var arr = utmstring.split("=");
        utms.cGclid = arr.length > 1 ? decodeURIComponent(arr[1]) : "";
      }
    }
  
    return utms;
  }
  
  $.fn.serializeObject = function () {
    var obj = {};
    var arr = this.serializeArray();
  
    arr.forEach(function (item) {
      if (obj[item.name] === undefined) {
        obj[item.name] = item.value || "";
      } else {
        if (!Array.isArray(obj[item.name])) {
          obj[item.name] = [obj[item.name]];
        }
        obj[item.name].push(item.value || "");
      }
    });
  
    // Captura UTM desde la URL y los agrega con los nombres correctos
    var utms = getGET();
  
    obj.cUtmSource = utms.cUtmSource || "";
    obj.cUtmMedium = utms.cUtmMedium || "";
    obj.cUtmCampaign = utms.cUtmCampaign || "";
    obj.cGclid = utms.cGclid || "";
  
    return obj;
  }
  
var camposRequeridos = {
    cKeyAccess: "",
    cCodFormExterno: "",
    cNombres: "",
    cApellidos: "",
    cCelular: "",
    cCorreo: "",
    nTipDocumento: "",
    cDocumento: "",
    nPrograma: "",
    cPrograma: "",
    nSubPrograma: "",
    cSubPrograma: "",
    nModalidad: "",
    cModalidad: "",
    nCarrera: "",
    cCarrera: "",
    cDistrito: "",
    cDepartamento: "",
    cPais: "",
    cColegio: "",
    cGrado: "",
    nHorario: "",
    cHorario: "",
    cGenero: "",
    cNacionalidad: "",
    cNombrePadreApo: "",
    cCelPadreApo: "",
    cCorreoPadreApo: "",
    cAnioEgreso: "",
    cTurno: "",
    cOcupacion: "",
    cEmpresa: "",
    cCargo: "",
    cUtmSource: "",
    cUtmMedium: "",
    cUtmCampaign: "",
    cGclid: "",
    cAux1: "",
    cAux2: "",
    cAux3: "",
    cAux4: "",
    cAux5: "",
    cAux6: "",
    cAux7: "",
    cAux8: "",
    cAux9: "",
    cAux10: "",
    cAux11: "",
    cAux12: "",
    cAux13: "",
    cAux14: "",
    cAux15: ""
  };

//Recopilacion y envio de datos
document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.getElementById('formularioAutonoma');
    
    // 
    formulario.querySelectorAll('select[data-name]').forEach(select => {
        select.addEventListener('change', function () {
            const selectedText = this.options[this.selectedIndex].text;
            const selectDataName = this.getAttribute('data-name'); // ej: nCarrera
            const targetDataName = selectDataName.replace(/^n/, 'c'); // ej: cCarrera

            // Buscar el input oculto dentro del mismo wrapper (div padre)
            const wrapper = this.closest('.form__input-select-wrapper');
            const hiddenInput = wrapper.querySelector(`input[type="hidden"][data-name="${targetDataName}"]`);


            if (hiddenInput) {
                // Quitar el name a todos los demás inputs similares en el formulario
                formulario.querySelectorAll(`input[type="hidden"][data-name="${targetDataName}"]`).forEach(input => {
                    input.removeAttribute('name');
                });

                // Asignar valor actualizado y name al input actual
                hiddenInput.value = selectedText;
                hiddenInput.setAttribute('name', hiddenInput.dataset.name);
            }
        })
    })

    // 
    const radios = formulario.querySelectorAll('input[type="radio"]');
    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.checked) {
                const groupName = this.name;

                // Elimina name de todos los inputs ocultos de este grupo
                const hiddenInputs = formulario.querySelectorAll(`input[type="hidden"][data-name][name="${groupName.replace('n', 'c')}"]`);
                hiddenInputs.forEach(input => {
                    input.removeAttribute('name');
                });

                // Agrega name al input oculto correspondiente
                const label = this.closest('label');
                const hidden = label.querySelector('input[type="hidden"][data-name]');
                if (hidden) {
                    hidden.setAttribute('name', hidden.dataset.name);
                }
            }
        })
    })

    //Evento de recoleccion de datos del formulario
    formulario.addEventListener('submit', function (e) {
        e.preventDefault(); // Evita la recarga de la página
        let action = formulario.getAttribute('action');
        let form = $(this);
        let datosForm = form.serializeObject();
        let datosFinales = {};
        for (let key in camposRequeridos) {
            if (datosForm.hasOwnProperty(key)) {
                datosFinales[key] = datosForm[key];
            } else {
                datosFinales[key] = ""; // o podrías usar null si prefieren así
            }
        }
        validarDatos(datosFinales);
        //sendDatos(action,datosFinales);
    })

    //Validacion de datos
    function validarDatos(datos) {
      var camposValidar = {
        cKeyAccess:        { valor: "", tipo: "texto" },
        cCodFormExterno:   { valor: "", tipo: "texto" },
        cNombres:          { valor: "", tipo: "letras" },
        cApellidos:        { valor: "", tipo: "letras" },
        cCelular:          { valor: "", tipo: "telefono" },
        cCorreo:           { valor: "", tipo: "email" },
        nTipDocumento:     { valor: "", tipo: "numero" },
        cDocumento:        { valor: "", tipo: "dni" },
        nPrograma:         { valor: "", tipo: "numero" },
        cPrograma:         { valor: "", tipo: "letras" },
        nSubPrograma:      { valor: "", tipo: "numero" },
        cSubPrograma:      { valor: "", tipo: "letras" },
        nModalidad:        { valor: "", tipo: "numero" },
        cModalidad:        { valor: "", tipo: "letras" },
        nCarrera:          { valor: "", tipo: "numero" },
        cCarrera:          { valor: "", tipo: "letras" },
        cDistrito:         { valor: "", tipo: "letras" },
        cDepartamento:     { valor: "", tipo: "letras" },
        cPais:             { valor: "", tipo: "letras" },
        cColegio:          { valor: "", tipo: "letras" },
        cGrado:            { valor: "", tipo: "letras" },
        nHorario:          { valor: "", tipo: "numero" },
        cHorario:          { valor: "", tipo: "letras" },
        cGenero:           { valor: "", tipo: "letras" },
        cNacionalidad:     { valor: "", tipo: "letras" },
        cNombrePadreApo:   { valor: "", tipo: "letras" },
        cCelPadreApo:      { valor: "", tipo: "telefono" },
        cCorreoPadreApo:   { valor: "", tipo: "email" },
        cAnioEgreso:       { valor: "", tipo: "numero" },
        cTurno:            { valor: "", tipo: "letras" },
        cOcupacion:        { valor: "", tipo: "texto" },
        cEmpresa:          { valor: "", tipo: "texto" },
        cCargo:            { valor: "", tipo: "texto" },
        cUtmSource:        { valor: "", tipo: "tracking" },
        cUtmMedium:        { valor: "", tipo: "tracking" },
        cUtmCampaign:      { valor: "", tipo: "tracking" },
        cGclid:            { valor: "", tipo: "tracking" },
        cAux1:             { valor: "", tipo: "texto" },
        cAux2:             { valor: "", tipo: "texto" },
        cAux3:             { valor: "", tipo: "texto" },
        cAux4:             { valor: "", tipo: "texto" },
        cAux5:             { valor: "", tipo: "texto" },
        cAux6:             { valor: "", tipo: "texto" },
        cAux7:             { valor: "", tipo: "texto" },
        cAux8:             { valor: "", tipo: "texto" },
        cAux9:             { valor: "", tipo: "texto" },
        cAux10:            { valor: "", tipo: "texto" },
        cAux11:            { valor: "", tipo: "texto" },
        cAux12:            { valor: "", tipo: "texto" },
        cAux13:            { valor: "", tipo: "texto" },
        cAux14:            { valor: "", tipo: "texto" },
        cAux15:            { valor: "", tipo: "texto" }
      };
      for (const campo in camposValidar) {
        const valor = datos[campo];
        console.log(datos[campo]);
      }




    }

    //Funcion para envio de datos
    function sendDatos(action,datosForm) {
        var typ ="http://localhost/autonoma-webinars/gracias/";
        jQuery.ajax({
          type: "POST",
          url: action,
          data: JSON.stringify(datosForm),
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          async: false,
          beforeSend: function () {
            jQuery(".error").empty();
          },
          success: function (data) {
            console.log(data);
            window.location = typ;
          },
          error: function (e) {
            console.log(e, e.response);
          },
        });
      }
  })

//
const camposEspeciales = ['nCarrera', 'nModalidad', 'nSubPrograma', 'nPrograma'];
camposEspeciales.forEach(campo => {
    $('[data-name]').on('change', function () {
        const $this = $(this);
        const dataName = $this.attr('data-name');
        
        // Asegúrate de que sea un select (por si tienes radios u otros elementos con data-name)
        if (!$this.is('select')) return;
    
        const selectedText = $this.find('option:selected').text();
    
        // Limpiar otros selects con el mismo data-name
        $(`[data-name="${dataName}"]`).not(this).removeAttr('name');
    
        // Activar este select
        $this.attr('name', dataName);
    
        // Buscar contenedor local para el input
        const wrapper = $this.closest('.form__input-select-wrapper');
        const container = wrapper.find('[data-container]');
    
        if (selectedText !== "") {
            const input = `<input type="hidden" data-name="c${dataName.slice(1)}" name="c${dataName.slice(1)}" value="${selectedText}">`;
            container.html(input);
        } else {
            container.empty();
        }
    });
    
})


