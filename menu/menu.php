<?php
namespace seguridad_usuarios;

class Menu {
    private $primarios;
    private $defaultFun; 
    
    private function __construct(){
        $this->primarios = [];
    }
    
    static function Builder() {
        $menu = new Menu();
        return $menu;
    }
    
    function agregarPrimario( string $opcion ){
        $pri = new MenuPrimarioBuilder( $this, $opcion );
        $this->primarios[] = $pri;
        return $pri;
    }
    
    function ejecutar( $tag ){
        foreach ($this->primarios as $pri ){
            if( $pri->ejecutar_x_tag($tag) )
                return;
        }

        $funcion = $this->defaultFun;
        $funcion();
    }

    // esta funcion no deberia ser invocada 
    // directamente sin antes correr las dos validaciones
    // necesarioas: existe_tag  y existe_fuente
    function cargar_archivo( $tag ){
        $sec = $this->buscar_tag( $tag );
        require_once( $sec->get_fuente() );
    }

    function try_cargar_archivo( $tag ) {
        if( ! $this->existe_tag( $tag ) ){
            return;
        }
        if( ! $this->existe_fuente( $tag ) ){
            return;
        }

        $this->cargar_archivo( $tag );
    }
    
    
    function buscar_tag( $tag ) : Sec {
        foreach ($this->primarios as $pri ){
            if( $pri->existe_tag( $tag ) ){
                return $pri->obtenerOpciones( $tag );
            }
        }
    }
    function existe_tag( $tag ) : bool {
        foreach ($this->primarios as $pri ){
            if( $pri->existe_tag( $tag ) ){
                return true;
            }
        }
        return false;
    }
    
    function existe_fuente( $tag ){
        if( ! $this->existe_tag( $tag ) )
            return false;
        
        $sec = $this->buscar_tag( $tag );
        return file_exists(  $sec->get_fuente() );
    }
    
    function setFuncionDefault( callable $fun ){
        $this->defaultFun = $fun;
        return $this;
    }
    
}