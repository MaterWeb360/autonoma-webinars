document.addEventListener('DOMContentLoaded', () => {
    const formulario = {
        //agregar objetos anidados con las propiedades campo y valido. 
        // En campo se indica la ubicación del campo
        // valido es un booleano con el que inicia el campo en la validacion
    }

    const comprobarLetras = (input, limite_chars, sinespacio) => {
        const PATTERN = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s'¨\-äöüÄÖÜëïÿËÏÜÖæÆÅøØåÅçÇđĐēĒčČěĚđĐģĢħĦīĪĳĲįĮİłŁŋŊœŒøØšŠžŽțȚțțűŰàèìòùÀÈÌÒÙâêîôûÂÊÎÔÛäëïöüÄËÏÖÜçÇžŽąĄćĆęĘłŁńŃśŚźŹżŻ]*$/;
        const SPACE_PATTERN = /\s+/g;

        const limpiarInput = () => {
            input.value = input.value.split('')
                .filter(char => PATTERN.test(char))
                .join('');

            if (sinespacio) {
                input.value = input.value.replace(SPACE_PATTERN, '');
            }

            if (input.value.length > limite_chars) {
                input.value = input.value.substring(0, limite_chars);
            }
        };

        input.addEventListener('input', limpiarInput);
    };


    const comprobarCelular = (input) => {
        const LIMITE_CHARS = 9;
        const INICIAL_NUMERO = '9';

        input.minLength = LIMITE_CHARS;

        const limpiarNoNumericos = () => {
            input.value = input.value.replace(/\D/g, '');
        };

        const limitarCaracteres = () => {
            if (input.value.length > LIMITE_CHARS) {
                input.value = input.value.substring(0, LIMITE_CHARS);
            }
        };

        const asegurarPrefijo = () => {
            if (!input.value.startsWith(INICIAL_NUMERO)) {
                input.value = INICIAL_NUMERO + input.value.substring(1);
            }
        };

        const validarLongitudExacta = () => {
            if (input.value.length !== LIMITE_CHARS) {
                input.value = '';
            }
        };

        const validarCelular = () => {
            limpiarNoNumericos();
            limitarCaracteres();
            asegurarPrefijo();
        };

        input.addEventListener('input', validarCelular);
        input.addEventListener('blur', validarLongitudExacta);
    };

    const comprobarEmail = (input) => {
        const EMAILPATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        input.addEventListener("blur", () => {
            if (!EMAILPATTERN.test(input.value)) {
                input.value = '';
            }
        });
    };

    const evitarCamposLetrasIguales = (...inputs) => {
        const validarDuplicados = () => {
            const valores = inputs.map(input => input.value.trim().toLowerCase());
            const duplicados = new Set();

            valores.forEach((valor, index) => {
                if (valores.indexOf(valor) !== index && !duplicados.has(valor)) {
                    inputs[index].value = '';
                    duplicados.add(valor);
                }
            });
        };

        inputs.forEach(input => {
            input.addEventListener('blur', validarDuplicados);
        });
    };

    const comprobarDocumento = (input) => {
        const LIMITE_CHARS = 8;
        const REGEX = /\D/g; // Detecta cualquier carácter no numérico

        input.minLength = LIMITE_CHARS;

        const limpiarNoNumericos = () => {
            input.value = input.value.replace(REGEX, '');
        };

        const limitarCaracteres = () => {
            if (input.value.length > LIMITE_CHARS) {
                input.value = '';
            }
        };

        const validarLongitudExacta = () => {
            if (input.value.length !== LIMITE_CHARS) {
                input.value = '';
            }
        };

        const validarDocumento = () => {
            limpiarNoNumericos();
            limitarCaracteres();
        };

        input.addEventListener('input', validarDocumento);
        input.addEventListener('blur', validarLongitudExacta);
    };

    const verificarFormulario = () => {
        let formularioValido = true;
        for (const key in formulario) {
            if (key !== 'submitBtn') {
                formularioValido = formularioValido && formulario[key].valido;
            }
        }
        formulario.submitBtn.valido = formularioValido;
    
        formulario.submitBtn.campo.style.display = formularioValido ? 'block' : 'none';
        document.getElementById('botonHomeInit').style.display = formularioValido ? 'none' : 'block';
    
        // console.log('Estado de los campos:', formulario);
    };
    
    const validarCampo = (campo, condicion) => {
        campo.valido = condicion(campo.campo.value);
        verificarFormulario();
    };
    
    const configurarValidacionCampo = (campo, tipoEvento, condicion) => {
        campo.campo.addEventListener(tipoEvento, () => {
            validarCampo(campo, condicion);
        });
    };
    
    // configurarValidacionCampo(formulario.nombre, 'input', valor => valor.trim().length > 0);
    // configurarValidacionCampo(formulario.email, 'blur', valor => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(valor));
    // configurarValidacionCampo(formulario.politicas, 'change', valor => formulario.politicas.campo.checked);
    

    const submit_stop = (btn_submit) => {
        btn_submit.addEventListener('click', () => {
            btn_submit.style.display = 'none';
            document.getElementById('botonHomeInit').style.display = 'block';
        })
    }

    function updateUTMs() {
        const params = new URLSearchParams(window.location.search);
        const UTM_FIELDS = [
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_term',
            'utm_content',
            'zc_gad',
            'gclid'
        ];

        UTM_FIELDS.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                const urlValue = params.get(field);
                if (urlValue) {
                    input.value = urlValue;
                }
            }
        });
    }

    // EJECUTAR FUNCIONES

    // Inicializar validaciones
    verificarFormulario();
});