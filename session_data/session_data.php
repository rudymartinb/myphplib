<?php
namespace session_data  {
    class session_data {

    	function get( $clave ) {
    		global $_SESSION;
    		if( array_key_exists( $clave, $_SESSION ) )
    			return $_SESSION[ $clave ] ;
    		return "";
    	}
    
    	function set( $clave, $valor ) {
    		global $_SESSION;
    		$_SESSION[ $clave ] = $valor;
    		return ;
    	}
    	function unset( $clave ) {
    	    global $_SESSION;
    	    if( array_key_exists( $clave, $_SESSION ) )
    	        unset( $_SESSION[ $clave ] ) ;
    	        
    	}
    	
    	
    }
}
?>