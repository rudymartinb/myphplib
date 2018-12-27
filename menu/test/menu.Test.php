<?php
use menu\Menu;


class menuTest extends PHPUnit\Framework\TestCase {
    private $archivo = "menu/dummy.php";
    private $archivo_inexistente = "seguridad_usuarios/dummy2.php";
    private $tag_alta = "altaclientes";
    private $tag_modi = "modiclientes";
    private $tag_alta_prov = "altaprov";
    private $tag_modi_prov = "modiprov";
    
    function BuildMenu_real() : Menu  {
        $menu = Menu::Builder() // devuelve un nuevo Menu()
        ->AgregarPrimario( "Clientes" ) // Devuelve un Pri
        
        ->AgregarSecundario( "Agregar Clientes" )
        ->tag( $this->tag_alta )
        // ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo )
        ->setfuncion( function() { $this->assertTrue( muy_dummy() ); } )
        
        ->buildMenu();
        
        return $menu;
    }
    
    // la diferencia entre este y el anterior 
    // es la funcion, en este caso se la forzamos 
    function BuildMenu2( callable $funcion, callable $funcionDefault  ) : Menu {
        
        $menu = Menu::Builder()
        ->setFuncionDefault( $funcionDefault )
        ->AgregarPrimario( "Clientes" )
        
        ->AgregarSecundario( "Agregar Clientes" )
        ->tag( $this->tag_alta )
        // ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo )
        ->setfuncion( $funcion )
        
        ->AgregarSecundario( "Modificar Clientes" )
        ->tag( $this->tag_modi )
        // ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo_inexistente )
        ->setfuncion( $funcion )

        ->AgregarPrimario( "Proveedores" )
        
        ->AgregarSecundario( "Agregar Proveedor" )
        ->tag( $this->tag_alta_prov )
        // ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo )
        ->setfuncion( $funcion )
        
        ->AgregarSecundario( "Modificar Proveedor" )
        ->tag( $this->tag_modi_prov )
        // ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo_inexistente )
        ->setfuncion( $funcion )
        
        ->buildMenu();
        return $menu;
    }

    

    
    function test_ejecutar(){
        $funcionDefault = function() {
            $this->assertTrue( false ); // no deberia llegar aqui
        };
        $funcion = function() {
            $this->assertTrue( true );
        };

        
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

    function test_ejecutar_fail2(){
        
        // no tiene relevancia el contenido del menu
        $menu = Menu::Builder()->buildMenu();
        
        $menu->ejecutar( "adsfadfasdf" );
        // por cuanto se ejecuta un tag no existente 
        // y no hay funcion default definida, no debe dar error
        // en todo caso habra que agregar un log_error en ejecutar()
        $this->assertTrue( true ); 
    }
    
    
    
    function test_CargarFuente(){
        $menu = $this->BuildMenu_real();
        $menu->ejecutar(  $this->tag_alta );
    }
    
    
    /* tag existente pero el fuente no existe
     * pero tiene funcion anonima asociada
     */
    function test_CargarFuente_fail(){
        $menu = Menu::Builder() 
        ->AgregarPrimario( "Clientes" ) 
        
        ->AgregarSecundario( "Agregar Clientes" )
        ->tag( $this->tag_alta )
        // ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo_inexistente )
        ->setfuncion( function() { $this->assertTrue( muy_dummy() ); } )
        
        ->buildMenu();
        
        $menu->ejecutar(  $this->tag_alta );
    }
    

    function test_CargarFuente_fail2(){
        $menu = Menu::Builder()
        ->AgregarPrimario( "Clientes" )
        
        ->AgregarSecundario( "Agregar Clientes" )
        ->tag( $this->tag_alta )
//         ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuncion( function() { $this->assertTrue( muy_dummy() ); } )
        
        ->buildMenu();
        
        $menu->ejecutar(  $this->tag_alta );
    }
    
    /* RDD : Readme development driven.
     * 
     * quiero resolver la cuestion de los grupos de usuarios
     * al menos de una manera un tanto torpe y despues veo
     * 
     * en principio el usuario tiene que estar registrado antes de cargarse el menu
     * por lo tanto es razonable suponer que para una app que no sea publica
     * le pasemos los grupos validos sobre los cuales debe operar
     * 
     * ahora el problema es como construyo el objeto menu
     * dado que hasta que no declaro los grupos validos para la opcion
     * no tengo forma de saber cual va y cual no
     * 
     * 
     */
    
    
    
}
?>