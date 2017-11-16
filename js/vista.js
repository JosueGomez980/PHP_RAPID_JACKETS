/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//---------------------FUNCIONES DE DIBUJADO, EFECTOS Y ANIMACIONES
function acordeon(div_id) {
    var ele = document.getElementById(div_id);
    ele.classList.toggle("w3-show");
}
function hide_closebtn(ele) {
    ele.parentElement.style.display = 'none';
}
function show_modal(IdModal) {
    var modal = document.getElementById(IdModal);
    modal.style.display = "block";
}
function close_modal(modal) {
    var modal_cont = modal.parentNode;
    modal = modal_cont.parentNode;
    modal.style.display = 'none';
}
function closeE(id) {
    document.getElementById(id).style.display = "none";
}
function clearInp(ipt) {
    ipt.value = "";
}
function show_sidebar(idBar) {
    var sidebar = document.getElementById(idBar);
    sidebar.style.display = "block";
}
function hide_sidebar(idBar) {
    var sidebar = document.getElementById(idBar);
    sidebar.style.display = "none";
}
//Funcion para mostrar el contenido de una pestaña simulada por la clases css tab
function mostrarOcultarTab(tabName) {
    var tabs, i, tabObject;
    tabObject = document.getElementById(tabName);
    tabs = document.getElementsByClassName("tab");
    for (i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove("w3-show");
        tabs[i].classList.add("w3-hide");
    }
    tabObject.classList.add("w3-show");
}
//Funcion para mostrar ocultar
//-------------------VALIDACIÓN EN TIEMPO REAL DE FORMULARIOS (Simple y no completa) -----------------------
function copy_to_hidden(input, target) {
    var valor = input.value;
    target.value = valor;
}
//VALIDACION GENERICA A MULTIPLES CAMPOS
function valida_simple_input(inputP) {
    var valor = inputP.value;
    var ok = true;
    if (valor === "" || valor === null) {
        inputP.style.boxShadow = "0px 0px 10px red";
        ok = false;
    } else {
        inputP.style.boxShadow = "0px 0px 10px green";
    }
    return ok;
}

function valida_simple_input2(inputP, min, max) {
    var valor = inputP.value;
    var ok = true;
    if (valor.length < min || valor.length > max) {
        inputP.style.boxShadow = "0px 0px 10px red";
        ok = false;
    } else {
        inputP.style.boxShadow = "0px 0px 10px green";
    }
    if (valor === "" || valor === null) {
        inputP.style.boxShadow = "0px 0px 10px red";
        ok = false;
    } else {
        inputP.style.boxShadow = "0px 0px 10px green";
    }
    return ok;
}


