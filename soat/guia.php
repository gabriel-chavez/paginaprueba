<!DOCTYPE html>
<html lang="es" xml:lang="es">

<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1">
    <title>Guía de atención de su siniestro | SOAT | UNIVida S.A.</title>
    <link rel="shortcut icon" href="<?php echo $domain ?>/lib/favicon.ico" />
    
    <link rel="stylesheet" href="<?php echo $domain ?>/css/style.css">
    
    <script src="<?php echo $domain ?>/js/jquery.min.js"></script>
    <script src="<?php echo $domain ?>/js/jquery.flexslider.js"></script>
    <script type="text/javascript">
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "fade"});
  });
    $(document).on("ready", function(){
        $(".txttitle").on("click", function(){
            txtnxt = $(this).next();
            th = $(this);
            if($(txtnxt).hasClass( "txtcont" )){
                $('.txtcont').slideUp();
                $(txtnxt).slideDown();
                $('.txttitle > a > ico').html("+");
                th.find('ico').html("-");
            }
        });
        $(".bxTitA").trigger( "click" );
    })
    
    </script>
    <style>
    .txtcont{
        display: none;
    }
    </style>
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

            <h1 class="bgLn">Guía de atención de su siniestro</h1>

            <p>En caso de sufrir  un siniestro usted deberá seguir los pasos que se detallan a continuación.</p>

               <div class="cntDp">
                <div class="bxTitA txttitle"><a href="javascript:void(0)">
                    <ico>+</ico>
                    <b>Paso 1</b> Suceso del accidente de tránsito
                </a></div>
                <div class="bxTxtA txtcont">
                    <ul>
                        <li>
                            <ico></ico>
                            <span class="desc">Las víctimas son auxiliadas al centro médico más cercano.</span>
                        </li>
                        <li>
                            <ico></ico>
                            <span class="desc">Aviso del siniestro al organismo operativo de tránsito.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="cntDp">
                <div class="bxTitB txttitle"><a href="javascript:void(0)">
                    <ico>-</ico>
                    <b>Paso 2</b> Aviso del siniestro a Seguros y Reaseguros UNIvida S.A.
                </a></div>
                <div class="bxTxtB txtcont">                    
                    En el plazo de 15 días y puede ser realizado por:
                    <ul>
                        <li><ico></ico><span class="desc">Centro médico.</span></li>
                        <li><ico></ico><span class="desc">Organismo operativo de tránsito.</span></li>
                        <li><ico></ico><span class="desc">Victimas.</span></li>
                        <li><ico></ico><span class="desc">Conductor o propietario del vehículo.</span></li>
                        <li><ico></ico><span class="desc">Cualquier persona que acredite interés legal.</span></li>
                    </ul>
                </div>
            </div>
            <div class="cntDp">
                <div class="bxTitC txttitle"><a href="javascript:void(0)">
                    <ico>+</ico>
                    <b>Paso 3</b> Apertura del reclamo y verificación de causales de exclusión de cobertura
                </a></div>
                <div class="bxTxtC txtcont">
                    Con el aviso del siniestro, se procede a la asignación del código correspondiente al reclamo y a la apertura física del file con la documentación presentada.   A su vez, se evalúa las circunstancias en las que ocurrió el siniestro para su cobertura, verificándose si éstas se enmarcan en alguna de las causales de exclusión de cobertura señaladas en el artículo 32 del Decreto Supremo 27295 de 20 de diciembre de 2003.
                </div>
            </div>
            <div class="cntDp">
                <div class="bxTitD txttitle"><a href="javascript:void(0)">
                    <ico>+</ico>
                    <b>Paso 4</b> Entrega de formulario de requisitos para la cobertura
                </a></div>
                <div class="bxTxtD txtcont">
                    De acuerdo a la evaluación del siniestro y las coberturas requeridas, se entrega al cliente el formulario con la documentación necesaria para otorgar la cobertura correspondiente, de conformidad al artículo 29 del Decreto Supremo 27295 de 20 de diciembre de 2003. 
                </div>
            </div>
            <div class="cntDp">
                <div class="bxTitE txttitle"><a href="javascript:void(0)">
                    <ico>+</ico>
                    <b>Paso 5</b> Entrega de la documentación
                </a></div>
                <div class="bxTxtE txtcont">                    
                    <ul>
                        <li><ico></ico><span class="desc"><b>Heridos</b></span>
                            <ul>
                                <li><ico></ico><span class="desc">Documento que identifique al herido.</span></li>
                                <li><ico></ico><span class="desc">Certificado emitido por el organismo operativo de tránsito.</span></li>
                                <li><ico></ico><span class="desc">Certificado médico.</span></li>
                            </ul>
                            <br>
                            En caso de victimas que hayan cancelado al centro médico se solicitará recibos y/o facturas.
                            <br>
                            <br>
                        </li>

                        <li><ico></ico><span class="desc"><b>
                            Fallecidos</b></span>
                            <ul>
                                <li><ico></ico><span class="desc">Documento que identifique al fallecido.</span></li>
                                <li><ico></ico><span class="desc">Certificado emitido por el organismo operativo de tránsito.</span></li>
                                <li><ico></ico><span class="desc">Certificado médico forense o certificado médico (si corresponde).</span></li>
                            </ul>
                            <br>
                        </li>
                        <li><ico></ico><span class="desc"><b>
                            Incapacidad total y permanente</b></span>
                            <ul>
                                <li><ico></ico><span class="desc">Documento que identifique al herido.</span></li>
                                <li><ico></ico><span class="desc">Certificado emitido por el organismo operativo de tránsito.</span></li>
                                <li><ico></ico><span class="desc">Dictamen de calificación de incapacidad emitido por la EEC.</span></li>
                            </ul>
                            <br>
                            Seguros y reaseguros UNIVIDA S.A. A requerimiento de la víctima solicitará la calificación de incapacidad de conformidad al artículo 26 del decreto supremo 27295.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="cntDp">
                <div class="bxTitF txttitle"><a href="javascript:void(0)">
                    <ico>+</ico>
                    <b>Paso 6</b> Pago de la indemnización
                </a></div>
                <div class="bxTxtF txtcont">
                    Plazo de pago 15 días hábiles a partir de la recepción de los documentos necesarios.
                    <ul>
                        <li>
                            <ico></ico><span class="desc"><b>
                            Indemnización por gastos médicos.</b></span>
                            <ul>
                                <li>
                                    <ico></ico><span class="desc">Pago de las proformas al centro médico.</span>
                                </li>
                                <br>
                                En caso de recibos y/o facturas de las víctimas se procede a su reembolso.
                            </ul>
                            <br>
                        </li>
                        <li>
                            <ico></ico><span class="desc"><b>Indemnización por fallecimiento.</b></span>
                            <ul>
                                <li>
                                    <ico></ico><span class="desc">Pago a los derechohabientes del fallecido.</span>
                                </li>
                                <br>
                                En caso de existir conflicto de intereses entre los derechohabientes se realiza un depósito judicial.
                            </ul>
                            <br>
                        </li>
                        <li>
                            <ico></ico><span class="desc"><b>Indemnización por incapacidad permanente.</b></span>
                            <ul>
                                <li>
                                    <ico></ico><span class="desc">Pago de la indemnización a la víctima.</span>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="cntDp">
                <div class="bxTitG txttitle"><a href="javascript:void(0)">
                    <ico>+</ico>
                    <b>Paso 7</b> Ejercicio del Derecho de repetición
                </a></div>
                <div class="bxTxtG txtcont">
                    <ul>
                        <li><ico></ico><span class="desc">Se verifica la conclusión del reclamo con el pago de todas las indemnizaciones del siniestro.</span>
                        </li>
                        <li><ico></ico><span class="desc">Inicio del proceso de repetición ante la autoridad competente.</span></li>
                    </ul>
                    <br>
                    En caso de existir causales de repetición.
                </div>
            </div>

            
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
