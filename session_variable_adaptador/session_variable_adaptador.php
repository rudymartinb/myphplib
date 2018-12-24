<?php
namespace session_variable_adaptador   {
    class session_variable_adaptador implements session_variable_adaptador_interface {

        function get( string $clave ) {
    		global $_SESSION;
    		/* parece muy ilogico esto pero
    		 * si la prueba corre en diferentes procesos entonces $_SESSION 
    		 * puede no estar definida
    		 */
    		if( !isset( $_SESSION ) )
    		    return "";
    		if( array_key_exists( $clave, $_SESSION ) )
    			return $_SESSION[ $clave ] ;
    		return "";
    	}
    
    	function set( string $clave, $valor ) {
    		global $_SESSION;
    		$_SESSION[ $clave ] = $valor;
    		return ;
    	}
    	function unset( string $clave ) {
    	    global $_SESSION;
    	    if( array_key_exists( $clave, $_SESSION ) )
    	        unset( $_SESSION[ $clave ] ) ;
    	        
    	}
    	
    	
    }
}
?>