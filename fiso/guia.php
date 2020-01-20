<!DOCTYPE html>
<html lang="es" xml:lang="es">

<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1">
    <title>Guía de atención de su siniestro | FISO | UNIVida S.A.</title>
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

            <h1 class="bgLn">Guía de atención de su siniestro - FISO</h1>

            <p>En caso de sufrir hecho de transito sin identificación de vehículo, usted deberá seguir los pasos que se detallan a continuación.</p>

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
                    En el plazo de 15 días, puede ser realizado por:
                    <ul>
                        <li><ico></ico><span class="desc">Centro Médico.</span></li>
                        <li><ico></ico><span class="desc">Organismo Operativo de Tránsito.</span></li>
                        <li><ico></ico><span class="desc">Victimas.</span></li>
                        <li><ico></ico><span class="desc">Cualquier persona que acredite interés legal.</span></li>
                    </ul>
                </div>
            </div>
						<div class="cntDp">
                <div class="bxTitD txttitle"><a href="javascript:void(0)">
                    <ico>+</ico>
                    <b>Paso 3</b> Entrega de formulario de requisitos para la cobertura FISO
                </a></div>
                <div class="bxTxtD txtcont">
                    Entrega al cliente el formulario con la documentación necesaria para otorgar la cobertura correspondiente, de conformidad al artículo 29 del Decreto Supremo 27295.
                </div>
            </div>
            <div class="cntDp">
                <div class="bxTitE txttitle"><a href="javascript:void(0)">
                    <ico>+</ico>
                    <b>Paso 4</b> Entrega de la documentación
                </a></div>
                <div class="bxTxtE txtcont">
                    <ul>
                        <li><ico></ico><span class="desc"><b>Heridos</b></span>
                            <ul>
                                <li><ico></ico><span class="desc">Certificado Médico.</span></li>
																<li><ico></ico><span class="desc">Certificado Médico Forense.</span></li>
                                <li><ico></ico><span class="desc">Certificado de Accidente emitido por el Organismo Operativo de Tránsito.</span></li>
																<li><ico></ico><span class="desc">Certificado de Invalidez Total y Permanente cuando corresponda.</span></li>
                                <li><ico></ico><span class="desc">Facturas y/o recibos (si corresponde).</span></li>
                            </ul>
                            <br>
                            En caso de victimas/familiares que hayan cancelado al centro médico se deberá solicitar recibos y/o facturas con sus respectivos resplados.
                            <br>
                            <br>
                        </li>

                        <li><ico></ico><span class="desc"><b>
                            Fallecidos</b></span>
                            <ul>
																<li><ico></ico><span class="desc">Protocolo de autopsia.</span></li>
																<li><ico></ico><span class="desc">Certificado médico.</span></li>
																<li><ico></ico><span class="desc">Certificado médico forense.</span></li>
																<li><ico></ico><span class="desc">Certificado de Accidente emitido por el Organismo Operativo de Transito.</span></li>
																<li><ico></ico><span class="desc">Certificado de Defunción.</span></li>
																<li><ico></ico><span class="desc">Declaratoria de Herederos </span></li>
																<li><ico></ico><span class="desc">Documento de identidad de los derechohabientes (original).</span></li>
																<li><ico></ico><span class="desc">Documento que identifique al accidentado (fotocopia de C.I. o certificado de nacimiento).</span></li>
																<li><ico></ico><span class="desc">Certificado de descendencia (Emitido por SERECI).</span></li>
																<li><ico></ico><span class="desc">Existencia o inexistencia de partida de Registro Civil.</span></li>
																<li><ico></ico><span class="desc">Certificado de matrimonio.</span></li>
                            </ul>
                            <br>
                        </li>
                        <li><ico></ico><span class="desc"><b>
                            Incapacidad total y permanente</b></span>
                            <ul>
                                <li><ico></ico><span class="desc">Documento que identifique al herido.</span></li>
                                <li><ico></ico><span class="desc">Certificado emitido por el Organismo Operativo de Tránsito.</span></li>
                                <li><ico></ico><span class="desc">Dictamen de Calificación de Incapacidad emitido por la EEC.</span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="cntDp">
                <div class="bxTitF txttitle"><a href="javascript:void(0)">
                    <ico>+</ico>
                    <b>Paso 5</b> Pago de la indemnización
                </a></div>
                <div class="bxTxtF txtcont">
                    Plazo de pago 15 días hábiles a partir de la recepción de la totalidad de documentos solicitados.
                    <ul>
                        <li>
                            <ico></ico><span class="desc"><b>
                            Indemnización por gastos médicos por Bs 24,000.00</b></span>
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
                            <ico></ico><span class="desc"><b>Indemnización por fallecimiento por Bs 22,000.00</b></span>
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
                            <ico></ico><span class="desc"><b>Indemnización por incapacidad permanente por Bs 22,000.00</b></span>
                            <ul>
                                <li>
                                    <ico></ico><span class="desc">Pago de la indemnización a la víctima.</span>
                                </li>
                            </ul>
                        </li>
                    </ul>
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
