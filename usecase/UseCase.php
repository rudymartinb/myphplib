<?php
namespace usecase;

/*
 * quiza estas interfaces deban ser extendidas
 * para implementar funcionalidades especificas
 */

interface InputPortInterface {
    function es_valido() : bool ;
}

interface OutputPortInterface {
    function generar_salida( $datos );
}


interface ControllerInterface {
    function setInputPort( InputPortInterface $input );
    // function recibir_cualquiera( $datos );
}

abstract class UseCase implements InputPortInterface {
    abstract function setOutputPort( OutputPortInterface  $output );
}

    

?>