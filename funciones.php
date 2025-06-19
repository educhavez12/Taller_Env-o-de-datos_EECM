
<?php

function limpiar($dato){
    $dato = trim($dato);//eliminar espacion en blanco al inicio y final
    $dato = stripslashes($dato);//devuele el dato con las barras investidad
    $dato = htmlspecialchars($dato);//convierte los caracteres especiales en entidades html
    return $dato;
}