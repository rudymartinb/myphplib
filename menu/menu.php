<?php
namespace menu;

/* 20181226 decidi hacerlo de nuevo porque me estaba complicando la vida de gusto
 * de momento no tenia una necesidad real de crear tantos builders
 *
 * queda una sola clase con dos atributos principales:
 * una lista simple de tags con los fuentes y funciones asociadas
 * una lista de opciones con la estructura de subopciones asociadas y el tag que le corresponde a cada una
 * 
 * de esta evitamos iteraciones y el codigo queda mas compacto
 */

class Menu {
    private $primarios;
    private $actual_opcion;
    private $actual_subopcion;

    private $tags;
    
    private function __construct(){
        $this->primarios = [];
        $this->submenu = [];
        $this->tags = [];
    }
    
    static function Builder(){
        $menu = new Menu();
        return $menu;
    }
    function AgregarPrimario( string $opcion ){
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
        return $this;
    }
    
    

    function ejecutar( string $tag ){
        
        if( array_key_exists($tag, $this->tags ) ){
            if( file_exists( $this->tags[ $tag ]["fuente"]) )
                require_once( $this->tags[ $tag ]["fuente"] );
            $funcion = $this->tags[ $tag ]["funcion"];
        } else {
            $funcion = $this->defaultFun;
        }
        $funcion();
    }
}

?>