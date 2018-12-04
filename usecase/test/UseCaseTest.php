<?php

/*
 * idea general: aplicar criterios de CleanArchitecture
 * 
 * http://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html
 * 
 */

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


class EjemploController  {
    protected $inputPort;
    function setInputPort( InputPortInterface $input ){
        $this->inputPort = $input ;
    }
    function recibir( $datos ){
        $this->inputPort->recibir( $datos );
        
    }
}

abstract class UseCase implements InputPortInterface {
    
}

class EjemploUseCase extends UseCase {
    private $output;
    
    function recibir( $datos ) {
        // $output = $this->output;
        $this->output->salida( $datos );
    }
    
    function setOutputPort( OutputPortInterface  $output ){
        $this->output = $output ;
    }
        
  
}

class EjemploPresenter implements OutputPortInterface {
    function __construct( Callable $funcion ){
        $this->funcion = $funcion;
    }
    
    private $funcion;
    function salida( $datos ){
        $funcion = $this->funcion;
        $funcion( $datos  );
    }
        
}
class UseCaseTest extends PHPUnit\Framework\TestCase {
    
    function testNew(){
        
        $presenter = new EjemploPresenter( function( $datos ) { $this->assertEquals( "A", $datos[0]  ); } );
        $usecase = new EjemploUseCase(  );
        
        $usecase->setOutputPort( $presenter );
        
        $controller = new EjemploController(  );
        $controller->setInputPort( $usecase );
        $controller->recibir( ["A"] );
        
        
        
    }
}
?>