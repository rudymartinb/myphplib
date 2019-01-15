<?php
namespace usecase;

interface InputPortInterface {
    // function esSituacionValida( $contexto ) : bool ;
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
    function esValido() : bool;
    
}

abstract class UseCase implements InputPortInterface {
    // TODO: mover a un builder?
    abstract function setOutputPort( OutputPortInterface  $output );
    abstract function setValidador( UseCaseValidador $validador ) ;
    
    abstract function esSituacionValida() : bool ;
}

    

?>