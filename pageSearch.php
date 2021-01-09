<?php /* Template Name: Search */ ?>
<?php 
      acf_form_head(); 
      get_header(); 


//date("d/m/Y", strtotime(" -1 week"));
/* The loop */ 
    //con esto imprimo los acf que estan en pg search
    acf_form();
    date_default_timezone_set('America/Costa_Rica'); 
    $remates          = get_field('tipo_de_remate');
    $provincia        = get_field('provincia');
    $idBuscar          = get_field('idBuscar');

    
    $date_now         = date('Y-m-d');
    $fechaBusqueda    = get_field('fecha');
    $fechaDelete      = date("Y-m-d", strtotime(" -1 week"));

    $moneda           = get_field('moneda_choose');
    $precio_colones   = get_field('precio_colones'); ///pueden ser varias opciones
    $precio_dolares   = get_field('precio_dolares');



      if($moneda == 'colones'){ 
            $moneda1= '₡'; 
            $precio_a_buscar = $precio_colones;
      }else{ 
            $moneda1= 'S'; 
            $precio_a_buscar = $precio_dolares;
      }

    
      define("TITULOGENERAL",       $tituloGeneral );
      define("CONTENIDO",           $contenidoGeneral );
      define("BLOCKES",             $blockes );

      define("MONEDA",        $moneda );
      define("TYPO",          $remates );

      define("FECHANow",      $date_now);
      define("FECHABusqueda", $fechaBusqueda );
      define("FECHADelete",   $fechaDelete);

      define("PROVINCIA",     $provincia );
      define("PRECIO",        $precio_a_buscar );
      define("DIVIDER",        '<br>/////////////////////<br>' );


    echo  ' $moneda '.        $moneda.          '<br>'.
    'TYPO remate '.           $remates.         '<br>'.
    'Fecha que estamos '.     $date_now.        '<br>'.
    'Fecha de busqueda '.     $fechaBusqueda.   '<br>'.
    'Fecha de borrar '.       $fechaDelete.     '<br>'.
    'precio_a_buscar '.       $precio_a_buscar. '<br>'.
    'ida_buscar '.            $idBuscar.        '<br>'.
    'provincia '.             var_dump($provincia).       '<br>';
  
    

      

      

?>



<script>
 jQuery(document).ready(function($) {

      //on click wrap  pone date en input date 
      $("#acf-field_5dfbceb8eccf6").click(function(){
      $date1 = $("#acf-field_5dfbceb8eccf6").datepicker({ dateFormat: 'yy-mm-dd' });   //* DateFormat Y-m-d  d-m-Y
      });


       var jsvar = <?php echo json_encode($myHtml); ?>;

      if(jsvar.lenngth > 0){
            console.log(jsvar);  
      }else{
            console.log('pdf vacio'); 
            console.log(jsvar); 
      }

 });//Jquery ready 

</script>



<?php get_footer(); ?>