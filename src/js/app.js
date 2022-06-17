let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
  id: "",
  nombre: "",
  fecha: "",
  hora: "",
  servicios: [],
};

document.addEventListener("DOMContentLoaded", function () {
  iniciarApp();
});

function iniciarApp() {
  tabs(); // Cambia la seccion cuando se presiones los tabs
  mostrarSeccion(); // Mostrar seccion Automaticamente
  botonesPaginador(); // Agrega o quita los botones de paginador
  paginaSiguiente();
  paginaAnterior();

  //API
  consultarAPI(); // En el backend de php
  //API

  //Llenar el objeto de cita
  idCliente();
  nombreCliente(); // Agrega el nombre del cliiente al objeto de cita
  seleccionarFecha(); //Agrega la fecha en el objeto cita
  seleccionarHora(); // Agrega la hora de la cita en el objeto

  //Resumen
  mostrarResumen(); // Muestar el resumen de la cita
}

function mostrarSeccion() {
  // Ocultar las seccion que tenga la seccion de mostrar
  const seccionAnterior = document.querySelector(".mostrar");
  if (seccionAnterior) {
    seccionAnterior.classList.remove("mostrar");
  }

  //Selecciona la seccion con el paso....
  const pasoSelector = `#paso-${paso}`;
  const seccion = document.querySelector(pasoSelector);
  seccion.classList.add("mostrar");

  //Eliminar la clase del tab anterior
  const tabAnterior = document.querySelector(`.actual`);
  if (tabAnterior) {
    tabAnterior.classList.remove("actual");
  }

  //Resalta el tab actual
  const tab = document.querySelector(`[data-paso= "${paso}"]`);
  tab.classList.add("actual");
}

function tabs() {
  const botones = document.querySelectorAll(".tabs button");

  botones.forEach((boton) => {
    boton.addEventListener("click", function (e) {
      paso = parseInt(e.target.dataset.paso);
      mostrarSeccion();
      botonesPaginador();
    });
  });
}

function botonesPaginador() {
  const paginaSiguiente = document.querySelector("#siguiente");
  const paginaAnterior = document.querySelector("#anterior");

  if (paso === 1) {
    paginaAnterior.classList.add("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  } else if (paso === 3) {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.add("ocultar");
    mostrarResumen();
  } else {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  }
}

function paginaSiguiente() {
  const paginaSiguiente = document.querySelector("#siguiente");
  paginaSiguiente.addEventListener("click", function () {
    if (paso >= pasoFinal) return;
    paso++;
    botonesPaginador();
    mostrarSeccion(); // Mostrar seccion Automaticamente
  });
}

function paginaAnterior() {
  const paginaAnterior = document.querySelector("#anterior");
  paginaAnterior.addEventListener("click", function () {
    if (paso <= pasoInicial) return;
    paso--;
    botonesPaginador();
    mostrarSeccion(); // Mostrar seccion Automaticamente
  });
}

/*********************  API  *********************/

async function consultarAPI() {
  try {
    const url = "http://127.0.0.1:5000/api/servicios";
    const resultado = await fetch(url);
    const servicios = await resultado.json();
    mostrarServicios(servicios);
  } catch (error) {
    console.log(error);
  }
}

/*********************  API/  *******************/

function mostrarServicios(servicios) {
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;

    const nombreServicio = document.createElement("P");
    nombreServicio.classList.add("nombre-servicio");
    nombreServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.classList.add("precio-servicio");
    precioServicio.textContent = `$${precio}`;

    const servicioDiv = document.createElement("DIV");
    servicioDiv.classList.add("servicio");
    servicioDiv.dataset.idServicio = id;
    servicioDiv.onclick = () => {
      seleccionarServicio(servicio);
    };

    servicioDiv.appendChild(nombreServicio);
    servicioDiv.appendChild(precioServicio);

    document.querySelector("#servicios").appendChild(servicioDiv);
  });
}

function seleccionarServicio(servicio) {
  const { servicios } = cita;
  const { id } = servicio;

  //Identificar el elemento al que se le da click
  const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

  //Comprobar si un servicio ya fue agregado
  if (servicios.some((agregado) => agregado.id === id)) {
    //Eliminar
    cita.servicios = servicios.filter((agregado) => agregado.id !== id);
  } else {
    //Agregarlo
    cita.servicios = [...servicios, servicio];
  }

  divServicio.classList.toggle("seleccionado");
}

function idCliente() {
  const id = document.querySelector("#id").value;
  cita.id = id;
}

function nombreCliente() {
  const nombre = document.querySelector("#nombre").value;
  cita.nombre = nombre;
}

