<?php
namespace usecase;

/*
 * quiza estas interfaces deban ser extendidas
 * para implementar funcionalidades especificas
 */

interface InputPortInterface {
<<<<<<< HEAD
    function es_valido() : bool ;
=======
    // function esSituacionValida( $contexto ) : bool ;
    function recibir( $datos );
>>>>>>> fae8a869c1b92eecea90b62fb5cd8e28ecc9c726
}

interface OutputPortInterface {
    function generar_salida( $datos );
}


interface ControllerInterface {
    function setInputPort( InputPortInterface $input );
<<<<<<< HEAD
    // function recibir_cualquiera( $datos );
=======
    function recibir_cualquiera( $datos );
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
    
>>>>>>> fae8a869c1b92eecea90b62fb5cd8e28ecc9c726
}

abstract class UseCase implements InputPortInterface {
    // TODO: mover a un builder?
    abstract function setOutputPort( OutputPortInterface  $output );
<<<<<<< HEAD
=======
    abstract function setValidador( UseCaseValidador $validador ) ;
    
    abstract function esSituacionValida() : bool ;
>>>>>>> fae8a869c1b92eecea90b62fb5cd8e28ecc9c726
}

    

?>