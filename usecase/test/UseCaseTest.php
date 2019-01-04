<?php

/*
 * idea general: aplicar criterios de CleanArchitecture
 * 
 * ver grafico en 
 * 
 * http://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html
 * 
 */

use usecase\UseCase;
use usecase\OutputPortInterface;
use usecase\ControllerInterface;
use usecase\InputPortInterface;
use usecase\UseCaseValidador;

// capa 2
class ValidadorEjemplo implements UseCaseValidador {
    public function es_valido(): bool {
        
    }
    
}
// capa 2 
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
// capa 3
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

// capa 3
class EjemploController implements ControllerInterface {
    protected $inputPort;
    function setInputPort( InputPortInterface $input ){
        $this->inputPort = $input ;
    }
    function recibir_cualquiera( $datos ){
        $this->inputPort->recibir( $datos );
        
    }
}
// capa 3
interface renderizador {
    function generar_salida( );
    
}
// capa 4
class EjemploRenderizador implements renderizador {
    function generar_salida( ){
        
    }
}


class UseCaseTest extends PHPUnit\Framework\TestCase {
    
    function testNew(){
<<<<<<< HEAD
=======
        /*
         * para el ejemplo y validar que vamos
         * desde inputport -> usecase -> outputport
         * 
         * es logico q quiera enganchar algo en la salida para evaluar 
         * que se ejecuta todo
         * 
         * pero para el codigo productivo no tiene logica.
         * el presenter tiene que usar un servicio que genere algo
         * 
         * el presenter es una clase 
         * que implementa la interface provista por el caso de uso
         * y como tal debe hacer uso de un servicio externo 
         * que renderize la presentacion que nos interesa
         * 
         */
        
        
        $presenter = new EjemploPresenter( 
            function( $datos ) { 
                $this->assertEquals( "A", $datos[0]  ); 
            } );
        
        
>>>>>>> db02104a7e3c336ca31f1160f10d97d7c7ab55c9
        $usecase = new EjemploUseCase(  );
        
        $presenter = new EjemploPresenter( function( $datos ) { $this->assertEquals( "A", $datos[0]  ); } );
        
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
        
    }
    
}
?>