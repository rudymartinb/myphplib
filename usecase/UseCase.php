<?php
namespace usecase;

interface InputPortInterface {
    function esSituacionValida( $contexto ) : bool ;
    function recibir( $datos );
}

interface OutputPortInterface {
    function generar_salida( $datos );
}


interface ControllerInterface {
    function setInputPort( InputPortInterface $input );
    function recibir_cualquiera( $datos );
}


/*
 * estoy pensando en una clase que se dedique a validar si un caso corresponde o no
 */
interface UseCaseValidador {
    function es_valido() : bool;
    
}

abstract class UseCase implements InputPortInterface {
    abstract function setOutputPort( OutputPortInterface  $output );
    abstract function es_valido( UseCaseValidador $validador ) : bool;
}

    

?>