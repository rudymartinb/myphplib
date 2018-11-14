<?php
class Menu {
    static function Builder() {
        return new class {
            function Agregar(){
                return $this;
                
            }
            function AgregarSub(){
                return $this;
            }
            function build(){
                
            }
        };
    }
    
}
class seguridad_usuariosTest extends PHPUnit\Framework\TestCase {
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
        $arr = [];
                
        $arr[ "Clientes" ] = [ ];
        $arr[ "Clientes" ]["agregar_clientes"]["nombre"] = "Agregar Clientes"  ;
        $arr[ "Clientes" ]["agregar_clientes"]["grupos"] = [ "Autorizados","Administradores","Operadores" ] ;
        

        // prueba funcional
        $menu = Menu::Builder()->Agregar( "Clientes" )
        ->AgregarSub( "Agregar Clientes", "agregar_clientes", [ "Autorizados","Administradores","Operadores" ] )
        ->AgregarSub( "Modificar Clientes", "modificar_clientes", [ "Autorizados","Administradores","Operadores" ] )
        ->AgregarSub( "Borrar Clientes", "borrar_clientes", [ "Autorizados","Administradores","Operadores" ] )
        ->build();
        
        
        
        $json = json_encode( $arr );
        var_dump( $json );
        
        var_dump( json_decode( $json , true ) );
        
        $esperado = '{"Clientes":{"Agregar Clientes":"agregar_clientes","Modificar Clientes":"modificar_clientes","Borrar Clientes":"eliminar_clientes"}}';
        
        $actual = $json;
        
        // $this->assertEquals( $esperado, $actual );
        
        
        
        // $arender = separar_grupos( $arr  );
        
        
        
    }
}
?>