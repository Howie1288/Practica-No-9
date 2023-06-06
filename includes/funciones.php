<?php
/* ALGORTIMO PARA VALIDAR NIT 
esta función valida la estructura y el dígito verificador de un número de NIT,
 y retorna true si es válido o false si es inválido. */
function validarNIT($nit)
{
    $nit = $_GET['nit'];
    $tamanio = strlen($nit);
    $validador = $nit[$tamanio - 1];
    $validador = strtolower($validador) == 'k' ? 10 : $validador;
    $posicion = 2;
    $suma = 0;
    for ($i = $tamanio -  2; $i >= 0; $i--) {

        $suma += $nit[$i] * $posicion;
        $posicion++;
    }
    $residuo = $suma % 11;
    $resta = 11 - $residuo;
    $residuo2 = $resta % 11;
    return $residuo2 == $validador;
}
