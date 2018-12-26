<?php
namespace menu;

class MenuPrimarioBuilder extends Menu {
    private $menu;
    private $nombre;
    private $secundarios;
    
    function __construct( Menu $menu, string $opcion ){
        $this->menu = $menu;
        $this->nombre = $opcion;
        $this->secundarios = [];
    }
    
    function ejecutar_x_tag( $tag ) : bool {
        foreach ($this->secundarios as $sub ){
            if( $sub->get_tag() === $tag  ){
                $funcion = $sub->get_funcion();
                $funcion();
                return true;
            }
        }
        return false;
    }

    function existe_tag( $tag ) : bool {
        foreach ($this->secundarios as $sub ){
            if( $sub->get_tag() === $tag  ){
                return true;
            }
        }
        return false;
    }
    
    function obtenerOpciones( $tag ) : Sec {
        foreach ($this->secundarios as $sub ){
            if( $sub->get_tag() === $tag  ){
                return $sub;
            }
        }
        return null;
    }
    
    function AgregarSecundario( string $nombre ){
        $sec = Sec::BuilderSec( $this );
        $sec->nombre( $nombre );
        return $sec;
    }
    protected function addsec( Sec $sec ){
        $this->secundarios[] = $sec ;
    }
    
    function buildMenu(){
        return $this->menu;
    }
    
}


class Sec extends MenuPrimarioBuilder  {
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
/* podria haber usado una clase anonima
 * pero la herramienta para hacer el UML se pega un pedo terrible
 */
class BuilderSecundario extends Sec {
    private $pri ;
    public function __construct( MenuPrimarioBuilder  $pri ){
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
    function setfuente( string $nombre ){
        $this->fuente = $nombre;
        return $this;
    } 
    function setfuncion( callable $nombre ){
        $this->funcion = $nombre;
        return $this;
    }
    function buildOpcion() : MenuPrimarioBuilder  {
        $sec = new Sec();
        $sec->nombre = $this->nombre;
        $sec->tag = $this->tag;
        $sec->grupos = $this->grupos;
        $sec->fuente  = $this->fuente;
        $sec->funcion  = $this->funcion;
        $this->pri->addSec( $sec );
        return $this->pri;
    }
    function buildmenu(){
        $this->buildOpcion();
        return $this->pri->buildmenu();
    }

    
}

?>