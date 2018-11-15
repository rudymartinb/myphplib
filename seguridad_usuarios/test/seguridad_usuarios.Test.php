<?php

class Menu {
    private $primarios;
    private function __construct(){
        $this->primarios = [];
    }
    
    static function Builder() {
        $menu = new Menu();
        return $menu;
    }
    
    function agregarPri( string $opcion ){
        $pri = new Pri( $this, $opcion );
        $this->primarios[] = $pri;
        return $pri;
    }
    
    function ejecutar( $tag ){
        foreach ($this->primarios as $pri ){
            $pri->ejecutar_x_tag($tag);
        }
    }
}

class Pri extends Menu {
    private $menu;
    private $nombre;
    private $subs;
    function __construct( Menu $menu, string $opcion ){
        $this->menu = $menu;
        $this->nombre = $opcion;
        $this->subs = [];
    }
    
    function ejecutar_x_tag( $tag ){
        foreach ($this->subs as $sub ){
            if( $sub->get_tag() === $tag  ){
                $funcion = $sub->get_funcion();
                $funcion();
            }
        }
    }
    
    function AgregarSub( string $nombre, string $tag, Array $grupos, string $fuente, callable $funcion ){
        $this->subs[] = new Sec( $nombre, $tag, $grupos, $fuente, $funcion  ) ;
        return $this;
    }
    
    function buildPri(){
        return $this->menu;
    }
    
}

class Sec extends Pri {
    private $nombre;
    private $tag;
    private $grupos;
    private $funcion;
    private $fuente;
    function __construct( string $nombre, string $tag, Array $grupos, string $fuente, callable $funcion ){
        $this->nombre = $nombre;
        $this->tag = $tag;
        $this->grupos = $grupos;
        $this->fuente = $fuente;
        $this->funcion = $funcion;
    }
    function get_nombre(){
        return $this->nombre;
    }
    function get_tag(){
        return $this->tag;
    }
    function get_grupos(){
        return $this->grupos;
    }
    function get_funcion(){
        return $this->funcion;
    }
    function get_fuente(){
        return $this->fuente;
    }
    
}

class seguridad_usuariosTest extends PHPUnit\Framework\TestCase {
    
    function test_ejecutar(){
        $funcion = function() {
            $this->assertTrue( true );
        };
        
        // prueba funcional
        $menu = Menu::Builder() // devuelve un nuevo Menu()
        ->AgregarPri( "Clientes" ) // Devuelve un Pri
        ->AgregarSub( "Agregar Clientes", "agregar_clientes", [ "Autorizados","Administradores","Operadores" ], "fuente", $funcion )
        ->buildPri(); // devuelve el Menu actual
        
        $menu->ejecutar( "agregar_clientes" );
    }

    function test_New(){
        /*
         * la idea de esta clase de objeto es establecer una relacion 
         * entre grupos de usuarios y nobmres de opciones a ejecutar
         * 
         * creo que es preferible generar una herramienta que permita informar 
         * que opciones tiene que grupos 
         * y que grupos tiene que opciones
         * 
         * estoy pensando en un archivo de texto
         * que contenga: nombre de menu principal
         * nombre submenu + opcion + grupos habilidatos con comas
         * 
         */

        $funcion = function(){ $this->assertTrue(true); };
        
        // prueba funcional
        $menu = Menu::Builder() // devuelve un nuevo Menu()
        ->AgregarPri( "Clientes" ) // Devuelve un Pri
        ->AgregarSub( "Agregar Clientes", "agregar_clientes", [ "Autorizados","Administradores","Operadores" ], "fuente", $funcion )
        ->AgregarSub( "Modificar Clientes", "modificar_clientes", [ "Autorizados","Administradores","Operadores" ] , "fuente", $funcion )
        ->AgregarSub( "Borrar Clientes", "borrar_clientes", [ "Autorizados","Administradores","Operadores" ] , "fuente", $funcion )
        ->buildPri() // devuelve el Menu actual
        ->AgregarPri( "Proveedores" ) 
        ->AgregarSub( "Agregar Proveedores", "agregar_prov", [ "Autorizados","Administradores","Operadores" ] , "fuente", $funcion )
        ->AgregarSub( "Modificar Proveedores", "modificar_prov", [ "Autorizados","Administradores","Operadores" ] , "fuente", $funcion )
        ->AgregarSub( "Borrar Proveedores", "borrar_prov", [ "Autorizados","Administradores","Operadores" ] , "fuente", $funcion )
        ->buildPri();
        
        $menu->ejecutar( "borrar_prov" );
        
//         $json = json_encode( $arr );
//         $esperado = '{"Clientes":{"Agregar Clientes":"agregar_clientes","Modificar Clientes":"modificar_clientes","Borrar Clientes":"eliminar_clientes"}}';
//         $actual = $json;
        
        // por ahora lo dejo asi
        $this->assertTrue( true );
        
        
    }
}
?>