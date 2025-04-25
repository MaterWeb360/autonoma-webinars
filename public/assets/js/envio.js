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
    cProvincia: "",
    cColegio: "",
    cGrado: "",
    cPerCodColegio: "",
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

  document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.querySelector('form');

    // 1. Manejo de selects con niveles dependientes
    const nivel1Divs = formulario.querySelectorAll('[data-nivel="1"]');
    nivel1Divs.forEach((div) => {
      const select = div.querySelector('select');

      if (select) {
        select.addEventListener('change', (e) => {
          const valorSeleccionado = e.target.value;

          // Tomamos el contenedor de hijos que está justo después de este nivel 1
          const grupoHijos = div.nextElementSibling;
          if (!grupoHijos || !grupoHijos.classList.contains('form__selects')) return;

          // Buscar si hay hijos en este contenedor que dependan de esta selección
          const hijosCorrespondientes = grupoHijos.querySelectorAll(`[data-nivel="2"][data-parent="${valorSeleccionado}"]`);

          // Si no hay hijos para este valor, salimos (no hacemos nada)
          if (hijosCorrespondientes.length === 0) return;

          // Ocultamos todos los hijos en este grupo (no en todo el form)
          grupoHijos.querySelectorAll('[data-nivel="2"]').forEach(n2 => {
            n2.classList.add('oculto');
          });

          // Mostramos solo los hijos correspondientes
          hijosCorrespondientes.forEach(hijo => {
            hijo.classList.remove('oculto');

            const wrapper = hijo.closest('.form__selects');
            if (wrapper) wrapper.classList.remove('oculto');
          });
        });
      }
    });
    
    // 2. Selects que actualizan input oculto
    formulario.querySelectorAll('select[data-name]').forEach(select => {
      select.addEventListener('change', function () {
        const selectedText = this.options[this.selectedIndex].text;
        const dataName = this.getAttribute('data-name');
        const targetDataName = dataName.replace(/^n/, 'c');
  
        // Quitar name a todos los similares
        formulario.querySelectorAll(`input[type="hidden"][data-name="${targetDataName}"]`).forEach(input => {
          input.removeAttribute('name');
        });
  
        const wrapper = this.closest('.form__input-select-wrapper');
        const container = wrapper?.querySelector('[data-container]');
        if (container) {
          if (selectedText !== "") {
            container.innerHTML = `<input type="hidden" data-name="${targetDataName}" name="${targetDataName}" value="${selectedText}">`;
          } else {
            container.innerHTML = '';
          }
        } else {
          const hiddenInput = wrapper?.querySelector(`input[type="hidden"][data-name="${targetDataName}"]`);
          if (hiddenInput) {
            hiddenInput.value = selectedText;
            hiddenInput.setAttribute('name', targetDataName);
          }
        }
      });
    });

    // 4. Selects que cambian entre si data-name
    document.querySelectorAll('select[data-name]').forEach(select => {
      select.addEventListener('change', function () {
        const selectedText = this.options[this.selectedIndex].text.trim();
        const dataName    = this.dataset.name;           // ej "nCarrera" o "nTipDocumento"
        const targetName  = `c${dataName.slice(1)}`;     // ej "cCarrera" o "cTipDocumento"
    
        // Asegurar que sólo éste select tenga el name
        document.querySelectorAll(`select[data-name="${dataName}"]`)
          .forEach(s => { if (s !== this) s.removeAttribute('name') });
        this.setAttribute('name', dataName);
    
        // Crear/actualizar el hidden en su data-container
        const wrapper = this.closest('.form__input-select-wrapper');
        const container = wrapper?.querySelector('[data-container]');
        if (!container) return;
    
        if (selectedText !== "") {
          container.innerHTML = 
            `<input type="hidden" data-name="${targetName}" name="${targetName}" value="${selectedText}">`;
        } else {
          container.innerHTML = '';
        }
      });
    });
  
    // 3. Radios que actualizan input oculto
    formulario.querySelectorAll('input[type="radio"]').forEach(radio => {
      radio.addEventListener('change', function () {
        if (this.checked) {
          const groupName = this.name;
          const targetName = groupName.replace(/^n/, 'c');
  
          formulario.querySelectorAll(`input[type="hidden"][data-name="${targetName}"]`).forEach(input => {
            input.removeAttribute('name');
          });
  
          const label = this.closest('label');
          const hidden = label?.querySelector(`input[type="hidden"][data-name="${targetName}"]`);
          if (hidden) {
            hidden.setAttribute('name', targetName);
          }
        }
      });
    });
  
    // 5
    function manejarCambioSelect(e) {
      const select = e.target;
      const wrapper = select.closest('.form__input-select-wrapper');
      if (!wrapper) return;
  
      const nuevoInput = wrapper.querySelector('input[data-name="cCodFormExterno"]');
      if (!nuevoInput) return;
  
      // Encontrar el input actual con name="cCodFormExterno"
      const actual = formulario.querySelector('input[name="cCodFormExterno"]');
      if (actual) {
          actual.removeAttribute('name');
          actual.setAttribute('data-name', 'cCodFormExterno');
      }
  
      // Asignar name al nuevo input
      nuevoInput.setAttribute('name', 'cCodFormExterno');
      nuevoInput.removeAttribute('data-name');
  }
  
  function iniciarListeners() {
      const selects = formulario.querySelectorAll('select');
      selects.forEach(select => {
          select.addEventListener('change', manejarCambioSelect);
      });
  }
  
  iniciarListeners();
  

  });
  
