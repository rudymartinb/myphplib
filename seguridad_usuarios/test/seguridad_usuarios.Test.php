<?php

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
        $pri = new Pri( $this, $opcion );
        $this->primarios[] = $pri;
        return $pri;
    }
    
    function ejecutar( $tag ){
        foreach ($this->primarios as $pri ){
            $pri->ejecutar_x_tag($tag);
        }
    }
    function existe_fuente( $fuente ){
        return file_exists( $fuente );
    }
    
    function funcionDefault( callable $fun ){
        $this->defaultFun = $fun;
        return $this;
    }
    
}

class Pri extends Menu {
    private $menu;
    private $nombre;
    private $secundarios;
    function __construct( Menu $menu, string $opcion ){
        $this->menu = $menu;
        $this->nombre = $opcion;
        $this->secundarios = [];
    }
    
    function ejecutar_x_tag( $tag ){
        foreach ($this->secundarios as $sub ){
            if( $sub->get_tag() === $tag  ){
                $funcion = $sub->get_funcion();
                $funcion();
            }
        }
    }
    
    function AgregarSecundario( ){
        $sec = Sec::BuilderSec( $this );
        return $sec;
    }
    protected function addsec( Sec $sec ){
        $this->secundarios[] = $sec ;
    }
    
    function buildMenu(){
        return $this->menu;
    }
    
}

class Sec extends Pri {
    protected $nombre;
    protected $tag;
    protected $grupos;
    protected $funcion;
    protected $fuente;
    
    protected function __construct(  ){
    }
    static function BuilderSec( $pri ){
        return new BuilderSecundario( $pri );
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

class BuilderSecundario extends Sec {
    private $pri ;
    public function __construct( Pri $pri ){
        $this->pri = $pri;
    }
    
    function nombre( string $nombre ){
        $this->nombre = $nombre;
        return $this;
    }
    function tag( string $nombre ){
        $this->tag = $nombre;
        return $this;
    }
    function grupos( Array $nombre ){
        $this->grupos = $nombre;
        return $this;
    }
    function fuente( string $nombre ){
        $this->fuente = $nombre;
        return $this;
    }
    function funcion( callable $nombre ){
        $this->funcion = $nombre;
        return $this;
    }
    function buildOpcion() : Pri {
        $sec = new Sec();
        $sec->nombre = $this->nombre;
        $sec->tag = $this->tag;
        $sec->grupos = $this->grupos;
        $sec->fuente  = $this->fuente;
        $sec->funcion  = $this->funcion;
        $this->pri->addSec( $sec );
        return $this->pri;
    }
}

class seguridad_usuariosTest extends PHPUnit\Framework\TestCase {
    
    function test_ejecutar(){
        $funcion = function() {
            $this->assertTrue( true );
        };
        
        /*
         * HONESTAMENTE queda mucho mas largo
         * pero si la idea es comunicar con claridad,
         * entonces puede decirse que queda mucho mas entendible.
         * 
         */
        
        // prueba funcional
        $menu = Menu::Builder() // devuelve un nuevo Menu()
        ->AgregarPrimario( "Clientes" ) // Devuelve un Pri
        
        ->AgregarSecundario() 
        ->nombre( "Agregar Clientes")
        ->tag( "agregar_clientes" )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->fuente( "fuente" )
        ->funcion( $funcion )->buildOpcion()
        
        ->AgregarSecundario()
        ->nombre( "Modificar Clientes")
        ->tag( "modi_clientes" )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->fuente( "fuente" )
        ->funcion( $funcion )->buildOpcion()
        
        ->buildMenu();
        
        $menu->ejecutar( "agregar_clientes" );
    }

    
    function test_ejecutar_fail(){
        $funcion = function() {
            $this->assertTrue( true );
        };
        
        /*
         * HONESTAMENTE queda mucho mas largo
         * pero si la idea es comunicar con claridad,
         * entonces puede decirse que queda mucho mas entendible.
         *
         */
        
        // prueba funcional
        $menu = Menu::Builder() // devuelve un nuevo Menu()
        ->funcionDefault( $funcion )
        ->AgregarPrimario( "Clientes" ) // Devuelve un Pri
        
        ->AgregarSecundario()
        ->nombre( "Agregar Clientes")
        ->tag( "agregar_clientes" )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->fuente( "fuente" )
        ->funcion( $funcion )->buildOpcion()
        
        ->AgregarSecundario()
        ->nombre( "Modificar Clientes")
        ->tag( "modi_clientes" )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->fuente( "fuente" )
        ->funcion( $funcion )->buildOpcion()
        
        ->buildMenu();
        
        $menu->ejecutar( "nada" );
    }
    

    function test_CargarFuente(){
        
        // contiene muy_dummy() que devuelve true
        $archivo = "seguridad_usuarios/dummy.php";
        $tag = "super_dummy";
        
        
        $menu = Menu::Builder() // devuelve un nuevo Menu()
        ->AgregarPrimario( "Clientes" ) // Devuelve un Pri
        
        ->AgregarSecundario()
        ->nombre( "Agregar Clientes" )
        ->tag( $tag )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->fuente( $archivo )
        ->funcion( function() { $this->assertTrue( muy_dummy() ); } )
        ->buildOpcion()
        ->buildMenu();
        
        
 
        $this->assertTrue( $menu->existe_fuente( $tag ) );
        $menu->cargar_archivo( $tag );
        $this->assertTrue( $menu->ejecutar( $tag ) );
        
        
    }
}
?>