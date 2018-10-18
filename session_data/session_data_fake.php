<?php
namespace session_data {
    class session_data_fake {
    	private $valores;
    	function session_fake () {
    		$this->valores = [];
    	}
    	function get( $clave ) {
    		if( !isset( $this->valores[ $clave ] ) ){
    			return "";
    		}
    		
    		return $this->valores[ $clave ] ;
    	}
    
    	function set( $clave, $valor ) {
    		$this->valores[ $clave ] = $valor;
    		return ;
    	}
    }
}
?>