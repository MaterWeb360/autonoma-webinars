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
      // Si el campo ya existe, lo convertimos en un array y agregamos el valor
      if (obj[item.name] === undefined) {
        obj[item.name] = item.value || "";
      } else {
        if (!Array.isArray(obj[item.name])) {
          obj[item.name] = [obj[item.name]];
        }
        obj[item.name].push(item.value || "");
      }
    });
  
    // Aseguramos que los checkboxes y radios no seleccionados también se incluyan
    this.find('input[type="checkbox"], input[type="radio"]').each(function () {
      var name = this.name;
      if (obj[name] === undefined) {
        obj[name] = "";  // Si no está en el objeto, lo agregamos con un valor vacío
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
        e.preventDefault();
        let action = formulario.getAttribute('action');
        let form = $(this);
        let submitButton = form.find('button[type="submit"], input[type="submit"]');
        let datosForm = form.serializeObject();
        let checkboxRequeridosNoMarcados = false;
        form.find('input[type="checkbox"][required]').each(function() {
          if (!this.checked) {
            checkboxRequeridosNoMarcados = true;
            console.log("Debe marcar los checkbox requeridos");
          }
        });
        if (checkboxRequeridosNoMarcados) {
          console.log('No se puede enviar el formulario debido a los checkboxes no marcados');
          return;
        }
        validarDatos(datosForm,form);
        if(validarDatos(datosForm,form)){
            submitButton.attr('disabled', 'disabled');
            let datosFinales = {};
            for (let key in camposRequeridos) {
                if (datosForm.hasOwnProperty(key)) {
                    datosFinales[key] = datosForm[key];
                } else {
                    datosFinales[key] = "";
                }
            }
            console.log(datosFinales);
            sendDatos(action,datosFinales)
        }else{
          console.log('no paso la validacion');
          submitButton.removeAttr('disabled');
        }

    })


    //Validacion de datos
    function validarDatos(datos, formulario) {
      const errores = [];
      const inputs = formulario[0].querySelectorAll('input[type="text"], input[type="email"], input[type="number"], select');
        var err = 0;
    
      inputs.forEach(input => {
        const valor = input.value.trim();
        const tipo = input.type;

        //Quitar clases previas de error
        input.classList.remove('error-input');
        input.classList.remove('sucess-input');
        if (input.tagName === 'SELECT') {
          const wrapper = input.closest('.form__input-select-wrapper');
          const selectedText = input.options[input.selectedIndex].textContent.trim();
      
          if (wrapper) {
            if (
              selectedText === '' ||
              selectedText.toLowerCase().includes('tipo') || // ej. "Tipo de documento"
              input.selectedIndex === 0
            ) {
              wrapper.classList.remove('sucess-input');
              wrapper.classList.add('error-input');
              err++;
            } else {
              wrapper.classList.remove('error-input');
              wrapper.classList.add('sucess-input');
            }
          }
      
          return;
        }
        if (tipo === 'text') {
          if (input.name === 'cDocumento') {
            if(valor){
              const select = document.querySelector('[data-name="nTipDocumento"]');
              const opcionSeleccionada = select.options[select.selectedIndex].textContent.trim();
              if (opcionSeleccionada === 'DNI') {
                if (valor.match(/^\d{8}$/)) {
                  input.classList.add('sucess-input');
                } else {
                  input.classList.add('error-input');
                  err++;
                }
              } else if (opcionSeleccionada === 'Carnet de extranjería') {
                if (valor.match(/^[a-zA-Z0-9]{9,}$/)) {
                  input.classList.add('sucess-input');
                } else {
                  input.classList.add('error-input');
                  err++;
                }
              } else if (opcionSeleccionada === 'Pasaporte') {
                if (valor.match(/^[a-zA-Z0-9]{6,}$/)) {
                  input.classList.add('sucess-input');
                } else {
                  input.classList.add('error-input');
                  err++;
                }
              }
            }else{
              input.classList.add('error-input');
              err++;
            }
            return;
          }
          if (valor) {
            if (!valor.match(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/)) {
              input.classList.add('sucess-input');
            } else {
              input.classList.add('error-input');
              err++;
            }
          } else {
            input.classList.add('error-input');
            err++;
          }
        }
        if (tipo === 'email') {
          if (valor) {
            if (valor.match(/^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/)) {
              input.classList.add('sucess-input');
            } else {
              input.classList.add('error-input');
              err++;
            }
          } else {
            input.classList.add('error-input');
            err++;
          }
        }
        if (tipo === 'number') {
          if (valor) {
            if (valor.match(/^9\d{8}$/)) {
              input.classList.add('sucess-input');
            } else {
              input.classList.add('error-input');
              err++;
            }
          } else {
            input.classList.add('error-input');
            err++;
          }
        }
      })
      if (err === 0) {
        return true; // Todo validado correctamente
      } else {
        return false; // Hubo errores
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
            //window.location = typ;
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


