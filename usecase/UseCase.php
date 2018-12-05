<?php
interface InputPortInterface {
    function recibir( $datos );
}

interface OutputPortInterface {
    function salida( $datos );
}

interface ControllerInterface {
    function setInputPort( InputPortInterface $input );
    function recibir( $datos );
}



abstract class UseCase implements InputPortInterface {
    abstract function setOutputPort( OutputPortInterface  $output );
    
}

?>