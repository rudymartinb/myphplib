<?php
namespace menu;

class Menu {
    protected $primarios;
    protected $defaultFun;
    protected $tags;
    
    protected function __construct(){
        $this->primarios = [];
        $this->tags = [];
        
        // evitamos uso y comparacion contra null
        // asi podemos especificar el valor de retorno de funciones
        $this->defaultFun = function() {} ;
    }
    
    static function Builder(){
        return new class() extends Menu {
            private $actual_opcion;
            private $actual_subopcion;
            
            // esta subclase ejecuta __construct del parent
            
            function AgregarPrimario( string $opcion ) {
                $this->primarios[ $opcion ] = [];
                $this->actual_opcion = $opcion;
                return $this;
            }
            
            function AgregarSecundario( string $subopcion ){
                $this->primarios[ $this->actual_opcion  ][ $subopcion ] = [];
                $this->actual_subopcion = $subopcion;
                return $this;
            }
            
            function tag( string $tag ){
                $this->tags[ $tag ] = [];
                $this->tag_actual = $tag;
                
                $this->primarios[ $this->actual_opcion  ][ $this->actual_subopcion  ]["tag"] = $tag;
                
                $this->tags[ $this->tag_actual ]["funcion"] = function() {};
                return $this;
            }
            
            function grupos( Array $grupos ){
                $this->tags[ $this->tag_actual ]["grupos"] = $grupos;
                return $this;
            }
            
            function setfuente( string $fuente ){
                $this->tags[ $this->tag_actual ]["fuente"] = $fuente;
                return $this;
            }
            
            function setfuncion( Callable $funcion ){
                $this->tags[ $this->tag_actual ]["funcion"] = $funcion;
                return $this;
            }
            function setfuncionDefault( Callable $funcion ){
                $this->defaultFun = $funcion;
                return $this;
            }
            function buildMenu( ){
                $menu = new Menu();
                $menu->primarios = $this->primarios;
                $menu->tags = $this->tags;
                $menu->defaultFun = $this->defaultFun ;
                return $menu;
            }
            
        };

    }
    
    private function cargar_fuente( string $tag ){
        if( ! array_key_exists( $tag, $this->tags ) )
            return null; 
        if( ! array_key_exists("fuente", $this->tags[ $tag ] ) )
            return null;
        if( ! file_exists( $this->tags[ $tag ]["fuente"]) )
            return null;
        
        require_once( $this->tags[ $tag ]["fuente"] );
    }

    
    private function devolver_funcion( string $tag ) : callable {
        
        if( ! array_key_exists($tag, $this->tags ) )
            return $this->defaultFun;
        
        if( ! array_key_exists( "funcion", $this->tags[ $tag ] ) )
            return $this->defaultFun;
        
        return $this->tags[ $tag ]["funcion"];
    }
    
    function ejecutar( string $tag ){
        $this->cargar_fuente( $tag );
        $funcion = $this->devolver_funcion( $tag );

        $funcion();
    }
}

?>