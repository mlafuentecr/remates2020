<?php /* Template Name: Search */ ?>
<?php 
      acf_form_head(); 
      get_header(); 

      // example of how to use basic selector to retrieve HTML contents
      include('wp-content/themes/wp-gulpRemates/inc/simple_html_dom.php');


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
  
    

// -----------------------------------------------------------------------------
// scraping Saving
    function scraping_generic($url, $search) {
	// Didn't find it yet.
	$return = false;

	echo "reading the url: " . $url . "<br/>";
      // create HTML DOM
       $html = file_get_html($url);
	   echo "url has been read.<br/>";

      //para sacar el https
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($curl, CURLOPT_HEADER, false);
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_REFERER, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
      $str = curl_exec($curl);
      curl_close($curl);
                  
      // Create a DOM object
      $html_base = new simple_html_dom();
      // Load HTML from a string
      $html_base->load($str);


      // Tomo todo el contenido total
      foreach($html_base->find('div#main') as $e1)
      $GLOBALS['myHtml'] =  $e1->outertext;
   
      // Update ACF load_pdf var with new value.
      update_field( 'load_pdf', $contenidoGeneral, 3331 );
      


      // clean up memory
      $html_base->clear();
      unset($html_base);
      //echo '//////////  Saved   /////////////////';
      return;
      }



      //1  get DOM from URL or file
      $newDate = date("d/m/Y", strtotime(FECHABusqueda));  
      $url = 'https://www.imprentanacional.go.cr/boletin/?date='.$newDate;
      scraping_generic($url, $search);
      

      

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