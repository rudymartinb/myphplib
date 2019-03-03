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


// // capa 2
// class ValidadorEjemplo implements UseCaseValidador {
//     public function es_valido(): bool {
        
//     }
    
// }
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
    public function es_valido(): bool {
        // return $this->validador->es_valido();
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
interface EjemploInputPortInterface extends InputPortInterface {
    function recibir( $datos );
}
// capa 3
class EjemploController implements ControllerInterface {
    private $datos ;
    function __construct( $datos ) {
        $this->datos = $datos;
        
    }
    
    protected $inputPort ;
    function setInputPort( InputPortInterface $input ){
        $this->inputPort = $input ;
        $this->inputPort->recibir( $this->datos );
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
        
        /*
         * quiero que esta funcion anonima se ejecute 
         * cuando se genera la salida
         */
        $presenter = new EjemploPresenter( 
            function( $datos ) { 
                $this->assertEquals( "A", $datos[0]  ); 
            } );
        
        
        $usecase = new EjemploUseCase(  );
        
        $usecase->setOutputPort( $presenter );
        
        $controller = new EjemploController( ["A"]  );
        $controller->setInputPort( $usecase );
        // $controller->recibir_cualquiera(  ); 
    }
    
    /* lo que me hace ruido de esto es 
     * si corresponde validar el caso desde el usecase
     * o simplemente hacerlo desde el controlador.
     * 
     * 
     */
    function testEsValido(){
        $usecase = new EjemploUseCase(  );
        
        $this->assertTrue( $usecase->esSituacionValida( null ) );
        
        // $this->assertTrue( $usecase->esSituacionValida( null ) );
    }
    
}
?>