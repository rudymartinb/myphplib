<?php
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



abstract class UseCase implements InputPortInterface {
    abstract function setOutputPort( OutputPortInterface  $output );

}

?>