function seleccionarFecha() {
  const inputFecha = document.querySelector("#fecha");

  inputFecha.addEventListener("input", function (e) {
    const dia = new Date(e.target.value).getUTCDay();
    if ([6, 0].includes(dia)) {
      e.target.value = "";
      mostrarAlerta("Fines de semana no permitidos", "error");
    } else {
      cita.fecha = e.target.value;
    }
  });
}

function seleccionarHora() {
  const inputHora = document.querySelector("#hora");
  inputHora.addEventListener("input", function (e) {
    const horaCita = e.target.value;
    const hora = horaCita.split(":")[0];
    if (hora < 10 || hora > 18) {
      e.target.value = "";
      mostrarAlerta("Hora no valida", "error");
    } else {
      cita.hora = e.target.value;
    }
  });
}

function mostrarAlerta(
  mensaje,
  tipo,
  elemento = ".formulario",
  desaparece = true
) {
  const alertaPrevia = document.querySelector(".alerta");
  if (alertaPrevia) {
    alertaPrevia.remove();
  }

  const alerta = document.createElement("DIV");
  alerta.textContent = mensaje;
  alerta.classList.add("alerta");
  alerta.classList.add(tipo);

  const referencia = document.querySelector(elemento);
  referencia.appendChild(alerta);

  if (desaparece) {
    //Eliminar la alerta en un lapso de tiempo
    setTimeout(() => {
      alerta.remove();
    }, 3000);
  }
}

function mostrarResumen() {
  const resumen = document.querySelector(".contenido-resumen");

  //Limpiar el contenido de Resumen
  while (resumen.firstChild) {
    resumen.removeChild(resumen.firstChild);
  }

  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    mostrarAlerta(
      "Hacen Falta Datos o Servicios",
      "error",
      ".contenido-resumen",
      false
    );
    return;
  }

  // Formatear el div de resumen
  const { nombre, fecha, hora, servicios } = cita;

  //Heading para resumen
  const headingServicios = document.createElement("H3");
  headingServicios.textContent = "Resumen de Servicios";
  resumen.appendChild(headingServicios);

  //Iterando los servicios
  servicios.forEach((servicio) => {
    const { id, precio, nombre } = servicio;
    const contenedorServicios = document.createElement("DIV");
    contenedorServicios.classList.add("contenedor-servicio");

    const textoServicio = document.createElement("P");
    textoServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

    contenedorServicios.appendChild(textoServicio);
    contenedorServicios.appendChild(precioServicio);

    resumen.appendChild(contenedorServicios);
  });

  //Heading para cita
  const headingCita = document.createElement("H3");
  headingCita.textContent = "Resumen de Cita";
  resumen.appendChild(headingCita);

  //Nombre, fecha, hora del cliente
  const nombreCliente = document.createElement("P");
  nombreCliente.innerHTML = `<span>Nombre: </span> ${nombre}`;

  //Formatear la fecha
  const fechaObj = new Date(fecha);
  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate() + 2;
  const year = fechaObj.getFullYear();

  const fechaUTC = new Date(Date.UTC(year, mes, dia));

  const fechaFormateda = fechaUTC.toLocaleDateString("es-AR");

  const fechaCita = document.createElement("P");
  fechaCita.innerHTML = `<span>Fecha: </span> ${fechaFormateda}`;

  const horaCita = document.createElement("P");
  horaCita.innerHTML = `<span>Hora: </span> ${hora} Horas`;

  resumen.appendChild(nombreCliente);
  resumen.appendChild(fechaCita);
  resumen.appendChild(horaCita);

  //Boton para crear una cita

  const botonReservar = document.createElement("BUTTON");
  botonReservar.classList.add("boton");
  botonReservar.textContent = "Reservar Cita";
  botonReservar.onclick = reservarCita;

  resumen.appendChild(botonReservar);
}

/*********************  API  *********************/

async function reservarCita() {
  const { id, hora, fecha, servicios } = cita;
  const idServicio = servicios.map((servicio) => servicio.id);

  const datos = new FormData();
  datos.append("fecha", fecha);
  datos.append("hora", hora);
  datos.append("usuarioId", id);
  datos.append("servicios", idServicio);

  try {
    //Peticion hacia la api
    const url = "http://127.0.0.1:5000/api/citas";
    const respuesta = await fetch(url, {
      method: "POST",
      body: datos,
    });

    const resultado = await respuesta.json();
    const Mostrar = resultado.resultado;
    console.log(Mostrar);

    if (Mostrar.resultado === true) {
      Swal.fire({
        icon: "success",
        title: "Cita Creada",
        text: "Tu cita fue creada correctamente",
        button: "OK",
      }).then(() => {
        window.location.reload();
      });
    }
  } catch (error) {
    console.log(error);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Hubo un error al guardar la cita!",
    });
  }
}
/*********************  API  *********************/
