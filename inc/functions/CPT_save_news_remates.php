<?php
require  $GLOBALS['themePath'].'/inc/simple_html_dom.php';

/*--------------------------------------------------------------
>>> //crea la acciones para meter y salvar cuando le doy postear remates btn (post nuevos)
----------------------------------------------------------------*/

$id;
$publicacion;
$precio;
$precioShort;
$moneda;
$tipo_De_Remate;
$rematante;
$rematado;
$juzgado;
$expediente;  
$fechadelRemate;
$gravamen;
$fechadelRemateNumeral;
$horaRemate;

//Casa  //Lote
$matricula;
$derecho;
$distrito;
$canton;
$provincia;
$plano;
$mide;

//Vehiculo
$marca;
$categoria;
$carrocería;
$capacidad;

  function makeRemates($array){
   
    
    $buscar = $array[9];

    echo 'Buscar ---------'.$buscar.'<br>';
    echo '---------------------------'.'<br>';
   

    //finca vehículo  categoría: motocicleta automóvil carga liviana microbús embarcación 
    $vehiculo = false;
    $propieda = false;

    //busco vehiculo si lo encuentra lo pongo true
    if (stripos($buscar, 'vehiculo') !== false) {
      $vehiculo = true;
    echo 'xxxxxxxxxxxxx VEhiculo <br>';
    }
    //busco finca si lo encuentra lo pongo true
    if (stripos($buscar, 'finca') !== false) {
      $propieda = true;
      echo 'xxxxxxxxxxxxx propieda <br>';
    }


    $str = "/(con una base de |capacidad|marca|categoria|serie|fabricacion|color| combustible|soportando gravamenes|libre de gravamenes y anotaciones|libre de gravamenes prendarios|placas|ano|de no haber postores|se senalan|publicacion| .—)/";
  
   

    if($vehiculo)
    {
      $remateArray = preg_split($str, $buscar, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
      foreach ($remateArray as $key => $item)
      {
        //limpio lo que no sirve
        if (strlen($item) < 10) {
        unset($remateArray[$key]);
        }
        //Saco precio
        if (stripos($item, 'no haber postores') !== false) {
          $item =  $item[0];
          $item =  str_replace(', n°','', $item);
          }

        echo $item.' '.$key.'<br>';

        //Saco precio
        if (stripos($item, 'con una base de') !== false) {
        $precio =  $remateArray[$key+1];
        }

        //gravamenes
        if (stripos($item, 'gravamenes') !== false || stripos($item, 'gravamen') !== false || stripos($item, 'anotaciones') !== false) {
        $gravamen =  $item;
        }

        //Saco estilo
        if (stripos($item, 'estilo') !== false) {
        $estilo = preg_split('/categoria: /i', $item, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $estilo   =  $estilo[0];
        }

        //Saco categoria
        if (stripos($item, 'categoria') !== false) {
        $categoria   =  $remateArray[$key+1];
        }

        //Saco combustible:
        if (stripos($item, 'combustible') !== false) {
        $combustible =  str_replace('. para tal efecto, ','', $remateArray[$key+1]);
        $combustible   =  $combustible;
        }

        //Saco combustible:
        if (stripos($item, 'capacidad') !== false) {
        $capacidad = preg_split('/. /i', $remateArray[$key+1], 0);
        $capacidad   =  $remateArray[$key+1];
        }
       

        //Saco carroceria
        if (stripos($item, 'carroceria') !== false) {
        $carroceria = preg_split('/ para tal efecto /i', $item, 0);
        $carroceria   =  $carroceria[0];
        }
        //Saco placas 
        if (stripos($item, 'placas') !== false || stripos($item, 'placa') !== false) {
        $placa   =  $remateArray[$key+1];
        }

        //Saco color 
        if (stripos($item, 'color') !== false) {
        $color   =  $remateArray[$key+1];
        }
        //Saco serie 
        if (stripos($item, 'serie') !== false) {
        $serie   =  $remateArray[$key+1];
        }
        //Saco ano fabricacion: 
        if (stripos($item, 'fabricacion') !== false || stripos($item, 'ano') !== false) {
        $ano   =  $remateArray[$key+1];
        }

        //Saco marca
        if (stripos($item, 'marca') !== false) {
        $marca = preg_split('/para tal efecto/i', $remateArray[$key+1], 0);
        $marca   =  $marca[0];
        }
        //Saco fecha
        if (stripos($item, 'se senalan') !== false) {
        $fecha = preg_split('/con la base/i', $remateArray[$key+1], 0);
        $fecha = $fecha[0];
        }

        if (stripos($item, 'publicacion') !== false) {
          $publicacion = $remateArray[$key+1];
          }
        
      } 
      //Imprimo carecteristicas vehiculo
      echo '<br>'.
      '<br> <b>Price: </b>'.$precio.
      '<br><b>gravamen: </b>'.$gravamen.
      '<br><b>categoria: </b>'.$categoria,
      '<br><b>marca: </b>'.$marca,
      '<br><b>placa: </b>'.$placa,
      '<br><b>año: </b>'.$ano.
      '<br><b>estilo: </b>'.$estilo.
      '<br><b>combustible: </b>'.$combustible.
      '<br><b>caracteristicas: </b>'.$serie.' '.$color. ''.$capacidad.
      '<br><b>fecha: </b>'.$fecha.
      '<br><b>publicacion: </b>'.$publicacion.
      '<br>---------<br>';
     }


     $strPropiedad1 = "/(de no haber postores, |.—)/";
     $strPropiedad2 = "/(con una base de | libre de gravamenes | saquese a remate|matricula numero |derecho | la cual es | situada en el distrito | canton | de la provincia de | colinda |mide| plano | identificador predial | para tal efecto, se senalan |de no haber postores|notas| ejecucion hipotecaria de |contra |canton|colinda|publiquese este edicto |soportando gravamenes| la cual es terreno|expediente|juzgado |publicacion|terreno| .—)/";
     
     if($propieda)
     {
       $remateArray = preg_split($strPropiedad1, $buscar, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
 

      $remateArray = preg_split($strPropiedad2, $buscar, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
       
       foreach ($remateArray as $key => $item)
       {
       
         if (stripos($item, 'segundo remate ') !== false) {
            unset($item);
          }
          //echo $key.' '.$item.'<br>';

         //Saco segundo remate
         if (stripos($item, 'con una base de') !== false) {
          $precio =  $remateArray[$key+1];
         //$precio =  str_replace(', libre de','', $precio);
         }

        //Saco segundo remate
        if (stripos($item, 'gravamenes') !== false) {
        $gravamenes1 =  $item;
        $gravamenes2 =  $remateArray[$key+1];
        //$precio =  str_replace(', libre de','', $precio);
        }
        //Saco segundo matricula
        if (stripos($item, 'matricula numero') !== false) {
        $matricula =  $remateArray[$key+1];
        }

        //Saco segundo derecho 
        if (stripos($item, 'derecho ') !== false) {
        $derecho  =  $remateArray[$key+1];
        }  
       

        //Saco provincia 
        if (stripos($item, 'provincia de') !== false) {
        $provincia  =  $remateArray[$key+1];
        $provincia = preg_split('/. colinda:/i', $provincia, 0);
        $provincia = $provincia[0];
        }  
        
         //Saco segundo distrito 
        if (stripos($item, 'distrito') !== false) {
        $distrito  =  $remateArray[$key+1];
        }  
         //Saco segundo canton 
        if (stripos($item, 'canton') !== false) {
        $canton  =  $remateArray[$key+1];
        }  
         //Saco segundo colinda: 
        if (stripos($item, 'colinda') !== false) {
        $colinda  =  $remateArray[$key+1];
        }  
         //Saco segundo mide:  
        if (stripos($item, 'mide') !== false) {
        $mide  =  $remateArray[$key+1];
        }  
         //Saco segundo plano: 
        if (stripos($item, 'plano') !== false) {
        $plano  =  $remateArray[$key+1];
        }  
         //Saco segundo hora:  
        if (stripos($item, 'senalan') !== false) {
        $horaRemate  =  $remateArray[$key+1];
        }  

        //Saco segundo terreno 
        if (stripos($item, 'terreno') !== false) {
        $terreno  =  $remateArray[$key+1];
        }  

        //Saco segundo notas:  
        if (stripos($item, 'notas') !== false) {
        $notas  =  $remateArray[$key+1];
        }  
        //Saco segundo notas:  
        if (stripos($item, 'ejecucion') !== false) {
        $ejecuta  =  $remateArray[$key+1];
        }  
        //Saco segundo notas:  
        if (stripos($item, 'contra ') !== false) {
        $contra   =  $remateArray[$key+1];
        }  
        //Saco segundo expediente:  
        if (stripos($item, 'expediente') !== false) {
        $expediente   =  $remateArray[$key+1];
        }  
        //Saco segundo juzgado :  
        if (stripos($item, 'juzgado ') !== false) {
        $juzgado    =  $remateArray[$key+1];
        }  
        //Saco segundo publicacion: :  
        if (stripos($item, 'publicacion') !== false) {
        $publicacion    =  $remateArray[$key+1];
        }  
       } 
       //Imprimo carecteristicas vehiculo
       echo '<br>'.
       '<br> <b>Price: </b>'.$precio.
       '<br><b>gravamen: </b>'.$gravamenes1.' '.$gravamenes2.
       '<br><b>matricula: </b>'.$matricula.' derecho:'.$derecho,
       '<br><b>provincia: </b>'.$provincia,
       '<br><b>distrito: </b>'.$distrito,
       '<br><b>provincia: </b>'.$canton,
       '<br><b>$mide: </b>'.$mide,
       '<br><b>$colinda: </b>'.$colinda,
       '<br><b>$plano: </b>'.$plano,
       '<br><b>$horaRemate: </b>'.$horaRemate,
       '<br><b>terreno: </b>'.$terreno,
       '<br><b>expediente: </b>'.$expediente,
       '<br><b>$ejecuta : </b>'.$ejecuta,
       '<br><b>$contra : </b>'.$contra,
       '<br><b>juzgado : </b>'.$juzgado,
       '<br><b>publicacion : </b>'.$publicacion,
       '<br><b>notas: </b>'.$notas,
       '<br>---------<br>';
      }


    }
    
    
 

    
    
    
    
     $remates = array(
    
      // array(
        //    "id"  => "",
      //     "name" => "Peter Parker",
      //     "email" => "peterparker@mail.com",
      // ),
   
  );

 



function sample_admin_notice__success($post) {

  $post = get_post();
  $postid = $post->ID;

  if ($postid===3331) {
    $date               = get_field( "fecha");
    $loaded_Acf        = get_field( "load_pdf");
    $loaded_Acf_leng   = strlen($loaded_Acf);
    //Check date if is full get data from imprentanacional
    checkDateAndGetData($date, $loaded_Acf_leng);

    }
}
add_action( 'admin_notices', 'sample_admin_notice__success' );



function checkDateAndGetData($date, $loaded_Acf_leng){

    if(strlen($date) > 0){
          //1  get DOM from URL or file
          $url = 'https://www.imprentanacional.go.cr/boletin/?date='.$date;
          scraping_generic($url, $search);
    }

    // no hay data buscar cuando carga
    if($loaded_Acf_leng === 0){
      mensaje('no hay data checkiar si ya llego');
    }
    //

}





function quitar_tildes($cadena) {
  $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
  $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
  $texto = str_replace($no_permitidas, $permitidas ,$cadena);
  return $texto;
  }




// -----------------------------------------------------------------------------
// scraping Saving
function scraping_generic($url, $search) {
	// Didn't find it yet.
	$return = false;

      // create HTML DOM
       $html = file_get_html($url);
       //echo "reading the url: " . $url . "<br/>";
	    //echo "url has been read.<br/>";

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
        $myHtml =  $e1->outertext;
      
      
     
      //Buscar Titulo y numero de boletin
      $titlePos = strpos($myHtml, 'BOLETÍN JUDICIAL N°');
      $boletinNumber = substr($myHtml, $titlePos+22, 3); //busca el numero de boletin
      //pone un mensaje en wp
      mensaje('<a target="_blank" href="'.$url .'">reading the boletin: '. $url .'</a> boletin:'. $boletinNumber);




      // //busco los titulos
      $rematesNoTildes  = quitar_tildes($myHtml);
      $rematesSmall     = strtolower($rematesNoTildes);

  
      /*********** BUSCO LOS H2 ***********/
      $blocks = preg_split("/(?=<h2>)/is", $rematesSmall);
      $count = count($blocks);

      for ($i = 0; $i < $count; $i++) {
        //Le quieto el html
        $contentBlock[$i] = strip_tags($blocks[$i]);
        //si tiene la palabra remate imprima o meta lo en variable
          
          if (stripos($contentBlock[$i], 'Remates') !== false) {
            $remates = $blocks[$i];
          }
      }

      //Esto me va ayudatar con el titulo porque une la palabra primera publicacionxxx
      //y solo en el titulo no en los remates asi si puedo separarlos despues
      $remates = str_replace(['<p>', '</p>'], 'xxxx', $remates);
      
      //le quito espacios dobles y remates texto
      $remates = str_replace("  "," ", $remates);
      $remates = str_replace("remates","", $remates);
      
      //cambio los titulos para separarlos por bloques despues
    
      $remates = preg_replace('/<span[^>]+\>/i', '', $remates);
      $remates = preg_replace('/class=".*?"/', '', $remates);
      $remates = preg_replace('/style=".*?"/', '', $remates);
      $remates = strip_tags($remates, '<p>');
      $remates = str_replace("segunda publicacionxxxx","<b>2publicacion</b>", $remates);
      $remates = str_replace("primera publicacionxxxx","<b>1publicacion</b>", $remates);
      
      
      //*** Tube que hacer el split asi porque (split o explote) ala hora de salvar
      //los valores salian corados y no pude saber porque
      // split remates cuando encuentre 1publicacion dentro de remates
    
      $segunda_public = preg_split('/1publicacion/i', $remates, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
      //asigno el primerBlocke = segundapubli *Leer arriba razon
      unset($segunda_public[1]);

      $primera_public = str_split($remates, stripos($remates,"1publicacion"));
      //asigno el segBlocke = Primera publi *Leer arriba razon
      unset($primera_public[0]);

      

      //pongo que tipo de publicacion es y xxxx para hacer el split
        $segunda_public = str_replace("xxxx","publicacion: segunda rrrr", $segunda_public);
        // //implote une el array
        $segunda_public = implode("rrrr", $segunda_public);

       $primera_public = str_replace("xxxx","publicacion: primera rrrr", $primera_public);
       $primera_public = implode("rrrr", $primera_public);

     

      //uno los dos datos
       $str_toSave = $segunda_public.$primera_public;
       $str_toSave = str_replace("2publicacion","", $str_toSave);
       $str_toSave = str_replace("1publicacion","", $str_toSave);
        //este $str_toSave se salva abajo en un acf
   
       //var_dump($str_toSave);

      //2 /////////////////////////////////
      //si ya salvo la data carguela
      if(!$loaded_Acf){
        $blockRemates = htmlspecialchars_decode(get_field('load_pdf'));
      }


     $blockRemates = explode('rrrr', $blockRemates);
     makeRemates($blockRemates);
     echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
     //var_dump($blockRemates);
    

      /*********** BUSCO LOS P de segunda publicacion ***********/
       



        ?>

        <script>
          // jQuery(document).ready(function($) {

          //   console.log('blockRaw');
          //   //Meto el html que viene de remates en  Json
          //   let myHtml = <?php echo json_encode($html2); ?>;
          //   //console.log(myHtml); 
          //   console.log('blockRaw2xxxx');
          //   // console.log(blockRaw);
          //   //jQuery("h2").css("background-color","red");
          // });
        </script>
       <?php
      //TRIBUNALES DE TRABAJO termina con Títulos supletorios




      ///////////////busco boletines anteriores y actualizo
        $boletinesMetidos   = get_field( "boletinesMetidos");
        //combierte los boletines en array
        $boletines = explode(",", $boletinesMetidos);

        //checkeo si existe boletin
        if (in_array($boletinNumber, $boletines)) {
          ///---existe no postee mas
           // Update ACF load_pdf var with new value.
            mensaje(' --- si existe  data cargada para postiar');
        }else{
          mensaje('---no existe'.$boletines);
            //actualizo numero de boletin ACF
          update_field( 'load_pdf', $str_toSave );
          update_field( 'numero_boletin', $boletinNumber );
          update_field( 'boletinesMetidos', $boletinesMetidos.','. $boletinNumber );
        }
      
        // $segundaPublicacion
        // $seprimeraPublicacion
        mensaje('---necesito limpiar load pdf apenas pueda . quitar cada vez que hago upda por el momento');

      // clean up memory
      $html_base->clear();
      unset($html_base);
      //echo '//////////  Saved   /////////////////';
      return;
      }



  

function mensaje($msn){
  ?>
  <div class="notice notice-success is-dismissible">
      <p><?php _e($msn , 'sample-text-domain' ); ?></p>
  </div>
<?php
}

/*--------------------------------------------------------------
>>> //crea la acciones para meter y salvar cuando le doy postear remates btn (post nuevos)
----------------------------------------------------------------*/

add_action('template_redirect', function() {
   
   global $post;
   $postType = $post->post_type;

    if($postType === 'rematesettings'){
      require  $GLOBALS['themePath'].'/inc/functions/CPT_Field_remates.php';
    }
 
 
 });




  ?>