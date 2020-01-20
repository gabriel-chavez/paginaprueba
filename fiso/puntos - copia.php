<!DOCTYPE html>
<html lang="es" xml:lang="es">

<head>

	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1">
  <title>Puntos de venta | SOAT | UNIVida S.A.</title>
  <link rel="shortcut icon" href="<?php echo $domain ?>/lib/favicon.ico" />

  <link rel="stylesheet" href="<?php echo $domain ?>/css/style.css">

  <script src="<?php echo $domain ?>/js/jquery.min.js"></script>
  <script src="<?php echo $domain ?>/js/jquery.flexslider.js"></script>
  <script type="text/javascript">
  $(window).load(function(){
    $('.flexslider').flexslider({
      animation: "fade"});
  });
  function city (ci) {
    if (ci!="") {
      $('.todas').hide();
      $('.ciudad').hide();
      $('#'+ci).show();

    }else{
      $('.todas').show();
      $('.ciudad').show();
    };
  }
  </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122046420-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-122046420-1');
    </script> 
</head>

<body>

  <div class="wrapper">

   <?php include 'skin/header.php' ?>

   <section class="contentIn">
    <div class="cntCntIn">

      <h1 class="bgLn">Puntos de venta</h1>

      <p>Adquiera su SOAT   en el punto de venta más cercano,  le mostramos nuestros puntos de venta a Nivel Nacional.</p>

      <form class="formA" action="/" method="post">
        <fieldset>
          <p>
            <label class="labB">Escoge tu ciudad:</label>
            <select name="ct_area" id="ct_area" class="selC" onchange="city(this.value)">
              <option value="">Todas</option>
              <option value="santa">Santa Cruz</option>
              <option value="lapaz">La Paz</option>
              <option value="tarija">Tarija</option>
              <option value="montero">Montero</option>
              <option value="beni">Beni</option>
              <option value="trinidad">Trinidad</option>
              <option value="pando">Pando</option>
              <option value="chuquisaca">Chuquisaca</option>
              <option value="potosi">Potosí</option>
              <option value="oruro">Oruro</option>
              <option value="elalto">El Alto</option>
              <option value="yacuiba">Yacuiba</option>
              <option value="cochabamba">Cochabamba</option>
            </select>
          </p>
        </fieldset>
      </form>
      <span class="clear"></span>
      <span class="todas">
        <h2>Todas:</h2>
        <span class="clear"></span>
        <br>
      </span>
      <?php
      $string = "Rotonda Llojeta 
      Plaza Abaroa
      Plaza España
      Plaza Israel 
      Plaza San Pedro
      Plaza Cóndor
      Estadium Bolívar 
      Estación Central 
      Oficina UNIVida (Av. Camcho N° 1415, Edificio Crispieri Nardin Planta Baja)
      Puerta Ketal Av. Arce 
      Av . Buenos Aires Telferico Amarillo 
      23 Calacoto 
      21 Calacoto
      8 Achumani
      16 Achumani
      Plaza Humboldt 
      Mercado las Cholas 
      Entrada Pinos 
      17 Obrajes 
      Catedral Irpavi
      60 Chasquipampa 
      Entrada a Koani
      Av. Del Policia Alto Seguencoma
      Alto Obrajes Ex Gasolinera 
      Piscina Olímpica 
      Plaza Principal Villa Armonía 
      Villa Copacabana Puma Katari 
      Cancha Villa Copacabana 
      Plaza Tapia Villa San Antonio 
      Villa San Antonio Alto 
      Plaza Hergueta 
      Teleferico Linea Verde Alto Obrajes
      San Pedro Heroes del Acre
      Edif. Handal Mezzanine
      Av. Zabaleta Castrillo
      Estadium 
      Transito LP 
      Mercado Camacho
      Cancha Zapata
      Plaza Villaroel 
      La Asunta
      Chulumani
      Coroico
      Caranavi 
      Patacamaya 
      Rio Abajo 
      Frente Cementerio 
      Achachicala - Surtidor 
      Plaza del Maestro 
      Puente Minasa 
      Final Entre Rios el Tejar 
      La Portada Final Collasuyo 
      Villa Victoria Plaza Rimachi 
      Teleférico Rojo Cementerio General ";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='lapaz'><h3>La Paz</h3>";
      echo $newstring.'</span>';



      $string = "Av. Santos Dumont entre 6tp y 7mo anillo Av. Nuevo Palmar Nº 23 Supermercado
      Calle Urubicha entre Av. Iberica y San Miguel Nº 55
      3er Anillo Av. Pedro Rivero Nº 100 taller Aburdene
      Av. Omar Chavez esq. Ana Barba
      Plaza Mechero frente a la SubAlcaldia
      Av. Santos Dumont a 2 cuadras del 2do Anillo
      Al frente del Parqueo de Transito
      Av. Paurito 5to Anillo 2 casas antes del cruce del Semaforo
      Av. Mutualista diagonal del Banco Union 3er anillo 
      Av. Pirai entrada de Urbari
      Mairana
      Vallegrande 
      Comarapa
      2do Anillo entre Brasil y Virgen de Cotoca (Ferreteria)
      Radial 10 5to anillo pasando el trillo
      Radial 17 y medio entre 4to y 5to anillo
      4to Anillo de la Av. Pirai
      3er Anillo de la Av. Virgen de Cotoca
      4to Anillo de la Av. Virgen de Cotoca
      4to Anillo 3 pasos al frente en la Rotonda
      4to Anillo Anillo San Aurelio
      Av. Mutualista 3er Anillo Externo Av. Japon Nº 3450
      Av. Santos Dumont 5to Anillo
      Av. Banzer 4to Anillo afuera de un Autoventa.
      Radial 13 calle 10 Barrio Guaracal Nº 3140
      Satelite Norte Av. Principal esq. Calle los Seibos
      Calle Mercado a 1 cuadra de la Av. Cañoto
      Plazuela del Cementerio
      Warnes al lado de la Alcaldia
      Paragua y 4to Anillo en X Libra
      El Torno Puerto Rico
      4to Anillo Doble Via la Guardia
      Av. San Martin diagonal al Super Slan ente 3er y 4to anillo
      Av. La Campana Mercado La Campana
      Oficinas de Univida (Calle Florida Nº 130)
      Barrio los Lotes Mercado Fortaleza
      Avion Pirata Av. Wiracola a media cuadra de la Farmacia Okinawa
      3er Anillo Interno Av. Beni 
      Av. San Aurelio 4to anillo en la Rotonda
      2do Anillo entre Alemana y Beni al lado del Ser
      4to Anillo Villa Olimpica
      3er Anillo externo Zoologico al lado de la Inspeccion tecnica
      Pampa de la Isla Subestacion Policial
      Radial 10 4to Anillo
      Radial 15 Mercado Alto San Pedro
      Santos Dumont entre 4to y 5to Anillo frente a la Villa Olimpica
      2do y 3er Anillo Av. Paragua sobre la Avenida.
      2do anillo Av. Busch lado del Surtidor La Cima
      Radial 10 5to Anillo en el Surtidor San Luis II
      Plazuela del Estudiante
      Radial 23 3er Anillo externo 
      3er Anillo interno frente al parque Udabol
      Km 14 Doble via la Guardia frente a la Cerveceria
      Av. Escuadron Velasco Nº 352
      Radial 10 y 16 de Julio Mercado Noel Kemp Mercado
      Cotoca Surtidor Tarope
      Plan 3000 surtidor las Orquideas frente al Modulo Policial
      Villa 1ro de Mayo, Av. Cumavi entrada Bienvenido
      Cotoca Calle German Busch Sindicato 2 de Agosto
      Villa 1ro de Mayo, Zona Pampa de la Cruz nº 4940 esq. Calle C
      Parqueo del Ser Av. Trinidad entre 1er y 2do Anillo
      3er Anillo Externo atrás de Infocal (canal Cotoca)
      2do y 3er Anillo Av. Mutualista frente a Interpol
      Av. Cañoto esq. Av. Landivar 1er Anillo
      El Bateon 9no Anillo (Surtidor en Construccion)";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='santa'><h3>Santa Cruz</h3>";
      echo $newstring.'</span>';





      $string = "Av. Las Américas Pte. San Martin
      Av. Las Américas Frente Cmdo. Dptal. Policía
      Av. Las Américas fuente de los deseos
      Av. Las Américas Coliseo Universitario
      Rotonda Aeropuerto Z. Aeropuerto
      Parada al Chaco
      Surtidor Agrupa, Crr. Tomatitas
      Circunvalación, Froilan Tejerina La Torre
      Av. Los Ceibos Iglesia Senac
      Circunvalación Colon
      Circunvalación Esq. La Gamoneda
      Av Los Membrillos, Frente Hospital Obrero
      Circunvalación y Suipacha
      Circunvalación y Gran Chaco
      Circunvalación y Gral. Trigo
      Av. Panamericana Frente Mcdo. Abasto del Sur
      Av. Delio Echazu, final Belgrano
      Av. Las Américas, frente a Impuestos Nacionales
      Crr. Al Valle, a 1 km. del Cruce al Valle
      Calle Lazcano entre Ciro Trigo y Delfín Pino
      C. Alfredo Ameller nro. 280 entre C. Argentina y La Paz (Bermejo)
      Terminal de Buses (Bermejo)";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='tarija'><h3>Tarija</h3>";
      echo $newstring.'</span>';



      $string = "Calle Angel Mariano Cuellar entre calles  Santa Cruz y Tarija 
      Plaza principal acera Norte 
      Calle Independencia casi esq. Bolivar
      Av. circunvalación Noreste Casi Esq. Av. Florida
      Av. circunvalación Noreste Casi Esq. Av. Fabril
      Rotonda Norte colegio Metodista 
      Doble via Carretera Guabira 
      Calle Ballivian entre Jorge Velarde y Audifaz Parada
      Calle Pastor Diaz entre 24 de Septiembre y calle  Warnes 
      Av. Monseñor Santistevan  entre Ballivian y Santa Cruz
      Saavedra - Plaza principal acera Norte
      Minero - Av. Santa Cruz  frente a la Cooperativa Sacaroza  y frente Plaza principal acera Este
      Fernandez Alonzo - Calle Bolivar frente a la plaza principal 
      Yapacani -Av. Epifanio Rios cerca a la Plaza principal 
      Warnes - Calle Bolivar esq. diagonal Plaza Principal ";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='montero'><h3>Montero</h3>";
      echo $newstring.'</span>';




      $string = "OFICINAS ALIANZA
      POLICIA MONTADA Y FRONTERIZA DEL BENI
      AV. PEDRO IGNACIO MUIBA(FRENTE AL BANCO UNION)
      ESTACION DE SERVICIO EL CHAPARRAL
      ESTACION POLICIAL FRENTE AL CEMENTERIO 
      AV. COCHABAMBA(FRENTE AL BANCO UNION)
      PLAZA PRINCIPAL 
      AV. MOXOS CASI ESQ. BENI
      AV. MOXOS BAJANDO EL PUENTE DE MADERA
      AV. BOLIVAR ESQ. BOLIVAR(EDIFICIO EX LA SALLE)";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='beni'><h3>Beni</h3>";
      echo $newstring.'</span>';



      $string = "Organismo Operativo De Transito
      Plaza Principal
      Oficinas Alianza
      Av. Pedro Ignacio Muiba
      Estacion De Servicios El Oasis
      Policia Montada Y Fronteriza Del Beni
      Plazuela Fatima";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='trinidad'><h3>Trinidad</h3>";
      echo $newstring.'</span>';

      $string = "Avenida 9 de febrero(Parque Piñata)
      Avenida 9 de febrero Km 2 Cip Pando";

      $bits = explode("\n", $string);

      $newstring = '<ul class="liItm02">';
      foreach($bits as $bit)
      {
        $newstring .= "<li>" . $bit . "</li>";
      }
      $newstring .= '</ul><span class="clear"></span>';

      echo "<span class='ciudad' id='pando'><h3>Pando</h3>";
      echo $newstring.'</span>';



      $string = "AV. MARCELO QUIROGA SANTA CRUZ (Estacion de servicios Mesa Verde)
      AV.  De Las Americas (AL MEDIO - ALTURA F. San Agustin) 
      AV GERMAN MENDOZA  ZONA ESTADIUM PATRIA             
      ESTACION ANICETO ARCE (SURTIDOR)
      PLAZUELA DEL CEMENTERIO
      AV. MARCELO QUIROGA SANTA CRUZ (Rotonda Rotary)  
      AV GERMAN MENDOZA PLAZUELA EL RELOJ  
      AV.  De Las Americas (Banderitas)
      AV. JUAN AZURDUY DE PADILLA FRENTE AL GAS CENTER 
      PLAZUELA DE LAS ROSAS  ESTACION ANICETO ARCE
      AV. OSTRIA GUTIERREZ esq. Nataniel Aguirre(Surtidor Ostria Gutierrez- Terminal
        AV.  De Las Americas (FINAL)
        PLAZUELA WALLPARRIMACHI
        ROTONDA  ESTACION ANICETO ARCE
        PLAZUELA DEL HOSPITAL DE LA MUJER
        PLAZUELA TREVERIS (FRENTE  AL CANAL UNIVERSITARIO)   
        PLAZUELA COCHABABAMBA (CERCA AL SUPER MERCADO SAS) 
        PLAZUELA  SAN JUANILLO ( MERCADO CAMPESINO)
        OFICINA (ZONA CENTRAL) 
        NACIONAL VIDA (CALLE BUSTILLOS - ZONA CENTRAL) 
        AXEL CONCESIONARIO (ZONA MESA VERDE)  ";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='chuquisaca'><h3>Chuquisaca</h3>";
        echo $newstring.'</span>';



        $string = "Calle Bernedo
        Calle Boqueron
        Calle Caracas
        Calle Chayanta
        Avenida Ecuador
        Calle Salguero
        Calle San Pedro
        Calle Hernandez
        Calle Bolivar
        Avenida Universitaria
        Avenida Las Banderas
        Calle Surco
        Avenida Circunvalacion
        Calle Delgadillo
        Calle Enteno
        Calle Montevideo Nro. 178
        Mercado Chuquimia
        Transito Potosi
        Surtidor Potosi
        Civica esquina 1 de Abril 
        Plaza El Minero";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='potosi'><h3>Potosí</h3>";
        echo $newstring.'</span>';




        $string = "TRÁNSITO
        TERMINAL
        MERCADO YOUNG
        CEMENTERIO
        STADIUM
        EST. SERVICIO MORELA
        PLAZA SEBASTIAN PAGADOR
        AV. TACNA Y EJERCITO
        6 DE AGOSTO Y HERRERA
        EST. POLICIAL DEHENE Y CIRCUNVALACION
        AV. ESPAÑA , LA SALLE Y BULLAIN
        6 DE OCTUBRE Y HERRERA
        AV. SGTO FLORES Y POTOSI
        AUTOVENTA
        5 ESQUINAS
        LA PLATA , BOLIVAR
        6 DE OCTUBRE Y VILLARROEL
        PARQUE DE LA UNION";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='oruro'><h3>Oruro</h3>";
        echo $newstring.'</span>';


        $string = "Avenida Litoral y Cochabamba
        Plaza Bolivia frente al Mercado Satelite
        Plaza Obelisco Villa Tejada Triangular
        Plaza del Sol Villa Ingenio
        Avenida Juan Pablo II altura Puente Pil
        Aduana Comercial El Alto
        Avenida 6 de Marzo Cruce Achocalla
        Avenida 6 de Marzo Taquiña
        Avenida Panoramica frente Teleferico Linea Amarilla
        Avenida Juan Pablo II Frente a TAM
        Cruce Villa Adela Puente Nuevo Zona Villa Adela
        Avenida Juan Pablo II frente a Transito El Alto
        Avenida 6 de Marzo Extranca Senkata
        Avenida 6 de Marzo Extranca Senkata
        Teleferico Linea Roja
        Avenida Juan Pablo II frente a Transito El Alto
        Avenida Juan Pablo II frente a Transito El Alto
        Avenida Juan Pablo II frente a Transito El Alto
        Av de Marzo entre calles 2 y 3
        Avenida Juan Pablo II, Final Los Andes
        Avenida 6 de marzo entre calles 1 y 2
        Avenida 6 de Marzo altura Taquiña Zona Santiago II
        Puente San Juan Zona Villa Ingenio
        Avenida Civica Altura Plaza Kolping
        Av 6 de Marzo altura Ex Estacion calle 3
        Avenida Juan Pablo II Extranca Rio Seco
        Plaza Minero Zona Santiago II
        Avenida 6 de Marzo Puente Bolivia
        Avenida Juan Pablo II Altura Cruz Papal
        Plaza de la Cruz Zona Villa Adela
        Avenida 6 de Marzo entre calles 2 y 3
        Avenida Juan Pablo II frente a Transito El Alto
        Av 6 de marzo entre calles 2 y 3
        Avenida 6  de marzo Ventilla
        Avenida 6  de marzo Puente Vela
        Avenida 6  de marzo Puente Bolivia
        Cruce Villa Adela Puente Nuevo Zona Villa Adela
        Cruce Villa Adela Puente Nuevo Zona Villa Adela
        Avenida Civica frente a Instituto Don Bosco
        Plaza Ballivian Zona 16 de Julio
        Plaza del Policia Villa Adela
        Avenida Juan Pablo II esquina Chacaltaya
        Avenida Juan Pablo II Extranca Rio Seco
        Villa Adela Plaza del Policia 
        Avenida 6 de Marzo Altura Cuartel Ingavi";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='elalto'><h3>El Alto</h3>";
        echo $newstring.'</span>';



        $string = "AV. MENDEZ ARCO ENTRE GERMAN BUSCH Y COSTANERAS
        AV. MENDEZ ARCO ESQ. GERMAN BUSCH
        C. BOQUERON ESQ. SUBTENIENTE BARRON
        AV. INGAVI ESQ. COSTANERAS
        ENTRADA AL MERCADO CENTRAL ENTRE ORURO Y MENDEZ ARCO
        B. BILBAO RIOJAS
        C. COMERCIO ENTRE JACINTO DELFIN Y JUAN XXIII
        C. CREVAUZ ESQ. SAN MARTIN
        AV. SANTA CRUZ ESQ. BENEMERITOS
        C. AVAROA 1 ENTRE 27 DE MAYO Y BENEMÉRITOS
        AV. SANTA CRUZ ENTRE 27 DE MAYO Y JORGE TASSAKIS
        C. COMERCIO ENTRE JACINTO DELFIN Y JUAN XXIII
        C. SANTA CRUZ ENTRE COCHABAMBA Y CREVAUX
        C. INDEPENDECIA ENTRE BALLIVIAN Y AVAROA
        C. BALLIVIAN ESQ. CREVAUX
        B. SAN MIGUEL CALLE FORTIN ARCE Y TEOLINDA CATACORA
        C. CAMPERO ENTRE SANTA CRUZ Y BALLIVIAN
        C. BALLIVIAN ESQ. 9
        C. 24 DE JULIO ESQ. MARTIN BARROSO
        C. BALLIVIAN ESQ. 8
        B. LA CRUZ  C. CORNELIO RIOS
        PLAZA PRINCIPAL FRENTE A LA ALCALDIA MUNICIPAL";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='yacuiba'><h3>Yacuiba</h3>";
        echo $newstring.'</span>';



        $string = "AV 6 DE AGOSTO Y ROTONDA AVION
        AV LA PATRIA Y AV CABILDO 
        AV INGAVI Y PUENTE KILLAMAN
        AV. BEIGIN Y AV. CAP. VICTOR USTARIZ
        AV. DORGBINI Y AV JUAN PABLO SEGUNDO
        AV. PANAMERICANA FRENTE TEMPLO LORETO
        AV. PANAMERICANA  ESQUINA DE BARTOS
        AV. BEIGIN Y RIELES
        AV VILLAZON LADO EX Q BARATO
        AV. PAPA PAULO Y C VENEZUELA
        AV. AMERICA Y AV. PANDO
        AV. PAPA PAULO Y AV. OQUENDO
        AV. AMERICA Y PASAJE GNRL GALINDO
        AV. SANTA CRUZ Y C. ANICETO PADILLA
        AV. AMERICA Y PARQUE DEL ARQUITECTO
        C. TARIJA ESQUINA PORTALES
        AV. ANICETO ARCE Y AV. PAPA PAULO
        AV. AMERICA Y GNRL GALINDO
        AV. RUBEN DARIO Y AV. RAMON RIVERO
        AV. CIRCUNAVALACION Y C. LUIS CALVO
        AV. CIRCUNAVALACION Y AV AMERICA ESTE 
        AV. PETROLERA KM 2 1/2
        AV. SIGLO XX 
        AV. SIGLO XX Y AV. GUAYACAN
        AV. GUAYACAN Y AV. SIGLO XX 
        MERCADO CAMPESINO
        AV. SIGLO XX FRENTE SURTIDOR LOTUS
        AV. SIGLO XX Y C. PEDRO ZEBALLOS
        AV. SUECIA Y BIBLIO AVION
        AV. SUECIA Y BIBLIO AVION
        AV SIGLO XX U C. ANGELELI
        AV. PETROLERA KM 4
        AV. PETROLERA KM 4
        AV. OQUENDO FRENTE A LAS TORRES SOFFER
        PLAZA COLON Y C MAYOR ROCHA
        PLAZA COLON FRENTE A GLOBOS
        AV. BALLIVIAN Y C. ORURO
        AV. BALLIVIAN Y C. CHUQUISACA
        AV. BALLIVIAN Y PLAZA DE LAS BANDERAS ACERA ESTE
        AV. BALLIVIAN Y PLAZA DE LAS BANDERAS ACERA OESTE
        AV. OBLITAS LADO SAR
        OFICINA UNIVIDA (AV. RAMON RIVERO N° 846, Zona Muyurina)
        KM 6 AV. PETROLEA
        C/ ROSARIO - CLIZA (LADO MICROS CLIZA)
        PLAZA PRINCIPAL TARATA - TARATA
        AV. SANTACRUZ - CLIZA (LADO H.A.M.C.)
        C/AVAROA - TIRAQUE
        ARCO ENTRADA CLIZA - CLIZA
        CRUCE PARACAYA - PARACAYA
        POLICIA TRANSITO - PUNATA
        C/ SUCRE#017 - CLIZA
        PLAZA PRINCIPAL PUNATA - PUNATA
        TERMINAL PUNATA - PUNATA
        TERMINAL PUNATA - PUNATA
        AV.BLANCO GALINDO KM 7 1/2
        PLAZA PRINCIPAL SANTIVANEZ - SANTIVANEZ
        PLAZA PRINCIPAL TOTORA - TOTORA
        AV. JUAN PEREIRA - ARANI 
        PLAZA QUINTANILLA 
        AV. BALLIVIAN FRENTE A COMTECO
        AV. SIMON LOPEZ ESQUINA LOS CEIVOS
        PLAZA 27 DE MAYO EL PASO
        AV. JUAN DE LA ROSA Y FELIX ARANIBAR
        AV. BEIGIN LADO BANCO UNION
        AV. TADEO AENKE Y AV. JUAN PABLO SEGUNDO
        AV. BEIGIN Y C JESUS AGUAYO
        AV. DORGBINI Y AV. GABRIEL RENE MORENO
        AV OQUENDO Y C COLOMBIA
        AV. AMERICA Y C. TARIJA 
        AV. GUILLERMO URQUIDI Y C. BELZU
        FRENTE ESCUELA DE SARGENTOS - TARATA
        C/BALLIVIAN #003
        CARRETERA ANTIGUA SANTACRUZ - SAN BENITO
        FERIA TIRAQUE - TIRAQUE
        AV. PERÚ Y C. VIRREINATO DE LIMA
        AV. CHAPARE Y C. PANAMA";

        $bits = explode("\n", $string);

        $newstring = '<ul class="liItm02">';
        foreach($bits as $bit)
        {
          $newstring .= "<li>" . $bit . "</li>";
        }
        $newstring .= '</ul><span class="clear"></span>';

        echo "<span class='ciudad' id='cochabamba'><h3>Cochabamba</h3>";
        echo $newstring.'</span>';


        ?>

      </div>
    </section>

    <?php include 'skin/footer.php' ?>

  </div>

  <script src="<?php echo $domain ?>/js/jquery.pageslide.min.js"></script>
  <script>
  $(".open").pageslide();
  </script>

</body>
</html>
