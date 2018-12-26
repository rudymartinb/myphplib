<?php
use menu\Menu;


class menuTest extends PHPUnit\Framework\TestCase {
    private $archivo = "menu/dummy.php";
    private $archivo_inexistente = "seguridad_usuarios/dummy2.php";
    private $tag_alta = "altaclientes";
    private $tag_modi = "modiclientes";
    
    function BuildMenu1() : Menu {
        $menu = Menu::Builder() // devuelve un nuevo Menu()
        ->AgregarPrimario( "Clientes" ) // Devuelve un Pri
        
        ->AgregarSecundario( "Agregar Clientes" )
        ->tag( $this->tag_alta )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo )
        ->setfuncion( function() { $this->assertTrue( muy_dummy() ); } )
        ->buildMenu();
        
        return $menu;
    }
    
    function BuildMenu2( callable $funcion, callable $funcionDefault  ) : Menu {
        
        $menu = Menu::Builder()
        ->setFuncionDefault( $funcionDefault )
        ->AgregarPrimario( "Clientes" )
        
        ->AgregarSecundario( "Agregar Clientes" )
        ->tag( $this->tag_alta )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo )
        ->setfuncion( $funcion )
        
        ->AgregarSecundario( "Modificar Clientes" )
        ->tag( $this->tag_modi )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo_inexistente )
        ->setfuncion( $funcion )
        
        ->buildMenu();
        return $menu;
    }
        
    function test_ejecutar(){
        $funcion = function() {
            $this->assertTrue( true );
        };
        $funcionDefault = function() { };
        
        $menu = $this->BuildMenu2( $funcion, $funcionDefault  );
        
        $menu->ejecutar( $this->tag_alta );
    }

    
    function test_ejecutar_fail(){

        $funcion = function() { // no deberia correr pero = dejo codigo que lo invalide 
            $this->assertTrue( false ); 
        };
        $funcionDefault = function() {
            $this->assertTrue( true );
        };
        
        $menu = $this->BuildMenu2( $funcion, $funcionDefault  );
        
        $menu->ejecutar( "adsfadfasdf" );
    }
    
    function test_ExisteFuente(){
        
        $menu = $this->BuildMenu1();
        
        $this->assertTrue( $menu->existe_fuente( $this->tag_alta ) );

    }

    function test_ExisteFuente_Fail(){
        
        $menu = $this->BuildMenu1();
        
        $this->assertFalse( $menu->existe_fuente( "sarasa" ) );
        
    }
    
    
    function test_CargarFuente(){
  
        $menu = $this->BuildMenu1();
 
        $menu->cargar_archivo( $this->tag_alta );
        $menu->ejecutar(  $this->tag_alta );
   
    }

//     /* 
//      * objetivo: la idea es tener una funcion try_cargarfuente() 
//      * que impida que php se cierre por un fuente inexistente.
//      * 
//      * entrada: un objeto estructura de menu
//      * proceso: se pide cargar el fuente de un tag existente pero fuente inexistente
//      * salida esperada: excepcion de php? no sirve, da fatal. No tiene que probar nada
//      * 
//      */
    function test_CargarFuente_fail(){
        
        $funcion = function() { };
        $funcionDefault = function() { };
        
        $menu = $this->BuildMenu2( $funcion, $funcionDefault  );

        // si se cambia por cargar_archivo() el script no termina porque da error fatal
        $menu->try_cargar_archivo( $this->tag_modi );
        
        $this->assertTrue( true );
    }
    
    
}
?>