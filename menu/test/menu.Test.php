<?php
use menu\Menu;


class menuTest extends PHPUnit\Framework\TestCase {
    private $archivo = "menu/test/dummy.php";
    private $archivo2 = "menu/test/dummy2.php";
    private $archivo_inexistente = "nadaquever/dummy2.php";
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
    
    function BuildMenu_real_2fuentes() : Menu  {
        $menu = Menu::Builder() // devuelve un nuevo Menu()
        ->AgregarPrimario( "Clientes" ) // Devuelve un Pri
        
        ->AgregarSecundario( "Agregar Clientes" )
        ->tag( $this->tag_alta )
        // ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo )
        ->setfuente( $this->archivo2 )
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
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo )
        ->setfuncion( $funcion )
        
        ->AgregarSecundario( "Modificar Clientes" )
        ->tag( $this->tag_modi )
        ->grupos( [ "Autorizados","Administradores","grupo1" ] )
        ->setfuente( $this->archivo_inexistente )
        ->setfuncion( $funcion )

        
        ->AgregarPrimario( "Proveedores" )
        
        ->AgregarSecundario( "Agregar Proveedor" )
        ->tag( $this->tag_alta_prov )
        ->grupos( [ "Autorizados","Administradores","Operadores" ] )
        ->setfuente( $this->archivo )
        ->setfuncion( $funcion )
        
        ->AgregarSecundario( "Modificar Proveedor" )
        ->tag( $this->tag_modi_prov )
        ->grupos( [ "Autorizados","Administradores","grupo1" ] )
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
    
    
    // assert embebido en la funcion constructor
    function test_CargarFuente(){
        $menu = $this->BuildMenu_real();
        $menu->ejecutar(  $this->tag_alta );
    }

    // assert embebido en la funcion constructor
    function test_Cargar_dos_fuentes(){
        $menu = $this->BuildMenu_real_2fuentes();
        $menu->ejecutar(  $this->tag_alta );
    }
    
    
    /* tag existente pero el fuente no existe
     */
    function test_CargarFuente_fail(){
        $menu = Menu::Builder() 
        ->AgregarPrimario( "Clientes" ) 
        
        ->AgregarSecundario( "Agregar Clientes" )
        ->tag( $this->tag_alta )
        ->setfuente( $this->archivo_inexistente )
        ->buildMenu();

        // me resulta mas cómodo usar Try que los tags de phpunit
        try {
            $menu->ejecutar(  $this->tag_alta );
        } catch( Error $error ){
            // podria evaluar si el mensaje de error es que el archivo X no existe
            // pero el drama es que dependemos de la version de PHP para que el mensaje sea igual
            $this->assertTrue ( true );
            
        }
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
     * quien decide que opcoin va y que opcion no?
     * o puesto de otra manera, donde coloco una funcion que decida eso?
     * 
     * el codigo responsable de contruir el menu debe ser unico
     * 
     */

    function test_tags() {
        
        $funcion = function() { };
        $menu = $this->BuildMenu2( $funcion, $funcion  );
        
        $actual = $menu->get_tags();
        $this->assertEquals( 4, count( $actual ) );
    }
    
    /*
     * se me ocurrio la mas facil de todas:
     * armar un metodo estatico que devuelva un nuevo objeto menu
     * con el menu filtrado
     */

    function test_filtrar1() {
  
        $funcion = function() { };
        $menu = $this->BuildMenu2( $funcion, $funcion  );
        $menu = $menu->filtrar( [ "grupo1" ] );
        $actual = $menu->get_tags();
        $this->assertEquals( 2, count( $actual ) );
    }
    
    function test_filtrar1_fail() {
        $funcion = function() { };
        $menu = $this->BuildMenu2( $funcion, $funcion  );
        $menu = $menu->filtrar( [ "grupo", "grupo11" ] );
        $actual = $menu->get_tags();
        $this->assertEquals( 0, count( $actual ) );
    }
    
    /*
     * la pregunta del millon:
     * porque este objeto debe saber que es HTML?
     */
    function test_generar_html( ) {
        $funcion = function() { };
        $menu = $this->BuildMenu2( $funcion, $funcion  );
        $html = $menu->generar_html(); 
        $this->assertEquals( "esto", $html );
        
    }
 
    
}
?>