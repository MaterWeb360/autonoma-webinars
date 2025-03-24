window.onload = function () {
    /*
     * CARBON FIELDS TEXTAREA LIMIT
     */
    const textAreas = document.querySelectorAll(".cf-field.cf-textarea");

    textAreas.forEach((bloque) => {
        const palabraBuscada = "limit-";
        const clasesFiltradas = [...bloque.classList].filter((clase) =>
            clase.startsWith(palabraBuscada)
        );

        if (clasesFiltradas.length > 0) {
            const lineasLimite = parseInt(clasesFiltradas[0].split("-")[1]);
            const campo = bloque.querySelector("textarea");

            campo.addEventListener("input", function () {
                const lines = this.value.split("\n").length;

                if (lines > lineasLimite) {
                    this.value = this.value
                        .split("\n")
                        .slice(0, lineasLimite)
                        .join("\n");
                }
            });
        }
    });

    /*
     * VALORACION 0-5
     */
    const miInput = document.querySelectorAll(".carbon-valoracion");

    miInput.forEach((valoracion) => {
        valoracion.addEventListener("input", function () {
            if (valoracion.value < valoracion.min) {
                valoracion.value = valoracion.min;
            } else if (valoracion.value > valoracion.max) {
                valoracion.value = valoracion.max;
            }
        });

        valoracion.addEventListener("keydown", function (event) {
            if (event.key === "ArrowUp" && valoracion.value < valoracion.max) {
                valoracion.value++;
                event.preventDefault();
            } else if (
                event.key === "ArrowDown" &&
                valoracion.value > valoracion.min
            ) {
                valoracion.value--;
                event.preventDefault();
            }
        });

        valoracion.addEventListener("blur", function () {
            if (valoracion.value === "") {
                valoracion.value = valoracion.min;
            }
        });
    });

    /*
     * Instalar Plugins
     */
    const btnSeguridad = document.getElementById('btn-seguridad');
    const divProceso = document.getElementById('plugins-proceso'); 

    if (btnSeguridad && divProceso) {
        btnSeguridad.addEventListener('click', function () {
            const boton = this;

            boton.disabled = true;
            boton.textContent = 'Instalando...'; 
            divProceso.innerHTML = '<p>Procesando solicitud. No cambies de página, espera hasta que termine.</p>';

            fetch(ajaxData.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'instalar_plugins_seguridad',
                    nonce: ajaxData.nonce
                })
            })
                .then(response => response.text()) 
                .then(text => {
                    const jsonStart = text.indexOf('{"success"'); 
                    const jsonEnd = text.lastIndexOf('}');

                    if (jsonStart !== -1 && jsonEnd !== -1) {
                        const jsonString = text.substring(jsonStart, jsonEnd + 1);
                        const data = JSON.parse(jsonString);

                        if (data.success) {
                            console.log(data.data.message);
                            divProceso.innerHTML = '<p>Plugins instalados correctamente. Dirigete hacia los plugins para activarlos</p>';
                        } else {
                            console.error(data.data.message || 'Error desconocido.');
                            divProceso.textContent = `Error: ${data.data.message || 'Error desconocido.'}`;
                        }
                    } else {
                        console.error('No se encontró un JSON válido en la respuesta.');
                        divProceso.innerHTML = '<p>Error en la respuesta del servidor.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error en la petición:', error);
                    divProceso.innerHTML = '<p>Error al procesar la solicitud.</p>';
                });

        });
    }

};
