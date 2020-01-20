/**
 * 
 */
var rrhh_profile = 
{
	RefreshAcademicRecords: function()
	{
		jQuery.post('index.php', 'mod=rrhh&task=ajax&action=academic_records', function(res)
		{
			jQuery('#table-academic-records tbody').html(res.html);
		});
		rrhh_profile.RefreshCV();
	},
	RefreshCV: function()
	{
		jQuery.post('index.php', 'mod=rrhh&task=ajax&action=get_cv', function(res)
		{
			jQuery('#my-cv-container').html(res);
		});
	},
	RefreshSistemas: function()
	{
		jQuery.post('index.php', 'mod=rrhh&task=ajax&action=get_sistemas', function(res)
		{
			jQuery('#table-sistemas tbody').html(res.html);
		});
	},
	RefreshIdiomas: function()
	{
		jQuery.post('index.php', 'mod=rrhh&task=ajax&action=get_idiomas', function(res)
		{
			jQuery('#table-idiomas tbody').html(res.html);
		});
	},
	RefreshCursos: function()
	{
		jQuery.post('index.php', 'mod=rrhh&task=ajax&action=get_cursos', function(res)
		{
			jQuery('#table-cursos tbody').html(res.html);
		});
	},
	SetEvents: function()
	{
		//###########################//
		//##acedemic records events##//
		//###########################//
		jQuery('#btn-add-record').click(function()
		{
			jQuery('#ar_id').val(0);
			jQuery('#study_level_id').val('');
			jQuery('#center_name').val('');
			jQuery('#degree').val('');
			jQuery('#degree_date').val('');
			jQuery('#degree_city').val('');
			jQuery('#degree_country_code').val('');
			jQuery('#modal-formacion').modal('show');
			jQuery('#btn-save-formacion').prop('disabled', false);
			return false;
		});
		jQuery(document).on('click', '.btn-edit-ar', function()
		{
			jQuery('#ar_id').val(this.dataset.id);
			jQuery('#study_level_id').val(this.dataset.study_level_id);
			jQuery('#center_name').val(this.dataset.center_name);
			jQuery('#degree').val(this.dataset.degree);
			jQuery('#degree_date').val(this.dataset.degree_date);
			jQuery('#degree_city').val(this.dataset.degree_city);
			jQuery('#degree_country').val(this.dataset.degree_country_code);
			jQuery('#btn-save-formacion').prop('disabled', false);
			jQuery('#modal-formacion').modal('show');
			return false;
		});
		jQuery(document).on('click', '.btn-delete-ar', function()
		{
			jQuery.post('index.php', 'mod=rrhh&task=ajax&action=delete_academic_record&id=' + this.dataset.id, function(res)
			{
				rrhh_profile.RefreshAcademicRecords();
			});
			
			return false;
		});
		jQuery('#form-formacion').submit(function()
		{
			var fields = jQuery(this).find('.form-control.required');
			var submit = true;
			jQuery.each(fields, function(i, field)
			{
				if( field.value.length <= 0 || field.value == '-1' )
				{
					alert('Debe ingresar la informacion solicitada.');
					field.focus();
					submit = false;
					return false;
				}
			});
			if( submit )
			{
				jQuery('#btn-save-formacion').prop('disabled', true);
				var params = jQuery(this).serialize() + '&ajax=1';
				jQuery.post('index.php', params, function(res)
				{
					jQuery('#fa-messages').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.message+'</div>');
					jQuery('#modal-formacion').modal('hide');
					rrhh_profile.refreshAcademicRecords();
					jQuery('#btn-save-formacion').prop('disabled', false);
				});
			}
			return false;
		});
		//##tab sistemas
		jQuery('#btn-add-sistema').click(function(e)
		{
			jQuery('#sistema_id').val(-1);
			jQuery('#otro-sistema').css('display', 'none');
			jQuery('#sistema-nivel,#sistema-nombre, #otro-sistema').val('');
			jQuery('#modal-sistema').modal('show');
			return false;
		});
		jQuery('#sistema-nombre').change(function()
		{
			if( this.value == 'otro' )
				jQuery('#otro-sistema').css('display', 'block');
			else
				jQuery('#otro-sistema').css('display', 'none');
		});
		jQuery(document).on('click', '.btn-edit-sistema', function(e)
		{
			jQuery('#sistema_id').val(this.dataset.id);
			if( this.dataset.sistema == 'otro' )
			{
				jQuery('#otro-sistema').css('display', 'block').val(this.dataset.otro);
			}
			else
			{
				jQuery('#otro-sistema').css('display', 'none');
			}
			jQuery('#sistema-nivel').val(this.dataset.nivel);
			jQuery('#sistema-nombre').val(this.dataset.sistema);
			jQuery('#modal-sistema').modal('show');
			return false;
		});
		jQuery(document).on('click', '.btn-delete-sistema', function(e)
		{
			jQuery.get('index.php?mod=rrhh&task=ajax&action=delete_sistema&id='+this.dataset.id, function(res)
			{
				if( res.status == 'ok' )
				{
					jQuery('#sistemas-messages').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.message+'</div>');
				}
				rrhh_profile.RefreshSistemas();
				rrhh_profile.RefreshCV();
			});
			return false;
		});
		jQuery('#form-sistema').submit(function()
		{
			var params = jQuery(this).serialize();
			jQuery.post('index.php', params, function(res)
			{
				jQuery('#modal-sistema').modal('hide');
				if( res.status == 'ok' )
				{
					jQuery('#sistemas-messages').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.message+'</div>');
				}
				else
				{
					jQuery('#sistemas-messages').append('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.error+'</div>');
				}
				rrhh_profile.RefreshSistemas();
				rrhh_profile.RefreshCV();
			});
			return false;
		});
		//#####################
		//## tab idiomas ######
		//#####################
		jQuery('#btn-add-idioma').click(function(e)
		{
			jQuery('#idioma_id').val(-1);
			jQuery('#idioma,#nivel_lectura, #nivel_escritura,#nivel_conversacion').val('');
			jQuery('#modal-idioma').modal('show');
			return false;
		});
		jQuery(document).on('click', '.btn-edit-idioma', function(e)
		{
			jQuery('#idioma_id').val(this.dataset.id);
			jQuery('#idioma').val(this.dataset.idioma);
			jQuery('#nivel_lectura').val(this.dataset.nivel_lectura);
			jQuery('#nivel_escritura').val(this.dataset.nivel_escritura);
			jQuery('#nivel_conversacion').val(this.dataset.nivel_conversacion);
			jQuery('#modal-idioma').modal('show');
			return false;
		});
		jQuery(document).on('click', '.btn-delete-idioma', function(e)
		{
			jQuery.get('index.php?mod=rrhh&task=ajax&action=delete_idioma&id='+this.dataset.id, function(res)
			{
				if( res.status == 'ok' )
				{
					jQuery('#idiomas-messages').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.message+'</div>');
				}
				rrhh_profile.RefreshIdiomas();
				rrhh_profile.RefreshCV();
			});
			return false;
		});
		jQuery('#form-idioma').submit(function()
		{
			var params = jQuery(this).serialize();
			jQuery.post('index.php', params, function(res)
			{
				jQuery('#modal-idioma').modal('hide');
				if( res.status == 'ok' )
				{
					jQuery('#idiomas-messages').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.message+'</div>');
				}
				else
				{
					jQuery('#idiomas-messages').append('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.error+'</div>');
				}
				rrhh_profile.RefreshIdiomas();
				rrhh_profile.RefreshCV();
			});
			return false;
		});
		//#####################
		//## tab cursos ######
		//#####################
		jQuery('#btn-add-curso').click(function(e)
		{
			jQuery('#curso_id').val(-1);
			var form = jQuery('#form-curso').get(0);
			form.tipo_curso.value = '-1';
			form.nombre.value = '';
			form.centro_estudio.value = '';
			form.pais.value = '';
			form.modalidad.value = '';
			form.horas.value = 0;
			jQuery('#modal-curso').modal('show');
			return false;
		});
		jQuery(document).on('click', '.btn-edit-curso', function(e)
		{
			jQuery('#curso_id').val(this.dataset.id);
			var form = jQuery('#form-curso').get(0);
			form.tipo_curso.value 		= this.dataset.tipo_curso;
			form.nombre.value 			= this.dataset.nombre;
			form.centro_estudio.value 	= this.dataset.centro_estudio;
			form.pais.value 			= this.dataset.pais;
			form.modalidad.value 		= this.dataset.modalidad;
			form.horas.value 			= this.dataset.horas;
			form.fecha_inicio.value		= this.dataset.fecha_inicio;
			form.fecha_fin.value		= this.dataset.fecha_fin;
			jQuery('#modal-curso').modal('show');
			return false;
		});
		jQuery(document).on('click', '.btn-delete-curso', function(e)
		{
			jQuery.get('index.php?mod=rrhh&task=ajax&action=delete_curso&id='+this.dataset.id, function(res)
			{
				if( res.status == 'ok' )
				{
					jQuery('#cursos-messages').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.message+'</div>');
				}
				rrhh_profile.RefreshCursos();
				rrhh_profile.RefreshCV();
			});
			return false;
		});
		jQuery('#form-curso').submit(function()
		{
			var params = jQuery(this).serialize();
			jQuery.post('index.php', params, function(res)
			{
				jQuery('#modal-curso').modal('hide');
				if( res.status == 'ok' )
				{
					jQuery('#cursos-messages').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.message+'</div>');
				}
				else
				{
					jQuery('#cursos-messages').append('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>'+res.error+'</div>');
				}
				rrhh_profile.RefreshCursos();
				rrhh_profile.RefreshCV();
			});
			return false;
		});
	}
};
jQuery(function()
{
	jQuery('.datepicker').datepicker({
		format: lt.dateformat,
		weekStart: 0,
		//todayBtn: true,
		autoclose: true,
	    todayHighlight: true,
	    language: lt.lang
	    //clearBtn: true,
	    //startDate: 2015//'3d'
	});
	//##validate personal info data
	jQuery('#form-datos').submit(function()
	{
		var pass = true;
		/*
		jQuery(this).find('.required').each(function(i, obj)
		{
		});
		*/
		if( this.first_name.value.trim().length <= 0 )
		{
			alert('Debe ingresar su nombre');
			return false;
		}
		if( this.image.value.trim().length > 0 && document.getElementById(adjunto).value == "si")
		{

		}
		else
		{
			alert('Debe adjuntar una fotografía');
			return false;
		}
		if( this.fathers_lastname.value.trim().length <= 0 )
		{
			alert('Debe ingresar su apellido parterno');
			return false;
		}
		if( this.mothers_lastname.value.trim().length <= 0 )
		{
			alert('Debe ingresar su apellido materno');
			return false;
		}
		if( this.birthday.value.length <= 0 )
		{
			alert('Debe ingresar su fecha de nacimiento');
			return false;
		}
		if( this.city_birth.value.length <= 0 )
		{
			alert('Debe ingresar su ciudad de nacimiento');
			return false;
		}
		if( this.telephone.value.trim().length <= 0 )
		{
			alert('Debe ingresar su teléfono');
			return false;
		}
		if( !/^\d+$/.test(this.telephone.value.trim()) || this.telephone.value.trim().length < 7 || this.telephone.value.trim().length > 7 )
		{
			alert('El numero de teléfono no es valido');
			return false;
		}
		var mobile = this.mobile.value.trim();
		if( mobile.length > 0 && !/^\d+$/.test(mobile) )
		{
			alert('El numero de celular es invalido');
			return false;
		}
        if( mobile.length > 0 && (mobile.length < 8 || mobile.length > 8)  )
		{
			alert('El numero de celular es inválido');
			return false;
		}
		if( this.email.value.length <= 0 )
		{
			alert('Debe ingresar su email');
			return false;
		}
		///^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i
		var document_type = jQuery('[name=document_type]');
		if( !document_type.get(0).checked && !document_type.get(1).checked && !document_type.get(2).checked )
		{
			alert('Debe seleccionar el tipo de documento');
			return false;
		}
		if( this.document.value.length <= 0 )
		{
			alert('Debe ingresar el numero de documento');
			return false;
		}
        if( !/^\d+$/.test(this.document.value.trim()) )
        {
            alert('El numero de documento es invalido');
			return false;
        }
		return pass;
	});
	rrhh_profile.SetEvents();
});
