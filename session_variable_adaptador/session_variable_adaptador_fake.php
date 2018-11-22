<?php
namespace session_variable_adaptador {
    class session_variable_adaptador_fake implements session_variable_adaptador_interface {
    	private $valores;
    	function __construct(){
    	    $this->valores = [];
    	}
    	function get( string $clave ) {
    		if( !isset( $this->valores[ $clave ] ) ){
    			return "";
    		}
    		
    		return $this->valores[ $clave ] ;
    	}
    
    	function set( string $clave, $valor ) {
    		$this->valores[ $clave ] = $valor;
    		return ;
    	}
    	function unset( string $clave ) {
    	}
    }
}
?>