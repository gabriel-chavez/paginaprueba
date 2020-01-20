<?php
//1920x1080
$pages = lt_content_get_frontpage_items();
$services = uv_get_services(4);
lt_get_header();
?>
	<div class="container">
		<div class="row"><?php SB_MessagesStack::ShowMessages(); ?></div>
		<div class="row">
			<div class="col-md-9">
				<?php if( function_exists('lt_slider') ) lt_slider('slider_0'); ?>
			</div>
			<div class="col-md-3">
				<!--div class="row">
					<?php foreach($services as $s): ?>
					<div class="col-xs-6 col-md-12">
					<a href="<?php print $s->link; ?>" class="slide-service">
						<span class="banner" style="background:url('<?php print  MOD_CONTENT_BANNERS_URL . '/' . $s->_banner; ?>') no-repeat center center;">&nbsp;</span>
						<span class="title"><?php printf("No %s", $s->title); ?></span>
					</a>
					</div>
					<?php endforeach; ?>
				</div-->
				<div class="row">
				<style type="text/css">
			        @font-face{
			            font-family: 'robotoblack';
			            src: url('../fonts/Roboto-Black-webfont.eot');
			            src: url('../fonts/Roboto-Black-webfont.eot?#iefix') format('embedded-opentype'),
			            url('../fonts/Roboto-Black-webfont.woff') format('woff'),
			            url('../fonts/Roboto-Black-webfont.ttf') format('truetype'),
			            url('../fonts/Roboto-Black-webfont.svg#robotoblack') format('svg');
			            font-weight: normal;
			            font-style: normal;
			        }
			        .contX{border: 1px solid red;
			            float: left;
			            overflow: hidden;
			            margin: 50px;
			        }
			        .bxOpA{
			            overflow: hidden;
			            position: relative;
			            font-size: 14px;
			            font-family: 'robotoblack', Arial, Tahoma, Verdana;
			            font-weight: 700;
			            line-height: 18px;
			            text-align: left;
			            background: #124c8c;
			            width: 263px;
			            height: 79px;
			            margin-bottom: 7px;
			            -webkit-border-radius: 10px;
			            -moz-border-radius: 10px;
			            border-radius: 10px;
			        }
			        .bxOpA a{
			            display: table-cell;
			            vertical-align: middle;
			            color: #ffffff;
			            text-decoration: none;
			            border-bottom: 10px solid #f7981a;
			            width: 263px;
			            height: 69px;
			        }
			        .bxOpA img{
			            float: left;
			            display: block;
			            margin: 0 10px;
			        }
			        .bxOpA span{
			            float: left;
			            display: block;
			            width: 180px;
			            margin: 8px 0;
			        }
			    </style>
			    <div class="bxOpA">
			        <a href="http://www.univida.bo/index.php?mod=content&view=article&id=6">
			            <img src="../../lib/ico_op_01.png">
			            <span>Tu Seguro de<br>Accidentes Personales</span>
			        </a>
			        </div>
			        <div class="bxOpA">
			        <a href="http://www.univida.bo/index.php?mod=content&view=article&id=7">
			            <img src="../../lib/ico_op_02.png">
			            <span>Tu Seguro de Vida</span>
			        </a>
			        </div>
			        <div class="bxOpA">
			        <a href="http://www.univida.bo/index.php?mod=content&view=article&id=8">
			            <img src="../../lib/ico_op_03.png">
			            <span>Tu Seguro de<br>Desgravamen</span>
			        </a>
			        </div>
			        <div class="bxOpA">
			        <a href="http://www.univida.bo/index.php?mod=content&view=article&id=9">
			            <img src="../../lib/ico_op_04.png">
			            <span>Tu Seguro de Cesantía</span>
			        </a>
			        </div>
			        <div class="bxOpA">
			        <a href="http://www.univida.bo/soat">
			            <img src="../../lib/ico_op_05.png">
			            <span>SOAT</span>
			        </a>
			        </div>
				</div>
			</div>
		</div>
	</div>
	<?php /* ?>
	<!-- Services -->
	<div id="services" class="container">
		<div class="row">
			<?php foreach($pages as $p): ?>
			<div class="col-md-4 col3">
				<a href="<?php print $p->link; ?>" title="<?php print $p->title; ?>" class="roundal" id="<?php print $p->slug; ?>">
					<?php print $p->banner; ?>
				</a>
				<h3><?php print $p->title; ?></h3>
				<p><?php print $p->excerpt; ?></p>
				<form method="get" action="<?php print $p->link; ?>">
					<button type="submit" class="btn btn-default btn-green"><?php _e('Learn more', 'uv'); ?></button>
				</form>
			</div>
			<?php endforeach; ?>
		</div>
	</div><!-- end id="services" -->
	<div class="container">
		<div class="row">
			<div class="col-md-12 centered">
				<h3><span><?php _e('Our happy customers', 'uv'); ?></span></h3>
				<p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
			</div>
		</div>
	</div>
	<!-- Carousel -->
	<div id="c-carousel">
		<div id="wrapper">
			<div id="carousel">
				<div>
					<a href="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" title="Customer" data-hover="Some description about customer" data-toggle="lightbox" class="lightbox">
						<img src="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" alt="Customer" />
					</a>
				</div>
				<div>
					<a href="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" title="Customer" data-hover="Some description about customer" data-toggle="lightbox" class="lightbox">
						<img src="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" alt="Customer" />
					</a>
				</div>
				<div>
					<a href="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" title="Customer" data-hover="Some description about customer" data-toggle="lightbox" class="lightbox">
						<img src="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" alt="Customer" />
					</a>
				</div>
				<div>
					<a href="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" title="Customer" data-hover="Some description about customer" data-toggle="lightbox" class="lightbox">
						<img src="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" alt="Customer" />
					</a>
				</div>
				<div>
					<a href="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" title="Customer" data-hover="Some description about customer" data-toggle="lightbox" class="lightbox">
						<img src="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" alt="Customer" />
					</a>
				</div>
				<div>
					<a href="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" title="Customer" data-hover="Some description about customer" data-toggle="lightbox" class="lightbox">
						<img src="<?php print TEMPLATE_URL; ?>/images/customer01.jpg" alt="Customer" />
					</a>
				</div>
			</div>
			<div id="pager" class="pager"></div>
		</div>
	</div>
	<!-- Carousel end -->
	<!-- Rehome -->
	<div class="rehome">
		<div class="container">
			<div class="row">
				<div class="col-md-12 centered">
					<p><a href="#" title="" class="roundal"></a></p>
					<h4>Necesita m&aacute;s informaci&oacute;n acerca de nuestros servicios?</h4>
					<p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
					<a href="<?php print SB_Route::_('index.php?mod=content&view=article&id=4'); ?>" class="btn btn-default btn-green">
						<?php _e('Learn more', 'uv'); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!-- Rehome end -->
	<!-- Testimonials -->
	<div class="testimonials" data-stellar-background-ratio="0.6">
		<div class="container">
			<div class="row">
				<div class="col-md-12 centered">
					<!-- Slider -->
					<div id="home_testimonial" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#home_testimonial" data-slide-to="0" class="active"></li>
							<li data-target="#home_testimonial" data-slide-to="1"></li>
							<li data-target="#home_testimonial" data-slide-to="2"></li>
							<li data-target="#home_testimonial" data-slide-to="3"></li>
						</ol>
						
						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<div class="item active">
								<p>"Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum."</p>
							</div>
							<div class="item">
								<p>"Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui."</p>
							</div>
							<div class="item">
								<p>"Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum."</p>
							</div>
							<div class="item">
								<p>"Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui."</p>
							</div>
						</div>
					</div>
					<!-- Slider end -->

				</div>
			</div>
		</div>
	</div>
	<!-- Testimonials end -->
	*/?>
<?php lt_get_footer(); ?>
