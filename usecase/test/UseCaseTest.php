<?php

/*
 * idea general: aplicar criterios de CleanArchitecture
 * 
 * http://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html
 * 
 * no se como va a quedar esto, pero al menos es un principio
 */
use usecase\UseCase;
use usecase\OutputPortInterface;
use usecase\ControllerInterface;
use usecase\InputPortInterface;
use usecase\UseCaseValidador;
class ValidadorEjemplo implements UseCaseValidador {
    public function es_valido(): bool {
        
    }
    
}
class EjemploUseCase extends UseCase {
    private $output;
    
    function recibir( $datos ) {
        $this->output->generar_salida( $datos );
    }
    
    function setOutputPort( OutputPortInterface  $output ){
        $this->output = $output ;
    }
    public function esSituacionValida($contexto): bool {
        return true;
    }
    public function es_valido(UseCaseValidador $validador): bool {
        return $validador->es_valido();
    }

   
}

class EjemploPresenter implements OutputPortInterface {
    function __construct( Callable $funcion ){
        $this->funcion = $funcion;
    }
    
    private $funcion;
    function generar_salida( $datos ){
        $funcion = $this->funcion;
        $funcion( $datos  );
    }
    
}


class EjemploController implements ControllerInterface {
    protected $inputPort;
    function setInputPort( InputPortInterface $input ){
        $this->inputPort = $input ;
    }
    function recibir_cualquiera( $datos ){
        $this->inputPort->recibir( $datos );
        
    }
}


class UseCaseTest extends PHPUnit\Framework\TestCase {
    
    function testNew(){
        $presenter = new EjemploPresenter( function( $datos ) { $this->assertEquals( "A", $datos[0]  ); } );
        $usecase = new EjemploUseCase(  );
        
        $usecase->setOutputPort( $presenter );
        
        $controller = new EjemploController(  );
        $controller->setInputPort( $usecase );
        $controller->recibir_cualquiera( ["A"] ); 
    }
    
    /* lo que me hace ruido de esto es 
     * si corresponde validar el caso desde el usecase
     * o simplemente hacerlo desde el controlador.
     */
    function testEsValido(){
        $usecase = new EjemploUseCase(  );
        
        $this->assertTrue( $usecase->esSituacionValida( null ) );
        
        $this->assertTrue( $usecase->esSituacionValida( null ) );
    }
    
}
?>