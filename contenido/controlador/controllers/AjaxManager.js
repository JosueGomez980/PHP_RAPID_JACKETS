/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function AjaxManager() {
    var url;
    var ok = false;
    var peticion;
    var respuesta;
    var async = true;
    var ajax = new XMLHttpRequest();
    if (window.XMLHttpRequest) {
        ajax = new XMLHttpRequest();
    } else {
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }
//    ajax.onreadystatechange = function () {
//        if (ajax.status == 200 && ajax.readyState == 4) {
//            respuesta = ajax.responseText;
//        }
//    };

    this.responder = function (elemento) {
        ajax.onreadystatechange = function () {
            if (ajax.status == 200 && ajax.readyState == 4) {
                elemento.innerHTML = ajax.responseText;
                respuesta = ajax.responseText;
            }
        }
    }

    this.getRespuesta = function () {
        return respuesta;
    };
    this.setRespuesta = function (nuevaRes) {
        respuesta = nuevaRes;
    };
    this.getUrl = function () {
        return url;
    };
    this.setUrl = function (nuevaUrl) {
        url = nuevaUrl;
    };
    this.getPeticion = function () {
        return peticion;
    };
    this.setPeticion = function (peticionNueva) {
        peticion = peticionNueva;
    };
    this.abrirPost = function () {
        ajax.open("POST", url, async);
    };
    this.abrirGet = function () {
        ajax.open("GET", url, async);
    };
    this.executePost = function () {
        this.abrirPost();
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send(peticion);
    };
    this.executeGet = function () {
        this.abrirGet();
        ajax.send();
    };
    this.getAjax = function () {
        return ajax;
    };
}
//---------------------FUNCIONES Y CLASES DE COMUNICACION POR AJAX CON PHP---------------------