//Recopilacion y envio de datos
document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.getElementById('formularioAutonoma');
    //Evento de recoleccion de datos del formulario
    formulario.addEventListener('submit', function (e) {
        e.preventDefault();
        let action = formulario.getAttribute('action');
        let form = $(this);
        let submitButton = form.find('button[type="submit"], input[type="submit"]');
        let datosForm = form.serializeObject();
        //--------------------console.log(datosForm);
        let checkboxRequeridosNoMarcados = false;
        //validacion de checkbox requeridos
        form.find('input[type="checkbox"][required]').each(function() {
          if (!this.checked) {
            console.log('No se puede enviar el formulario debido a los checkboxes no marcados');
            return false; // corta el each
          }
        });
        validarDatos(datosForm,form);
        if(validarDatos(datosForm,form)){
            submitButton.attr('disabled', 'disabled');
            submitButton.attr('disabled', 'disabled').text('Enviando datos...');
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
      const inputs = formulario[0].querySelectorAll('input[type="text"], input[type="email"], input[type="number"], select, textarea');
      let err = 0;
    
      inputs.forEach(input => {
        const valor = input.value.trim();
        const tipo = input.type;
    
        // Quitar clases previas de error
        input.classList.remove('error-input');
        input.classList.remove('sucess-input');
    
        // Validación de SELECT
        if (input.tagName === 'SELECT') {
          const wrapper = input.closest('.form__input-select-wrapper');
          const selectedText = input.options[input.selectedIndex].textContent.trim();
    
          // Ignorar selects ocultos
          if (!input.offsetParent) {
            return;
          }
    
          if (wrapper) {
            if (selectedText === '' || selectedText.toLowerCase().includes('tipo') || input.selectedIndex === 0) {
              console.log(`❌ Error en SELECT tipo: ${input.dataset.name}`);
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
//-----------    
       // Función para mostrar mensajes de error debajo del input
        function mostrarError(input, mensaje) {
          const contenedor = input.parentElement;

          // Eliminar mensaje anterior si existe
          const errorExistente = contenedor.querySelector('.error-message');
          if (errorExistente) errorExistente.remove();

          // Crear nuevo mensaje
          const errorMsg = document.createElement('p');
          errorMsg.textContent = mensaje;
          errorMsg.style.color = 'red';
          errorMsg.classList.add('error-message');

          contenedor.appendChild(errorMsg);
          input.classList.add('error-input');
          input.classList.remove('sucess-input');
        }

        // Función para limpiar mensajes de error si está correcto
        function limpiarError(input) {
          const contenedor = input.parentElement;
          const errorExistente = contenedor.querySelector('.error-message');
          if (errorExistente) errorExistente.remove();

          input.classList.add('sucess-input');
          input.classList.remove('error-input');
        }

        // Validación de INPUT tipo TEXT (incluye cDocumento con reglas personalizadas)
        if (tipo === 'text') {
          if (input.name === 'cDocumento') {
            const select = document.querySelector('[data-name="nTipDocumento"]');
            const opcionSeleccionada = select.options[select.selectedIndex].textContent.trim();

            if (valor) {
              if (opcionSeleccionada === 'DNI') {
                if (/^\d{8}$/.test(valor)) {
                  limpiarError(input);
                } else {
                  mostrarError(input, 'El DNI debe contener exactamente 8 dígitos numéricos.');
                  err++;
                }
              } else if (opcionSeleccionada === 'Carnet de extranjería') {
                if (/^[a-zA-Z0-9]{9,}$/.test(valor)) {
                  limpiarError(input);
                } else {
                  mostrarError(input, 'El Carnet de extranjería debe tener al menos 9 caracteres alfanuméricos.');
                  err++;
                }
              } else if (opcionSeleccionada === 'Pasaporte') {
                if (/^[a-zA-Z0-9]{6,}$/.test(valor)) {
                  limpiarError(input);
                } else {
                  mostrarError(input, 'El Pasaporte debe tener al menos 6 caracteres alfanuméricos.');
                  err++;
                }
              }
            } else {
              mostrarError(input, 'Por favor ingresa un número de documento.');
              err++;
            }

            return;
          }

          // Validación texto genérico (solo letras y espacios)
          if (valor) {
            if (!/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(valor)) {
              limpiarError(input);
            } else {
              mostrarError(input, 'Este campo solo permite letras y espacios. No uses números ni caracteres especiales.');
              err++;
            }
          } else {
            mostrarError(input, 'Por favor completa la información.');
            err++;
          }
        }

        // Validación EMAIL
        if (tipo === 'email') {
          if (valor) {
            if (/^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/.test(valor)) {
              limpiarError(input);
            } else {
              mostrarError(input, 'Ingresa un correo electrónico válido. Ejemplo: nombre@dominio.com');
              err++;
            }
          } else {
            mostrarError(input, 'Por favor ingresa tu correo electrónico.');
            err++;
          }
        }

        // Validación NÚMERO (teléfono)
        if (tipo === 'number') {
          if (valor) {
            if (/^9\d{8}$/.test(valor)) {
              limpiarError(input);
            } else {
              mostrarError(input, 'El número debe comenzar con 9 y tener exactamente 9 dígitos.');
              err++;
            }
          } else {
            mostrarError(input, 'Por favor ingresa tu número de teléfono.');
            err++;
          }
        }
//-----

        // Validación de TEXTAREA
        if (input.tagName === 'TEXTAREA') {
          // Ignorar textareas ocultos
          if (!input.offsetParent) {
            return;
          }

          const wrapper = input.parentElement; // El div contenedor del textarea
          const esRequerido = input.dataset.requerido === 'required';
          const valor = input.value.trim();

          // Eliminar mensaje de error previo si existe
          const errorExistente = wrapper.querySelector('.error-message');
          if (errorExistente) errorExistente.remove();

          // Limpia clases previas
          input.classList.remove('error-input', 'sucess-input');

          if (esRequerido && valor === '') {
            console.log(`❌ Error en TEXTAREA requerido: ${input.name}`);

            // Crear el mensaje de error
            const errorMsg = document.createElement('p');
            errorMsg.textContent = 'Este campo es obligatorio. Por favor, completa la información.';
            errorMsg.style.color = 'red';
            errorMsg.classList.add('error-message');

            // Insertar el mensaje justo después del textarea
            input.insertAdjacentElement('afterend', errorMsg);

            input.classList.add('error-input');
            err++;
          } else {
            input.classList.add('sucess-input');
          }

          return;
        }
      });
    
      if (err === 0) {
        return true; // Todo validado correctamente
      } else {
        console.log(`❌ Validación fallida con ${err} error(es)`);
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
            window.location = typ;
          },
          error: function (e) {
            console.log(e, e.response);
          },
        });
      }
  })

  //validacion en tiempo real

  document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    if (!form) return;

    const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="number"], select, textarea');

    inputs.forEach(input => {
      const evento = input.tagName === 'SELECT' ? 'change' : 'input';

      input.addEventListener(evento, () => {
        const valor = input.value.trim();
        const tipo = input.type;

        const mostrarError = (mensaje) => {
          const contenedor = input.parentElement;
          const existente = contenedor.querySelector('.error-message');
          if (existente) existente.remove();

          const p = document.createElement('p');
          p.className = 'error-message';
          p.style.color = 'red';
          p.textContent = mensaje;
          contenedor.appendChild(p);

          input.classList.add('error-input');
          input.classList.remove('sucess-input');
        };

        const limpiarError = () => {
          const contenedor = input.parentElement;
          const existente = contenedor.querySelector('.error-message');
          if (existente) existente.remove();

          input.classList.remove('error-input');
          input.classList.add('sucess-input');
        };

        // Validación SELECT
        if (input.tagName === 'SELECT') {
          const wrapper = input.closest('.form__input-select-wrapper');
          const text = input.options[input.selectedIndex].textContent.trim();
          if (!input.offsetParent) return;

          if (wrapper) {
            if (text === '' || text.toLowerCase().includes('tipo') || input.selectedIndex === 0) {
              wrapper.classList.remove('sucess-input');
              wrapper.classList.add('error-input');
            } else {
              wrapper.classList.remove('error-input');
              wrapper.classList.add('sucess-input');
            }
          }
          return;
        }

        // TEXT
        if (tipo === 'text') {
          if (input.name === 'cDocumento') {
            const select = document.querySelector('[data-name="nTipDocumento"]');
            const opcion = select.options[select.selectedIndex].textContent.trim();

            if (valor) {
              if (opcion === 'DNI' && /^\d{8}$/.test(valor)) limpiarError(input);
              else if (opcion === 'Carnet de extranjería' && /^[a-zA-Z0-9]{9,}$/.test(valor)) limpiarError(input);
              else if (opcion === 'Pasaporte' && /^[a-zA-Z0-9]{6,}$/.test(valor)) limpiarError(input);
              else mostrarError('Número de documento no válido para el tipo seleccionado.');
            } else {
              mostrarError('Por favor ingresa un número de documento.');
            }
            return;
          }

          if (valor && !/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/.test(valor)) {
            limpiarError();
          } else {
            mostrarError(valor ? 'Solo letras y espacios.' : 'Por favor completa la información.');
          }
          return;
        }

        // EMAIL
        if (tipo === 'email') {
          if (valor && /^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/.test(valor)) limpiarError();
          else mostrarError(valor ? 'Correo electrónico no válido.' : 'Por favor ingresa tu correo.');
          return;
        }

        // TELÉFONO
        if (tipo === 'number') {
          if (valor && /^9\d{8}$/.test(valor)) limpiarError();
          else mostrarError(valor ? 'Número inválido. Debe comenzar con 9 y tener 9 dígitos.' : 'Por favor ingresa tu número.');
          return;
        }

        // TEXTAREA
        if (input.tagName === 'TEXTAREA') {
          if (!input.offsetParent) return;

          const requerido = input.dataset.requerido === 'required';
          if (requerido && !valor) {
            mostrarError('Este campo es obligatorio.');
          } else {
            limpiarError();
          }
        }
      });
    });
  });





