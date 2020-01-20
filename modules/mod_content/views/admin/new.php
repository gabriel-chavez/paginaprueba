<?php
$back_link = $type != 'page' ? SB_Route::_('index.php?mod=content&type='.$type) : SB_Route::_('index.php?mod=content');
?>
<div class="wrap">
	<h1><?php print $title; ?></h1>
	<form action="" method="post">
		<input type="hidden" name="mod" value="content" />
		<input type="hidden" name="task" value="save" />
		<input type="hidden" name="type" value="<?php print $type; ?>" />
		<?php if( isset($content) ): ?>
		<input type="hidden" name="article_id" value="<?php print $content->content_id; ?>" />
		<?php endif; ?>
		<div class="row">
			<div id="article" class="col-md-9">
				<div class="row">
					<div class="col-md-8">
						<div class="control-group">
							<label class="has-popover" data-content="<?php print SBText::_('CONTENT_TITLE'); ?>">
								<?php print SB_Text::_('Titulo:', 'content'); ?>
							</label>
							<div class="input-group article-color">
								<input type="text" name="title" value="<?php print SB_Request::getString('title', isset($content) ? $content->title : ''); ?>" 
										class="form-control" />
								<input type="hidden" id="article-fg-color" name="btn_fg_color" value="<?php print isset($content) && $content->_btn_fg_color ? $content->_btn_fg_color : '#fff'; ?>" class="form-control hidden" />
								<input type="hidden" id="article-color-input" name="btn_bg_color" value="<?php print isset($content) && $content->_btn_bg_color ? $content->_btn_bg_color : '#0213cc'; ?>" class="form-control hidden" />
							    <span class="input-group-addon fg_color_picker" title="<?php print SB_Text::_('Color de Texto', 'content'); ?>">
							    	<i style="display:inline-block;width:16px;height:16px;cursor:pointer;background-color:<?php print isset($content) && $content->_btn_fg_color ? $content->_btn_fg_color : '#fff'; ?>;">&nbsp;</i>
							    </span>
							    <span class="input-group-addon bg_color_picker" title="<?php print SB_Text::_('Color de Boton', 'content'); ?>">
							    	<i style="display:inline-block;width:16px;height:16px;cursor:pointer;background-color:<?php print isset($content) && $content->_btn_bg_color ? $content->_btn_bg_color : '#0213cc'; ?>;">&nbsp;</i>
							    </span>
							    <?php if( isset($content) ): ?>
							    <a href="<?php print SB_Route::_('index.php?mod=content&view=article&id='.$content->content_id, 'frontend'); ?>" 
							    	class="input-group-addon" target="_blank"><?php _e('View', 'content'); ?>
							    </a>
							    <?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="has-popover" data-content="<?php print SBtext::_('CONTENT_LABEL_UPLOAD_IMG_CHECK', 'content'); ?>">
						<?php print SBText::_('Usar Imagen en lugar de Boton de texto', 'content'); ?>
						<input type="checkbox" name="user_button_instead" value="1" <?php print (isset($content) && $content->_user_button_instead == 1) ?  'checked' : ''; ?> />
					</label>
					<div>
						<span class="help-block">
							<?php print SBText::_('Subir Imagen para Boton: (Tamaño recomendado: 200x100 / 150x80)', 'content');?>
						</span>
						<span id="select-button-image" class="btn btn-primary">
							<?php print SBText::_('Subir imagen', 'content'); ?>
							<span id="uploading-btn-img" style="display:none;">
								<img src="<?php print BASEURL; ?>/js/fineuploader/loading.gif" alt=""  />
								<?php print SB_Text::_('Subiendo imagen...', 'content'); ?>
							</span>
						</span>
						<div id="button-image" style="<?php print (isset($content) && $content->_button_image) ? '' : 'display:none'; ?>">
							<img src="<?php print UPLOADS_URL; ?>/buttons/<?php print isset($content) ? $content->_button_image : ''; ?>" alt="" />
							<a href="javascript:;" id="remove-button-image" class="remove" <?php print (isset($content) && $content->_button_image) ? '' : 'style="display:none;"'; ?>>
								<img src="<?php print BASEURL ?>/images/close_window-48x48.png" alt="" title="<?php print SB_Text::_('Eliminar Banner', 'conent')?>" />
							</a>
						</div>
					</div>
				</div>
				<div id="article-banner">
					<label class="has-popover" data-content="<?php print SBText::_('CONTENT_BANNER'); ?>"><?php print SB_Text::_('Banner:', 'content'); ?></label>
					<span class="help-block">
						<?php print SB_Text::_('(Tamaño recomendado: 1920x560 / 1920x300)'); ?>
					</span>
					<div>
						<span id="select-banner" class="btn btn-primary">
							<?php print SB_Text::_('Subir imagen', 'content'); ?>
						</span>
						<span id="uploading" style="display:none;">
							<img src="<?php print BASEURL; ?>/js/fineuploader/loading.gif" alt=""  /><?php print SB_Text::_('Subiendo imagen', 'content'); ?>
						</span>
					</div>
					<div id="the-banner">
						<img src="<?php print $image_url; ?>" alt="" class="img-thumbnail" <?php print !$image_url ? 'style="display:none;"' : ''; ?> />
						<a href="javascript:;" id="remove-banner" class="remove" <?php print !$image_url ? 'style="display:none;"' : ''; ?>>
							<img src="<?php print BASEURL ?>/images/close_window-48x48.png" alt="" title="<?php print SB_Text::_('Eliminar Banner', 'conent')?>" />
						</a>
					</div>
				</div>
				<div class="control-group">
					<label class="has-popover" data-content="<?php print SBText::_('CONTENT_CONTENT'); ?>"><?php print SB_Text::_('Contenido:', 'content'); ?></label>
					<textarea id="content_area" name="content" class="form-control"><?php print SB_Request::getString('content', isset($content) ? stripslashes($content->content) : ''); ?></textarea>
				</div>
				<?php SB_Module::do_action('content_data_'.$type, isset($content) ? $content : null); ?>
				<?php SB_Module::do_action('content_data', isset($content) ? $content : null); ?>
				
			</div>
			<div id="sidebar" class="col-md-3">
				<div class="widget">
					<h2 class="title"><?php print SB_Text::_('Opciones', 'content'); ?></h2>
					<div class="body">
						<div class="form-group">
							<label class="has-popover" data-content="<?php print SBText::_('CONTENT_STATUS'); ?>"><?php print SB_Text::_('Estado:', 'content'); ?></label>
							<select name="status" class="form-control">
								<option value="publish" <?php print (isset($content) && $content->status == 'publish') ? 'selected' : ''; ?>><?php print SB_Text::_('Publicado', 'content'); ?></option>
								<option value="draft" <?php print (isset($content) && $content->status == 'draft') ? 'selected' : ''; ?>><?php print SB_Text::_('Borrador', 'content'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label><?php _e('Language', 'content'); ?></label>
							<select name="lang" class="form-control">
				  				<?php foreach(SB_Factory::getApplication()->GetLanguages() as $code => $lang):?>
				  				<option value="<?php print $code; ?>" <?php print isset($content) && $content->lang_code == $code ? 'selected' : ''; ?>>
				  					<?php print $lang; ?>
				  				</option>
				  				<?php endforeach; ?>
				  			</select>
						</div>
						<?php if( isset($features['use_dates']) && $features['use_dates'] ): ?>
						<div class="row">
							<div class="col-md-12 form-group">
								<label class="has-popover" data-content="<?php print SBText::_('CONTENT_PUBLSIH_DATE'); ?>">
									<?php print SB_Text::_('Fecha de Publicacion:', 'content'); ?></label>
								<div class="row col-md-8">
									<input type="text" name="publish_date" value="<?php print isset($content) ? sb_format_date($content->publish_date) : date(DATE_FORMAT);  ?>" class="form-control datepicker" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<label class="has-popover" data-content="<?php print SBText::_('CONTENT_EXPIRES_DATE'); ?>">
									<?php print SB_Text::_('Fecha Caducidad:', 'content'); ?></label><br/>
								<div class="row col-md-8">
									<input type="text" name="end_date" value="<?php print isset($content) ? 
																				sb_format_date($content->end_date) : 
																				date(DATE_FORMAT, strtotime((date('Y')+35).'-01-01'));  ?>" class="form-control datepicker" />
								</div>
							</div>
						</div>
						<?php endif; ?>
						<?php if( isset($features['calculated_dates']) && $features['calculated_dates'] ): ?>
						<div class="row">
							<div class="col-md-12 form-group">
								<label class="has-popover" data-content="<?php print SBText::_('CONTENT_PUBLISH_C_DATE'); ?>"><?php print SB_Text::_('Fecha de Publicacion Calculada:', 'content'); ?></label><br/>
								<div class="row col-md-5">
									<input type="number" min="0" name="calculated_date" value="<?php print isset($content) ? (int)$content->_calculated_date : 0;  ?>" class="form-control" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<label class="has-popover" data-content="<?php print SBText::_('CONTENT_EXPIRES_C_DATE'); ?>"><?php print SB_Text::_('Fecha Caducidad Calculada:', 'content'); ?></label><br/>
								<div class="row col-md-5">
									<input type="number" min="0" name="end_calculated_date" value="<?php print isset($content) ? (int)$content->_end_calculated_date : 0;  ?>" class="form-control" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="has-popover" data-content="<?php print SBText::_('CONTENT_USE_CDATES'); ?>">
								<input type="checkbox" name="use_calculated" value="1" <?php print (isset($content) && $content->_use_calculated) ? 'checked' : '';?> /> 
								<?php print SB_Text::_('Usar fechas calculadas')?>
							</label>
						</div>
						<?php endif; ?>
						<?php if( $type == 'page' ): ?>
						<div class="form-group">
							<label class="has-popover" data-content="<?php _e('CONTENT_COVER_PAGE'); ?>">
								<input type="checkbox" name="in_frontpage" value="1" <?php print (isset($content) && $content->_in_frontpage) ? 'checked' : ''; ?> />
								<?php _e('Contenido de Portada', 'content'); ?>
							</label>
						</div>
						<?php endif; ?>
						<?php if( $type == 'post' ): ?>
						<div class="form-group">
							<label class="has-popover" data-content="<?php _e('CONTENT_FEATURED_POST'); ?>">
								<input type="checkbox" name="meta[_featured]" value="1" <?php print (isset($content) && $content->_featured == 1) ? 'checked' : ''; ?> />
								<?php _e('Destacado', 'content'); ?>
							</label>
						</div>
						<?php endif; ?>
						<?php SB_Module::do_action('content_options', isset($content) ? $content : null); ?>
						<p class="text-center">
							<a class="btn btn-secondary has-popover" href="<?php print $back_link; ?>"
								data-content="<?php print SBText::_('CONTENT_CANCEL'); ?>">
								<?php print SB_Text::_('Cancelar', 'content'); ?></a>
							<button type="submit" class="btn btn-secondary has-popover" data-content="<?php print SBText::_('CONTENT_SAVE'); ?>">
								<?php print SB_Text::_('Guardar', 'content'); ?></button>
						</p>
					</div>
				</div>
				<?php SB_Module::do_action('after_article_options', isset($content) ? $content : null); ?>
				<?php if( isset($content) && $content->type == 'page' ): ?>
				<div class="widget">
					<h2 class="title has-popover" data-content="<?php print SBText::_('CONTENT_WH_SECTIONS'); ?>">
						<?php print SB_Text::_('Opciones de Plantilla', 'content'); ?>
					</h2>
					<div class="body">
						<select name="meta[_template]" class="form-control">
							<option value="-1"><?php _e('-- plantilla --', 'content'); ?></option>
							<?php foreach(lt_content_get_page_templates() as $tpl): ?>
							<option value="<?php print $tpl['file']; ?>" 
								<?php print isset($content) && $content->_template == $tpl['file'] ? 'selected' : '';?>>
								<?php print $tpl['name']; ?>
							</option>
							<?php endforeach; ?>
						</select>
						<?php foreach(lt_content_get_page_templates() as $tpl): if( !isset($tpl['fields']) || !is_array($tpl['fields']) ) continue;?>
						<?php foreach($tpl['fields'] as $field): $meta_key = '_' . $field; ?>
						<div class="form-group">
							<label><?php _e($field, 'content'); ?></label>
							<input type="text" name="meta[_<?php print $field?>]" 
									value="<?php print isset($content) ? $content->$meta_key : '' ?>" class="form-control" />
						</div>
						<?php endforeach; ?>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="widget">
					<h2 class="title has-popover" data-content="<?php print SBText::_('CONTENT_WH_SECTIONS'); ?>">
						<?php print SB_Text::_('Secciones', 'content'); ?>
					</h2>
					<div class="body">
						<?php print sb_sections_html_list(array('checked' => isset($content) ? $content->GetSectionIds() : array())); ?>
					</div>
				</div>
				<?php endif; ?>
				<?php if( isset($content) && $content->type == 'post' ): ?>
				<div class="widget">
					<h2 class="title has-popover" data-content="<?php print SBText::_('CONTENT_WH_CATEGORIES'); ?>">
						<?php _e('Categories', 'content'); ?>
					</h2>
					<div class="body">
						<?php print sb_categories_html_list(array('checked' => isset($content) ? $content->GetSectionIds() : array()))?>
					</div>
				</div>
				<?php endif; ?>
				<?php if( isset($content) ): ?>
				<div class="widget">
					<h2 class="title has-popover" data-content="<?php print SBText::_('CONTENT_WH_FEATURED_IMAGE'); ?>">
						<?php _e('Imagen Destacada', 'content'); ?>
					</h2>
					<div class="body">
						<div id="featured-image-container">
							<?php if( $content->_featured_image ): ?>
							<img src="<?php print UPLOADS_URL . '/' . $content->_featured_image; ?>" alt="" class="img-thumbnail" />
							<?php endif; ?>
						</div>
						<div>&nbsp;</div>
						<div id="select-featured-image" class="btn btn-default btn-xs"><?php _e('Subir imagen', 'content'); ?></div>
						<a href="javascript:;" id="btn-remove-featured-image" class="btn btn-danger btn-xs"
							style="<?php print $content->_featured_image ? '' : 'display:none;'; ?>">
							<?php _e('Borrar', 'content'); ?>
						</a>
					</div>
				</div>
				<?php endif; ?>
				
				<?php SB_Module::do_action('article_sidebar', isset($content) ? $content : null); ?>
			</div>
		</div>
	</form>
	<script type="text/javascript">
	jQuery(function()
	{
		jQuery('.fg_color_picker').ColorPicker({
			onChange: function (hsb, hex, rgb) 
			{
				jQuery('#article-fg-color').val('#' + hex);
				jQuery('.fg_color_picker i').css('backgroundColor', '#' + hex);
			}
		});
		jQuery('.bg_color_picker').ColorPicker({
			onChange: function (hsb, hex, rgb) 
			{
				jQuery('#article-color-input').val('#' + hex);
				jQuery('.bg_color_picker i').css('backgroundColor', '#' + hex);
			}
		});
		jQuery('#remove-banner').click(function()
		{
			jQuery.post('<?php print $remove_banner_link; ?>', 'mod=content&task=remove_banner', function(res){});
			jQuery('#the-banner img:first').css('display', 'none');
			jQuery('#remove-banner').css('display', 'none');
			return false;
		});
		jQuery('#remove-button-image').click(function()
		{
			var params = 'mod=content&task=remove_button_image';
			<?php if( isset($content) ):  ?>
			params += '&id=<?php print $content->content_id; ?>';
			<?php else: ?>
			params += '&id=temp';
			<?php endif; ?>
			jQuery.post('index.php', params, function(res){});
			jQuery('#button-image').css('display', 'none');
			//jQuery('#remove-banner').css('display', 'none');
			return false;
		});
		var uploader = new qq.FineUploaderBasic({
			//element: document.getElementById("uploader"),
			//template: 'qq-template-gallery',
			button: document.getElementById('select-banner'),
			request: {
				endpoint: '<?php print $upload_endpoint; ?>'
			},
			validation: {
				allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
			},
			callbacks: 
			{
				onSubmit: function(id, fileName) 
				{
					//$messages.append('<div id="file-' + id + '" class="alert" style="margin: 20px 0 0"></div>');
				},
				onUpload: function(id, fileName) 
				{
					jQuery('#uploading').css('display', 'block');
				},
				onProgress: function(id, fileName, loaded, total) 
				{
					
				},
				onComplete: function(id, fileName, responseJSON) 
				{
					
					jQuery('#uploading').css('display', 'none');
					if (responseJSON.success) 
					{
						jQuery('#the-banner img:first').attr('src', responseJSON.image_url).css('display', 'inline');
						jQuery('#remove-banner').css('display', 'inline');
		            } 
		            else 
					{
						alert(responseJSON.error);
		            }
				}
			}
		});
		var button_uploader = new qq.FineUploaderBasic({
			//element: document.getElementById("uploader"),
			//template: 'qq-template-gallery',
			button: document.getElementById('select-button-image'),
			request: {
				endpoint: '<?php print SB_Route::_('index.php?mod=content&task=upload_button_image' . (isset($content) ? '&id='.$content->content_id : '')); ?>'
			},
			validation: {
				allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']
			},
			callbacks: 
			{
				onUpload: function(id, fileName) 
				{
					jQuery('#uploading-btn-img').css('display', 'block');
				},
				onProgress: function(id, fileName, loaded, total) 
				{
					
				},
				onComplete: function(id, fileName, responseJSON) 
				{
					jQuery('#uploading-btn-img').css('display', 'none');
					if (responseJSON.success) 
					{
						jQuery('#button-image').css('display', 'inline');
						jQuery('#button-image img:first').attr('src', responseJSON.image_url).css('display', 'inline');
						jQuery('#remove-banner').css('display', 'inline');
		            } 
		            else 
					{
						alert(responseJSON.error);
		            }
				}
			}
		});
		<?php if(isset($content)): ?>
		window.featured_uploader = new qq.FineUploaderBasic({
			button: document.getElementById('select-featured-image'),
			request: {
				endpoint: '<?php print SB_Route::_('index.php?mod=content&task=upload_featured_image&id='.$content->content_id); ?>'
			},
			validation: {allowedExtensions: ['jpeg', 'jpg', 'gif', 'png']},
			callbacks: 
			{
				onUpload: function(id, fileName) 
				{
					//jQuery('#uploading-btn-img').css('display', 'block');
				},
				onComplete: function(id, fileName, res) 
				{
					//jQuery('#uploading-btn-img').css('display', 'none');
					if (res.success) 
					{
						jQuery('#featured-image-container').append('<img src="'+res.thumbnail_url+'" alt="" class="img-thumbnail" />');
						jQuery('#btn-remove-featured-image').css('display', 'inline');
		            } 
		            else 
					{
						alert(res.error);
		            }
				}
			}
		});
		jQuery(document).on('click', '#btn-remove-featured-image', function()
		{
			jQuery.get('<?php print SB_Route::_('index.php?mod=content&task=delete_featured_image&id='.$content->content_id)?>', function(res)
			{
				if( res.status == 'ok' )
				{
					jQuery('#featured-image-container').html('');
					jQuery('#btn-remove-featured-image').css('display', 'none');
				}
				else
				{
					alert(res.error);
				}
			});
		});
		<?php endif; ?>
		jQuery('input[name=qqfile]').attr('title', '<?php print SB_Text::_('Sube una imagen de tu equipo')?>');
	});
	</script>
</div>
<link rel="stylesheet" href="<?php print BASEURL; ?>/js/colorpicker/css/colorpicker.css" />
<script src="<?php print BASEURL; ?>/js/colorpicker/js/colorpicker.js"></script>