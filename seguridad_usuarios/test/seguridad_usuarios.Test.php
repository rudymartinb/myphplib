<?php
use seguridad_usuarios\Menu;


class seguridad_usuariosTest extends PHPUnit\Framework\TestCase {
    private $archivo = "seguridad_usuarios/dummy.php";
    private $tag = "nose";
    
    // me hace ruido meter un assert en un setup
    function mysetup1() : Menu {
        $menu = Menu::Builder() // devuelve un nuevo Menu()
        ->AgregarPrimario( "Clientes" ) // Devuelve un Pri
        
        ->AgregarSecundario()
        ->nombre( "Agregar Clientes" )
        ->tag( $this->tag )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->fuente( $this->archivo )
        ->funcion( function() { $this->assertTrue( muy_dummy() ); } )
        ->buildOpcion()
        ->buildMenu();
        
        return $menu;
    }
    
    function mysetup2( callable $funcion, callable $funcionDefault  ) : Menu {
        
        $menu = Menu::Builder() // devuelve un nuevo Menu()
        ->setFuncionDefault( $funcionDefault ) // parametros generales
        ->AgregarPrimario( "Clientes" ) // Devuelve un Pri
        
        ->AgregarSecundario()
        ->nombre( "Agregar Clientes")
        ->tag( $this->tag )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->fuente( $this->archivo )
        ->funcion( $funcion )->buildOpcion()
        
        ->AgregarSecundario()
        ->nombre( "Modificar Clientes")
        ->tag( $this->tag )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->fuente( $this->archivo )
        ->funcion( $funcion )->buildOpcion()
        
        ->buildMenu();
        return $menu;
    }
        
    function test_ejecutar(){
        $funcion = function() {
            $this->assertTrue( true );
        };
        $funcionDefault = function() { };
        
        $menu = $this->mysetup2( $funcion, $funcionDefault  );
        
        $menu->ejecutar( $this->tag );
    }

    
    function test_ejecutar_fail(){

        $funcion = function() { };
        $funcionDefault = function() {
            $this->assertTrue( true );
        };
        
        $menu = $this->mysetup2( $funcion, $funcionDefault  );
        
        $menu->ejecutar( "adsfadfasdf" );
    }
    
    function test_ExisteFuente(){
        
        $menu = $this->mysetup1();
        
        $this->assertTrue( $menu->existe_fuente( $this->tag ) );

    }

    function test_ExisteFuente_Fail(){
        
        $menu = $this->mysetup1();
        
        $this->assertFalse( $menu->existe_fuente( "sarasa" ) );
        
    }
    
    
    function test_CargarFuente(){
  
        $menu = $this->mysetup1();
 
        $menu->cargar_archivo( $this->tag );
        $menu->ejecutar(  $this->tag );

        
    }

    function test_CargarFuente_fail(){
        
        $menu = $this->mysetup1();
        
        $menu->cargar_archivo( "asdf" );

        
        
    }
    
    
}
?>