<?php
namespace menu;

class Menu {
    protected $primarios;
    protected $defaultFun;
    protected $tags;
    protected $grupos;
    
    protected function __construct(){
        $this->primarios = [];
        $this->tags = [];
        
        // evitamos uso y comparacion contra null
        // asi podemos especificar el valor de retorno de funciones
        $this->defaultFun = function() {} ;
    }
    
    static function Builder(){
        return new class() extends Menu {
            private $actual_opcion;
            private $actual_subopcion;
            
            // esta subclase ejecuta __construct del parent
            
            function AgregarPrimario( string $opcion ) {
                $this->actual_opcion = $opcion;
                return $this;
            }
            
            function AgregarSecundario( string $subopcion ){
                $this->actual_subopcion = $subopcion;
                return $this;
            }

            /* de la forma en que esta armado esto, tag solo se puede
             * ejecutar despues de AgregarPrimario y secundario
             * y debe ser antes de cualquier otra cosa como grupo
             */
            function tag( string $tag ){
                $this->tags[ $tag ] = [];
                $this->tag_actual = $tag;
                
                $valores = [];
                
                $valores["funcion"] = function() {};
                $valores["opcion"] = $this->actual_opcion;
                $valores["subopcion"] = $this->actual_subopcion;
                $valores["fuente"] = [];
                
                $this->tags[ $this->tag_actual ] = $valores;
                
                return $this;
            }
            
            function grupos( Array $grupos ){
                $this->tags[ $this->tag_actual ]["grupos"] = $grupos;
                $this->separar_grupos($this->tag_actual, $grupos);
                return $this;
            }
            
            function setfuente( string $fuente ){
                $this->tags[ $this->tag_actual ]["fuente"][] = $fuente;
                return $this;
            }
            
            function setfuncion( Callable $funcion ){
                $this->tags[ $this->tag_actual ]["funcion"] = $funcion;
                return $this;
            }
            function setfuncionDefault( Callable $funcion ){
                $this->defaultFun = $funcion;
                return $this;
            }
            function buildMenu( ){
                $menu = new Menu();
                $menu->primarios = $this->primarios;
                $menu->tags = $this->tags;
                $menu->defaultFun = $this->defaultFun ;
                $menu->grupos = $this->grupos;
                return $menu;
            }
            
        };

    }
    
    // efectos colaterales: fuente especificado que no existe.
    // tirar excepcion?
    /*
     * cargar_fuente: demasiadas responsabilidades?
     * determina si el tag existe
     * determina si el tag tiene el tag fuente
     * para cada elemento del tag fuente, determina si existe el fuente
     * carga el fuente en cuestion si existe
     * sino da error.
     * 
     */
    private function cargar_fuente( string $tag ){
        if( ! array_key_exists( $tag, $this->tags ) or  ! array_key_exists("fuente", $this->tags[ $tag ] ) )
            return null;
        
        foreach( $this->tags[ $tag ]["fuente"] as $value ) {
            if( file_exists( $value ) )
                require_once( $value );
            else
                throw new \Error( "fuente no encontrado: [".$value."]" );
        }
    }

    
    private function devolver_funcion( string $tag ) : callable {
        
        if( ! array_key_exists($tag, $this->tags ) )
            return $this->defaultFun;
        
        if( ! array_key_exists( "funcion", $this->tags[ $tag ] ) )
            return $this->defaultFun;
        
        return $this->tags[ $tag ]["funcion"];
    }
    
    function ejecutar( string $tag ){
        $this->cargar_fuente( $tag );
        $funcion = $this->devolver_funcion( $tag );

        $funcion();
    }

    function get_tags() : Array {
        return $this->tags;
    }
    
    
    /* $this->grupos contiene la lista de tags de cada grupo existente
     * como esta planteado esto puede sucede que un mismo tag se "incorpore"
     * mas de una vez pero los array en php no pueden tener claves duplicadas
     */
    function filtrar( Array $gruposUsuario ) : Menu {
        $menu = new Menu();

        // $gruposUsuario es Array de strings
        foreach( $gruposUsuario as $grupo ){
            if( array_key_exists( $grupo, $this->grupos ) ){
                foreach( $this->grupos[ $grupo ] as $tag  ){
                    $valores = $this->tags[ $tag ];
                    $menu->agregar_tag( $tag, $valores );
                    $menu->separar_grupos( $tag, $valores[ "grupos" ] );
                }
            }
                
        }
        
        return $menu;
    }
    
    protected function agregar_tag( string $tag, Array $valores ){
        $this->tags[ $tag ] = $valores;
    }
    
    /* arma una grilla de grupos y tags
     * puede que no exista una lista de grupos
     * de ahi la necesidad de separarlos
     */
    protected function separar_grupos( string $tag, Array $grupos ){
        foreach ($grupos as $grupo){
            $this->grupos[ $grupo ][] = $tag ;
        }
    }
    
    function generar_html( ){
        // var_dump($this->tags );
        // $opciones = $this->opciones_usuario( $grupos_user );
        
        $html = '';
//        $html .= '<script src="/js/menu.js"></script>';
//        $html .= '<link rel="stylesheet" href="css/menu.css">';

        // $html .= '<ul id="menu" >';
        $html .= '<ul >';
        $abierto = false;
        

        $ultimo_menu = "";
        foreach( $this->tags as $key => $value ){
            if( $ultimo_menu != $value ["opcion"] ){
                $html .= '<li class=""><ul>';
                $ultimo_menu  = $value ["opcion"];
                $abierto = true;
            }
            $html .= '<div>'.$value['opcion'].'</div>';
            // $html .= '<div>'.$value['subopcion'].'</div>';
            $html .= '<a class="opcionmenu" href="?o='.$key.'" style="">';
            
//             if( count( $value ) == 1 ){
//                 if( $abierto ){
//                     $abierto = false;
//                     $html .= "</ul></li>";
//                 }
//                 $html .= '<li class=""><div>'.$value['nombre'].'</div><ul>';
//                 $abierto = true;
//             } 
//             else {
//                 $html .= '<a class="opcionmenu" href="?o='.$value['url'].'" style="">';
//                 if( $value['nombre'] == '-' )
//                     $html .= '<li><div class=".ui-menu-divider"> </div></li></a>';
//                     else
//                         $html .= '<li><div>'.$value['nombre'].'</div></li></a>';
//             }
        }
        $html .= '</ul>';
        if( $abierto ){
            $html .= "</li>";
        }
        
        
        return $html;
    }
}

?>