//Usuario Controller Registrar
function valida_id_user() {
    var i, cont = 0;
    var ok = true;
    var inputUserID = document.getElementById('user_id');
    var res = document.getElementById("user_id_res");
    var valor = inputUserID.value;
    var array = valor.split("");
    if (valor === "" || valor === null) {
        ok = false;
    }
    if (valor.length < 8) {
        ok = false;
    }
    for (i = 0; i < array.length; i++) {
        if (!isNaN(array[i])) {
            cont++;
        }
    }
    if (cont < 3) {
        ok = false;
    }
    if (ok) {
        inputUserID.style.boxShadow = "0px 0px 10px green";
        res.innerHTML = "";
    } else {
        inputUserID.style.boxShadow = "0px 0px 10px red";
        res.innerHTML = "El nombre de usuario debe tener mínimo 8 caracteres, incluyendo al menos 3 números";
    }
    return ok;
}
function valida_user_email() {
    var inputUserEmail = document.getElementById('user_email');
    var res = document.getElementById("user_email_res");
    var valor = inputUserEmail.value;
    var ok = true;
    if (valor.search("@") === -1) {
        ok = false;
    }
    if (ok) {
        inputUserEmail.style.boxShadow = "0px 0px 10px green";
        res.innerHTML = "";
    } else {
        inputUserEmail.style.boxShadow = "0px 0px 10px red";
        res.innerHTML = "Introduzca una direccion de correo válida";
    }
    return ok;
}
function valida_user_passA() {
    function passSugerir(largo, res) {
        if (largo < 8) {
            res.style.color = "#ff3300";
            res.innerHTML = "Contraseña muy corta";
        }
        if (largo >= 8 && largo <= 15) {
            res.style.color = "#0066ff";
            res.innerHTML = "Contraseña aceptable";
        }
        if (largo >= 16 && largo <= 30) {
            res.style.color = "#00ff00";
            res.innerHTML = "Contraseña segura";
        }
        if (largo > 31) {
            res.style.color = "#006600";
            res.innerHTML = "Contraseña bien segura";
        }
    }
    var i, cont = 0;
    var inputUserPassA = document.getElementById('user_passwordA');
    var res1 = document.getElementById('user_passA_res');
    var res2 = document.getElementById('user_passA_res2');
    var valor = inputUserPassA.value;
    var ok = true;
    var array = valor.split("");
    if (valor === "" || valor === null) {
        ok = false;
    }
    if (valor.length < 8) {
        ok = false;
    }
    for (i = 0; i < array.length; i++) {
        if (!isNaN(array[i])) {
            cont++;
        }
    }
    if (cont < 3) {
        ok = false;
    }
    if (ok) {
        inputUserPassA.style.boxShadow = "0px 0px 10px green";
        res1.innerHTML = "";
    } else {
        inputUserPassA.style.boxShadow = "0px 0px 10px red";
        res1.innerHTML = "La contraseña debe tener mínimo 8 caracteres, incluyendo al menos 3 números";
    }
    passSugerir(valor.length, res2);
    return ok;
}
function avoid_paste() {
    inpu = document.getElementById("user_passwordB");
    var rta = document.getElementById("user_passB_res");
    rta.style.color = "yellow";
    rta.innerHTML = "No puedes pegar contenido en este campo.";
}
function valida_user_passB() {
    var inputUserPassA = document.getElementById('user_passwordA');
    var inputUserPassB = document.getElementById('user_passwordB');
    var res = document.getElementById("user_passB_res");
    var valor = inputUserPassA.value;
    var ok = true;
    if (valor === inputUserPassB.value && (valor !== "" && valor !== null)) {
        inputUserPassB.style.boxShadow = "0px 0px 10px green";
        res.style.color = "green";
        res.innerHTML = "Las contraseñas SI coinciden.";
    } else {
        res.style.color = "red";
        inputUserPassB.style.boxShadow = "0px 0px 10px red";
        res.innerHTML = "Las contraseñas NO coinciden.";
    }
    return ok;
}
function cleanDV(divID) {
    var div = document.getElementById(divID);
    div.innerHTML = "";
}

//CallBack de Ajax
var MES_LOADING = "CARGANDO...";
var MES_WAIT = "ESPERE...";
function show_loading(ready) {
    if (ready != 4) {
        load = document.getElementById("loading");
        load.innerHTML = '<div class="w3-modal" style="display: block"><div class="w3-modal-content"><h1 class="w3-center">CARGANDO..</h1></div></div>';
    }
    if (ready == 4) {
        load.innerHTML = "";
    }
}
//----Funciones relacionadas con el comportamiento de los objetos input y de las tablas crud para los modulos del administrador

//-- Para emular la seleccion de una fila de la tabla crud x
function selectRowFromCrud(idrow) {
    var allRow = $("tr");

    allRow.each(function () {
        $(this).removeClass("w3-blue");
    });
    $(idrow).toggleClass("w3-blue");
}

//Para los tooltip
$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

//----------------------FUNCIONES QUE HACEN USO DE JQUERY UI-------------------------------------
//Configuracion del datepicker
$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: '< Ant',
    nextText: 'Sig >',
    currentText: 'Hoy',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
    weekHeader: 'Sm',
    dateFormat: 'yy-mm-dd',
    showButtonPanel: true,
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};

$.datepicker.setDefaults($.datepicker.regional['es']);
//--------------Fecha simple selector---------

$(function () {
    $("#FECHA_SIMPLE").datepicker({
        changeMonth: true,
        changeYear: true
    });
});

//--------------Para los nuevos inpout radio
$(function () {
    $("input[type='radio']").checkboxradio();
    $("fieldset").controlgroup();
});