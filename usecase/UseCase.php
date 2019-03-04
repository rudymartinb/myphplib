<?php
namespace usecase;

/*
 * quiza estas interfaces deban ser extendidas
 * para implementar funcionalidades especificas
 */

// clases "usecase" deben implementar esto
interface InputPortInterface {
    function recibir( $datos );
}

interface OutputPortInterface {
    function generar_salida( $datos );
}



interface ControllerInterface {
    function setInputPort( InputPortInterface $input );
}


/*
 * estoy pensando en una clase que se dedique a validar si un caso corresponde o no
 * la ventaja es que le podemos pasar lo que querramos al constructor.
 * el unico tema es que para que tenga sentido todo se tiene que hacer en el momento.
 * de cualquier manera, es una interface. La clase que la imeplemente debe resolver el problema.
 *  
 */
interface UseCaseValidador {
    function esValido() : bool;
}

abstract class UseCase implements InputPortInterface {
    // TODO: mover todo esto a un builder?
    abstract function setOutputPort( OutputPortInterface  $output );
    abstract function setValidador( UseCaseValidador $validador ) ;
    
    abstract function esSituacionValida() : bool ;
}

    

?>