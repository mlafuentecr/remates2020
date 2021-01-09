<?php
if (  is_admin() ) {
  require  $GLOBALS['themePath'].'/inc/functions/CPT_Utilities.php';
  require  $GLOBALS['themePath'].'/inc/simple_html_dom.php';
  date_default_timezone_set('America/Costa_Rica');
}

require  $GLOBALS['themePath'].'/inc/CTP_ReviewRemates.php';
/*--------------------------------------------------------------
>>> //crea la acciones para meter y salvar cuando le doy postear remates btn (post nuevos)
----------------------------------------------------------------*/


  function makeRemates($array){

    //ACF
    $boletingId             = get_field('numero_boletin');
    $RemateSettings_group   = get_field("btns", $GLOBALS['rematesPg']);  
    $postRemates           = $RemateSettings_group['mostrar_o_postear']; 
    $verDetalles           = $RemateSettings_group['ver_detalles']; 
 


      //foreach ($array as $key => $value) {
       //$itemFull = $array[$key];

       $key = 50;
       $itemFull = $array[$key];
       $rematID = $boletingId.'_'.date("y").'_'.$key;

      //finca vehículo  categoría: motocicleta automóvil carga liviana microbús embarcación 
      $vehiculo = false;
      $propieda = false;

      //busco vehiculo si lo encuentra lo pongo true
      if (stripos($itemFull, 'vehiculo') !== false) {
        $vehiculo = true;
        $tipoDeRemate = 'vehiculo';
        echo 'xxxxxxxxxxxxx VEhiculo <br>';
      }
      //busco finca si lo encuentra lo pongo true
      if (stripos($itemFull, 'finca') !== false) {
        $propieda = true;
        $tipoDeRemate = 'propiedad';
        echo 'xxxxxxxxxxxxx propieda <br>';
      }






    $str = "/(con una base de |capacidad|marca|categoria|serie|fabricacion|color|matricula numero|derecho|combustible|soportando gravamenes|libre de gravamenes y anotaciones|notas|libre de gravamenes prendarios|placas|ano|de no haber postores|se senalan|publicacion|contra|expediente|ejecucion|juzgado| .—)/";

    if($vehiculo)
    {
      $remateArray = preg_split($str, $itemFull, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
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

   

          //Saco moneda
          if (stripos($item, 'colones') !== false) {
          $moneda =  'colones ';
          }
        if (stripos($item, 'dolares') !== false) {
          $moneda =  'dolares ';
          }

            
        //Saco precio
        if (stripos($item, 'con una base de') !== false) {
          $precio =  $remateArray[$key+1];

          if (stripos($precio, 'exactos') !== false) {
            $precio =  str_replace('exactos','', $precio);
          }
          if (stripos($precio, 'colones ') !== false) {
            $precio =  str_replace('colones ','', $precio);
          }
          if (stripos($precio, 'centavos') !== false) {
            $precio =  str_replace('centavos ','', $precio);
          }
          if (stripos($precio, 'dolares') !== false) {
            $precio =  str_replace('dolares ','', $precio);
          }

        }

     

        //Saco segundo remate
        if (stripos($item, 'gravamenes') !== false) {
          $gravamenes1 =  $item;
          $gravamenes2 =  $remateArray[$key+1];
          //
          }

        //Saco estilo
        if (stripos($item, 'estilo') !== false) {
        $estilo = preg_split('/categoria: /i', $item, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $estilo   =  $estilo[0];
        }

        //Saco categoria
        if (stripos($item, 'categoria') !== false) {
        $categoria   =  $remateArray[$key+1];
        }elseif (stripos($item, 'motocicleta') !== false) {
        $tipoDeRemate = 'motocicleta';
        }elseif(stripos($item, 'embarcacion') !== false) {
          $tipoDeRemate = 'embarcacion';
        }else {
          $tipoDeRemate = 'vehiculo';
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

     
        //Saco segundo notas:  
        if (stripos($item, 'notas') !== false) {
          $notas  =  $remateArray[$key+1];
          }  
          //Saco segundo notas:  
          if (stripos($item, 'ejecucion') !== false) {
          $ejecuta  =  $remateArray[$key+1];
          }  
          //Saco segundo notas:  
          if (stripos($item, 'contra') !== false) {
          $contra   =  $remateArray[$key+1];
          }  
  
          //Saco segundo juzgado :  
          if (stripos($item, 'juzgado') !== false) {
          $juzgado    =  $remateArray[$key+1];
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
        if (stripos($item, 'se senalan') !== false) 
        {
          $fecha = preg_split('/con la base/i', $remateArray[$key+1], 0);
          $fecha = $fecha[0];
          $fechadelTextual = $fecha; 

          //Devuelve array con todo des de CPT_Utilities ano, mes , dia, hora
          $fechadelNumeral = arreglarFecha($fecha);
          $hora = $fechadelNumeral['hora'];

          ////////////////Numeral
          $fechadelNumeral = $fechadelNumeral['dia'].'-'. $fechadelNumeral['mes'].'-'.$fechadelNumeral['ano'];

        }

        if (stripos($item, 'publicacion') !== false) {
          $publicacion = $remateArray[$key+1];
          }
        //Saco segundo expediente:  
        if (stripos($item, 'expediente') !== false) {
        $expediente   =  $remateArray[$key+1];
        }

      
     
      } 
     
    
      $value = array(
        'numero_boletin'        => $boletingId,
        'remateidnumber'        => $rematID,
        'fechadelTextual'        => $fechadelTextual,
        'fechadelNumeral'        => $fechadelNumeral,
        'hora'                  => $hora,
        'gravamenes'            => $gravamenes1.' '.$gravamenes2,
        'tipo_de_remate'        => $tipoDeRemate,
        'categoria'             => $categoria,
        'precio'                => $precio,
        'precio_numeral'        => wordsToNumber(' '.$precio),
        'moneda'                => $moneda,
        'marca'                 => $marca,
        'placa'                 => $placa,
        'ano'                   => $ano,
        'estilo'                => $estilo,
        'combustible'           => $combustible,
        'caracteristicas'       => $serie.' '.$color. ''.$capacidad,
        'rematante'             => $ejecuta,
        'rematado'              => $contra,
        'juzgado'               => $juzgado,
        'expediente'            => $expediente,
        'notas'                 => $notas,
        'remateDetalle'         => $item,
        'publicacion'           => $publicacion,
    );
      //Imprimo carecteristicas vehiculo
      // echo '<br>'.
      // '<br> <b> $boletingId </b>'. $boletingId.
      // '<br> <b>post ID: </b>'.$rematID.
      // '<br> <b>Price: </b>'.$precio.
      // '<br><b>gravamen: </b>'.$gravamenes1.' '.$gravamenes2.
      // '<br><b>$horaRemate: </b>'.$horaRemate,
      // '<br><b>$ejecuta : </b>'.$ejecuta,
      // '<br><b>$contra : </b>'.$contra,
      // '<br><b>juzgado : </b>'.$juzgado,
      // '<br><b>publicacion : </b>'.$publicacion,
      // '<br><b>expediente: </b>'.$expediente,
      // '<br><b>notas: </b>'.$notas,

   
      // '<br><b>tipoDeRemate: </b>'.$tipoDeRemate,
      // '<br><b>categoria: </b>'.$categoria,
      // '<br><b>marca: </b>'.$marca,
      // '<br><b>placa: </b>'.$placa,
      // '<br><b>año: </b>'.$ano.
      // '<br><b>estilo: </b>'.$estilo.
      // '<br><b>combustible: </b>'.$combustible.
      // '<br><b>caracteristicas: </b>'.$serie.' '.$color. ''.$capacidad.
      // '<br>---------<br>';
     }





    

     $strPropiedad1 = "/(segundo remate|.—)/";
     $strPropiedad2 = "/(con la base de|con una base de|libre de gravamenes|saquese a remate|matricula numero|derecho|la cual es|situada en el distrito|canton|de la provincia de|colinda|mide|plano|identificador predial|para tal efecto, se senalan|notas|ejecucion hipotecaria de|contra|canton|colinda|publiquese este edicto|soportando gravamenes|la cual es terreno|expediente|juzgado|publicacion|terreno|en el mejor postor| .—)/";
     
     if($propieda)
     {
     
          
       $remateArraySplit = preg_split($strPropiedad1, $itemFull, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
       foreach ($remateArraySplit as $key0 => $item0)
       {
         if($key0 !== 0){
          unset($remateArraySplit[$key0]);
         }
       }

       $remateArraySplit1 = preg_split($strPropiedad2, $remateArraySplit[0], 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

      $remateArrayFull = preg_split($strPropiedad2, $itemFull, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
       

     
      foreach ($remateArraySplit1 as $key1 => $item1)
      {
          echo $item1.'<br>';
            //Saco moneda
            if (stripos($item1, 'colones') !== false) {
            $moneda =  'colones ';
            }
          if (stripos($item1, 'dolares') !== false) {
            $moneda =  'dolares ';
            }
                   //Saco precio  
          if (stripos($item1, 'con una base') !== false || stripos($item1, 'con la base de') !== false) {
            echo '------<br>';
            var_dump($remateArraySplit1);
            echo '------<br>';
            $precio =  $remateArraySplit1[$key1+1];

            if (stripos($precio, 'exactos') !== false) {
              $precio =  str_replace('exactos','', $precio);
            }
            if (stripos($precio, 'colones ') !== false) {
              $precio =  str_replace('colones ','', $precio);
            }
            if (stripos($precio, 'centavos') !== false) {
              $precio =  str_replace('centavos ','', $precio);
            }
            if (stripos($precio, 'dolares') !== false) {
              $precio =  str_replace('dolares ','', $precio);
            }

          }


            //Saco segundo hora:  
        if (stripos($item1, 'senalan') !== false) {
          $horaRemate  =  $remateArraySplit1[$key+1];
          }elseif(stripos($item1, 'minutos') !== false) {
            $horaRemate = preg_split('/;/i', $item1, 0);
            if (stripos($horaRemate[0], 'minutos') !== false) {
              $horaRemate  =  $horaRemate[0];
            }elseif(stripos($horaRemate[1], 'minutos') !== false){
              $horaRemate  =  $horaRemate[1];
            }else{
              $horaRemate  =  $horaRemate[2];
            }
            
          }
      }


       foreach ($remateArrayFull as $key => $item)
       {
        
   

        //Saco segundo remate
        if (stripos($item, 'gravamenes') !== false) {
        $gravamenes1 =  $item;
        $gravamenes2 =  $remateArray[$key+1];
        //$precio =  str_replace(', libre de','', $precio);
        }
        //Saco segundo matricula
        if (stripos($item, 'matricula numero') !== false) {
        $matricula =  $remateArrayFull[$key+1];
        }

        //Saco segundo derecho 
        if (stripos($item, 'derecho') !== false) {
        $derecho  =  $remateArrayFull[$key+1];
        }  
       

        //Saco provincia 
        if (stripos($item, 'provincia de') !== false) {
       

          if (stripos($item, 'linderos') !== false) {
            $provincia = preg_split('/linderos/i', $provincia, 0);
            $provincia = $provincia[0];
          }else{
            echo '----------<br>';
            $provincia  =  $remateArrayFull[$key+1];
            echo '----------'.$provincia;
            echo '----------<br>';
          }

       
        }  
        
         //Saco segundo distrito 
        if (stripos($item, 'distrito') !== false) {
        $distrito  =  $remateArrayFull[$key+1];
        }  
         //Saco segundo canton 
        if (stripos($item, 'canton') !== false) {
        $canton  =  $remateArrayFull[$key+1];
        }  
         //Saco segundo colinda: 
        if (stripos($item, 'colinda') !== false) {
        $colinda  =  $remateArrayFull[$key+1];
        }  
         //Saco segundo mide:  
        if (stripos($item, 'mide') !== false) {
        $mide  =  $remateArrayFull[$key+1];

        if (stripos($mide, '.') !== false) {
          $mide = preg_split('/\. /i', $mide, 0);
          $mide = $mide[0];
        }

        }  
         //Saco segundo plano: 
        if (stripos($item, 'plano') !== false) {
        $plano  =  $remateArrayFull[$key+1];
        }  
       
        //Saco segundo terreno 
        if (stripos($item, 'terreno') !== false) {
        $terreno  =  $remateArrayFull[$key+1];
        }  

        //Saco segundo notas:  
        if (stripos($item, 'notas') !== false) {
        $notas  =  $remateArrayFull[$key+1];
        }  
        //Saco segundo notas:  
        if (stripos($item, 'ejecucion') !== false) {
        $ejecuta  =  $remateArrayFull[$key+1];
        }  
        //Saco segundo notas:  
        if (stripos($item, 'contra') !== false) {
        $contra   =  $remateArrayFull[$key+1];
        }  

        //Saco segundo juzgado :  
        if (stripos($item, 'juzgado') !== false) {
        $juzgado    =  $remateArrayFull[$key+1];
        } 
        //Saco segundo expediente:  
        if (stripos($item, 'expediente') !== false) {
          $expediente   =  $remateArrayFull[$key+1];
          }   
        //Saco segundo publicacion: :  
        if (stripos($item, 'publicacion') !== false) {
        $publicacion    =  $remateArrayFull[$key+1];
        }  
       } 


       $value = array(
        'numero_boletin'        => $boletingId,
        'remateidnumber'        => $rematID,
        'precio'                => $precio,
        'precio_numeral'        => wordsToNumber(' '.$precio),
        'fechadelTextual'        => $fechadelTextual,
        'fechadelNumeral'        => $fechadelNumeral,
        'hora'                   => $hora,
        'matricula'              => $matricula,
        'derecho'                => $derecho,
        'expediente'             => $expediente,
        'canton'                 => $canton,
        'provincia'              => $provincia,
        'distrito'               => $distrito,
        'mide'                   => $mide,
        'colinda'                => $colinda,
        'plano'                  => $plano,
        'terreno'                => $terreno,
        'gravamenes'            => $gravamenes1.' '.$gravamenes2,
        'tipo_de_remate'        => $tipoDeRemate,
        'moneda'                => $moneda,
        'rematante'             => $ejecuta,
        'rematado'              => $contra,
        'juzgado'               => $juzgado,
        'expediente'            => $expediente,
        'notas'                 => $notas,
        'remateDetalle'         => $item,
        'publicacion'           => $publicacion,
    );


       //Imprimo carecteristicas propiedad
       echo '<br>'.
       '<br> <b>post ID: </b>'.$rematID.
       '<br> <b>Price: </b>'.$precio.
       'tipo_de_remate'        .'propiedad',
       '<br><b>gravamen: </b>'.$gravamenes1.' '.$gravamenes2.
       '<br><b>matricula: </b>'.$matricula.' derecho:'.$derecho,
       '<br><b>$horaRemate: </b>'.$horaRemate,
       '<br><b>$ejecuta : </b>'.$ejecuta,
       '<br><b>$contra : </b>'.$contra,
       '<br><b>juzgado : </b>'.$juzgado,
       '<br><b>publicacion : </b>'.$publicacion,
       '<br><b>expediente: </b>'.$expediente,
       '<br><b>notas: </b>'.$notas,
       
       '<br><b>provincia: </b>'.$provincia,
       '<br><b>distrito: </b>'.$distrito,
       '<br><b>canton: </b>'.$canton,
       '<br><b>$mide: </b>'.$mide,
       '<br><b>$colinda: </b>'.$colinda,
       '<br><b>$plano: </b>'.$plano,
       '<br><b>terreno: </b>'.$terreno,
       '<br>---------<br>';
      }

     // }




        //Creo post
        if($postRemates){
         echo '**************************** insertPost';
          insertPost($value, $tags);
         }else{
          //crea boxes para visualisar
          reviewRemates($value);
         }

    }
    
    
 

    
    
 



function sample_admin_notice__success($post) {

  $post = get_post();
  $postid = $post->ID;

  if ($postid===3331) {
    $date              = get_field( "fecha");
    $loaded_Acf        = get_field( "load_pdf");
    $loaded_Acf_leng   = strlen($loaded_Acf);
    //Check date if is full get data from imprentanacional
    checkDateAndGetData($date, $loaded_Acf_leng);

    }
}
add_action( 'admin_notices', 'sample_admin_notice__success' );





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


  
 function insertPost($value, $tags){

   // MARIO SACAR SI ES VEHICULO O SI ES PROPIEDAD TIENEN CARACTERISCAS DIFEREMTE
  $postTitle = $value['remateidnumber'];
  $post_title = sanitize_title( $postTitle );

    // unhook this function so it doesn't loop infinitely
    remove_action('save_post', 'insertPost');


    if( $value['remateidnumber'] != '' ){

        // Inserto un post y despues actualiso datos
        $post_id = array( 
        'post_parent'   => 1,
        'post_title'    =>  $value['remateidnumber'],
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_category' => 1,
        'tags_input'    => $tags,
        );


        ////ACTUALIZO LOS ACF 
        if( post_exists( $post_title ) ){
        echo '<br>si existe! pueden estar en trash '.$post_title;
        var_dump($post_id);
        }else{
        echo 'no existe. postiando... '.$post_title.'<br>';
        $postID = wp_insert_post( $post_id );  //como no exite lo inserto
        update_field('postgroup', $value, $postID);
        }


    }else{
      echo ('there is not ids'); 
    }

    // re-hook this function
    add_action('save_post', 'insertPost');

}


  ?>