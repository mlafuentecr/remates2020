<?php


function currencySymbol($moneda){
  if ( $moneda !== 'colones') {
      $moneda1 = '$';
  } else {
      $moneda1 = '₡';
  }
  return $moneda1;
}


function reviewRemates($value)
{
  echo '<br>xxxxxxxxxxxxxxxxxxx ME FALTA METER PROPIEDADES ACA Y REVISAR Y METER POST '.$value['tipo_de_remate'];
  echo '-----------------reviewRemates';
  //$value["numero_boletin"]
    ?>
<div class="card mb-4 col-md-6 shadow-sm">

  <div class="card-header  casasItem">
  <?php
  
if ($value['tipo_de_remate'] === 'propiedad') {
        echo '<i class="fa fa-home fa-4x"></i>';
    }

    if ($value['tipo_de_remate'] === 'vehiculo') {
        echo '<i class="fa fa-car fa-4x" aria-hidden="true"></i>';
    }

    if ($value['tipo_de_remate'] === 'motocicleta') {
        echo '<i class="fa fa-motorcycle fa-4x" aria-hidden="true"></i>';
    }
   

    if ($value['tipo_de_remate'] === 'embarcacion') {
        echo '<i class="fa fa-ship fa-4x" aria-hidden="true"></i>';
    }

    ?>





  








<div class="card-body ">
<div class="divTable remate">
<div class="divTableBody">
<div class="divTableRow">

<?php if ($value['tipo_de_remate'] !== 'propiedad') {?>
  <div class="divTableCell Value">
  <?php
        echo '<b>Id: </b> '. $value['remateidnumber'];
        echo ' <b>publicacion: </b> '. $value['publicacion'];
        echo '<b>tipo : </b>'. $value['tipo_de_remate']; 

        echo '<hr>'; 
        //<!-- precio  -->
        echo '<br><b>precio REAL: </b>'. $value['precio'];
        echo '<br><b>Precio redondeado: </b> ';
        echo  currencySymbol($value['moneda'])  . $value['precio_numeral'];
        
        echo '<br><b>categoria: </b>'. $value['categoria'];
        if($value['estilo']){echo '<br><b>estilo: </b>'. $value['estilo'];}; 
        if($value['marca']){echo '<br><b>marca: </b>'. $value['marca'];}; 
        if($value['placa']){echo '<br><b>placa: </b>'. $value['placa'];}; 
        if($value['combustible']){echo '<br><b>combustible: </b>'. $value['combustible'];}; 
        if($value['caracteristicas']){echo '<br><b>caracteristicas: </b>'. $value['caracteristicas'];};
        echo '<hr>'; 
        //Date
        echo '<br><b>Fecha N: </b>'. $value['fechadelNumeral']; 
        echo '<br><b>Fecha: </b>'. $value['fechadelTextual']; 
        echo '<br><b>hora: </b>'. $value['hora']; 
        echo '<hr>'; 
        if($value['rematante']){echo '<br><b>rematante: </b>'. $value['rematante'];}; 
        if($value['rematado']){echo '<br><b>rematado: </b>'. $value['rematado'];}; 
        if($value['juzgado']){echo '<br><b>juzgado: </b>'. $value['juzgado'];}; 
        if($value['expediente']){echo '<br><b>expediente: </b>'. $value['expediente'];}; 
        echo '<hr>'; 
        if($value['notas']){echo '<br><b>notas: </b>'. $value['notas'];}; 
        echo '<hr>'; 
  ?>
  </div>
<?php } else{?>

  <div class="divTableCell Value">
  <?php
        echo '<b>Id: </b> '. $value['remateidnumber'];
        echo ' <b>publicacion: </b> '. $value['publicacion'];
        echo '<b>tipo : </b>'. $value['tipo_de_remate']; 

        echo '<hr>'; 
        //<!-- precio  -->
        echo '<br><b>precio REAL: </b>'. $value['precio'];
        echo '<br><b>Precio redondeado: </b> ';
        echo  currencySymbol($value['moneda'])  . $value['precio_numeral'];
        
        echo '<br><b>categoria: </b>'. $value['categoria'];
        if($value['estilo']){echo '<br><b>estilo: </b>'. $value['estilo'];}; 
        if($value['marca']){echo '<br><b>marca: </b>'. $value['marca'];}; 
        if($value['placa']){echo '<br><b>placa: </b>'. $value['placa'];}; 
        if($value['combustible']){echo '<br><b>combustible: </b>'. $value['combustible'];}; 
        if($value['caracteristicas']){echo '<br><b>caracteristicas: </b>'. $value['caracteristicas'];};
        echo '<hr>'; 
        //Date
        echo '<br><b>Fecha N: </b>'. $value['fechadelNumeral']; 
        echo '<br><b>Fecha: </b>'. $value['fechadelTextual']; 
        echo '<br><b>hora: </b>'. $value['hora']; 
        echo '<hr>'; 
        if($value['rematante']){echo '<br><b>rematante: </b>'. $value['rematante'];}; 
        if($value['rematado']){echo '<br><b>rematado: </b>'. $value['rematado'];}; 
        if($value['juzgado']){echo '<br><b>juzgado: </b>'. $value['juzgado'];}; 
        if($value['expediente']){echo '<br><b>expediente: </b>'. $value['expediente'];}; 
        echo '<hr>'; 
        if($value['notas']){echo '<br><b>notas: </b>'. $value['notas'];}; 
        echo '<hr>'; 
  ?>
  </div>
  <?php }?>
</div>
</div>
</div>

        <button type="button" class="btn btn-lg btn-block btn-outline-primary">Leer mas</button>
        <?php print_r($value['remateDetalleTest']);?>
      </div>
  </div><!--card-->

<?php
echo '</div>';
}

?>