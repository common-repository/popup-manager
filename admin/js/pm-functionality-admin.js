(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */

})( jQuery );

jQuery(document).ready(function($) {
	jQuery('#pm-email-template').on('input', function() {
		jQuery('#pm-email-template-field').html('');
		jQuery('#pm-email-template-action').html('');
		if ( jQuery('<div>'+jQuery('#pm-email-template').val()+'</div>').find('form').length ) {
			jQuery('#pm-email-template-action').html(jQuery('<div>'+jQuery('#pm-email-template').val()+'</div>').find('form').attr('action'));
			jQuery('.email-popup-main-form').attr('action', jQuery('<div>'+jQuery('#pm-email-template').val()+'</div>').find('form').attr('action'));
		}
		if ( jQuery(jQuery('#pm-email-template').val()).find('input').length ) {
			jQuery('#pm-email-template-field').html(jQuery(jQuery('#pm-email-template').val()).find('input').length);
		}
	});

	jQuery('#edit-email-template').on('click', function() {
		jQuery('.email-form').hide();
		jQuery('.email-inputs').hide();
		if ( jQuery('#pm-email-template').val().indexOf('form') >= 1 && jQuery('#pm-email-template').val().indexOf('input') > 1 ) {
			var email_template = '<div>'+jQuery('#pm-email-template').val()+'</div>';
			var email_form = jQuery(email_template).find('form').length;
			var email_inputs = jQuery(email_template).find('input').length;
			var form_action = jQuery(email_template).find('form').attr('action');
			var form_method = jQuery(email_template).find('form').attr('method');
			var form_name = jQuery(email_template).find('form').attr('name');
			var form_id = jQuery(email_template).find('form').attr('id');
			if ( !email_form ) {
				jQuery('.email-form').show();
				return false;
			} else if ( !email_inputs ) {
				jQuery('.email-inputs').show();
				return false;
			} else {
				jQuery('.email-popup-main-form').html('').attr('method', '').attr('name', '').attr('id', '');
				jQuery('.email-popup-main-form').attr('method', form_method).attr('name', form_name).attr('id', form_id);
				jQuery.each(jQuery(email_template).find('input:not([readonly="readonly"]), button, select, label'), function() {
					if ( jQuery(this).parent().attr('aria-hidden') || jQuery(this).attr('disabled') == 'disabled' ) {
						// Do nothing
					} else if ( typeof jQuery(this).attr('class') != 'undefined' && jQuery(this).attr('class').indexOf('form-input-') == 0 ) {
						if ( jQuery(this).attr('type') != 'hidden' ) {
							if ( jQuery(this).attr('type') != 'checkbox' && jQuery(this).attr('type') != 'radio' ) {
								jQuery('.email-popup-main-form').append('<div class="form-input-wrapper">'+jQuery(this)['0'].outerHTML+'</div>');
							} else {
								jQuery('.email-popup-main-form').append('<div class="form-input-wrapper">'+jQuery(this)['0'].outerHTML+jQuery(this).parent().text()+'</div>');
							}
						} else {
							jQuery('.email-popup-main-form').append(jQuery(this)['0'].outerHTML);
						}

					} else {
						if ( jQuery(this).attr('type') != 'hidden' && jQuery(this).parent().attr('class') != 'field-shift' ) {
							var label = '';
							if ( jQuery(this).prev().prop('tagName') == 'LABEL' ) {
								label = jQuery(this).prev().text();
							} else if ( jQuery(this).parent().find('label').length ) {
								label = jQuery(this).parent().find('label').text();
							} else if ( jQuery(this).parent().parent().find('label').length ) {
								label = jQuery(this).parent().parent().find('label').text();
							} else if ( jQuery(this).parent().parent().parent().parent().parent().find('label').length ) {
								label = jQuery(this).parent().parent().parent().parent().parent().find('label').text();
							}

							if ( jQuery(this).attr('type') != 'text' && jQuery(this).attr('type') != 'email' && jQuery(this).attr('type') != 'url' ) {
								label = '';
							} else {
								label = label.replace(':', '');
							}

							var rlabel = '';
							if ( jQuery(this).attr('type') == 'radio' && jQuery(this).parent().prop('tagName') == 'LABEL' ) {
								rlabel = jQuery(this).parent().text();
							} else if ( jQuery(this).attr('type') == 'checkbox' && jQuery(this).parent().prop('tagName') == 'LABEL' ) {
								rlabel = jQuery(this).parent().text();
							}

							var llabel = '';
							if ( jQuery(this).prop('tagName') == 'SELECT' && jQuery(this).parent().parent().find('label').length ) {
								llabel = '<label>'+jQuery(this).parent().parent().find('label').text()+'</label>';
							}

							var label_class = '';
							if ( jQuery(this).prop('tagName') == 'LABEL' ) {
								if ( jQuery(this).children().length > 0 ) {
									return;
								} else {
									if ( jQuery(this).next().find('input[type="checkbox"], input[type="radio"], select').length ) {
										label_class = ' label';
									} else {
										return;
									}
								}
							}

							if ( jQuery(this).attr('type') != 'image' ) {
								jQuery('.email-popup-main-form').append('<div class="form-input-wrapper">'+llabel+jQuery(this).attr('class', 'form-input-'+Math.floor((Math.random() * 100000) + 1)+label_class).attr('style', '').attr('placeholder', label.replace(/\n/g, ""))['0'].outerHTML+rlabel+'</div>');
							} else {
								jQuery('.email-popup-main-form').append('<div class="form-input-wrapper">'+llabel+jQuery(this).attr('class', 'form-input-'+Math.floor((Math.random() * 100000) + 1)).attr('type', 'submit').attr('src', '').attr('style', '')['0'].outerHTML+rlabel+'</div>');
							}
						} else {
							if ( jQuery(this).parent().attr('class') != 'field-shift' ) {
								jQuery('.email-popup-main-form').append(jQuery(this).attr('class', 'form-input-'+Math.floor((Math.random() * 100000) + 1))['0'].outerHTML);
							} else {
								if ( jQuery(this).prop('tagName') == 'INPUT' ) {
									jQuery('.email-popup-main-form').append(jQuery(this).attr('type', 'hidden').attr('class', 'form-input-'+Math.floor((Math.random() * 100000) + 1))['0'].outerHTML);
								}
							}
						}
					}
				});
				jQuery('#steps-uid-1-t-1').parent().removeClass('current').addClass('disabled');
				jQuery('#steps-uid-1-t-2').parent().addClass('current').removeClass('disabled');
				jQuery('.email-template-step1').slideUp();
				jQuery('.email-template-step2').slideDown( '400', function() {
					getVisible();
				});   
			}
			jQuery('div[contenteditable="false"]').attr('contenteditable' , 'true');
		} else {
			jQuery('.email-form').show();
		}
	});

	function pm_validate_url( url ) {
		return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url)
	}

	jQuery('#edit-image-template').on('click', function() {
		if ( jQuery('#pm-image-url').val() == '' ) {
			jQuery('#pm-image-url').parent().addClass('invalid');
		}
		if ( jQuery('#pm-image-to-url').val() != '#' && !pm_validate_url(jQuery('#pm-image-to-url').val()) ) {
			jQuery('#pm-image-to-url').parent().addClass('invalid');
		}
		if ( jQuery('#pm-image-url').val() != '' && ( pm_validate_url(jQuery('#pm-image-to-url').val()) || jQuery('#pm-image-to-url').val() == '#' ) ) {
			jQuery('.email-popup-preview').css('background', 'url('+jQuery('#pm-image-url').val()+') no-repeat');

			var img_url = jQuery('#pm-image-url').val();
			var background_image = new Image();
			background_image.src = img_url;
			$(background_image).one('load',function(){
				orgWidth = background_image.width;
				orgHeight = background_image.height;

				setTimeout(function() {
					var container_width = parseInt(jQuery('.email-template-right .pm-card-box').width());
					var container_height = parseInt(jQuery('.email-template-right .pm-card-box').height());

					if ( orgWidth > container_width ) {
						orgWidth = container_width*0.9;
					}

					if ( orgHeight > container_height ) {
						orgHeight = container_height*0.9;
					}

					jQuery('.email-popup-preview').style('width', orgWidth+'px', 'important');
					jQuery('.email-popup-preview').style('height', orgHeight+'px', 'important');
				}, 350);

				jQuery('.email-popup-preview').style('background-image', 'url('+img_url+')', 'important');
			});

			jQuery('.email-popup-preview').attr('href', jQuery('#pm-image-to-url').val());
			jQuery('#steps-uid-1-t-2').parent().addClass('current').removeClass('disabled');
			jQuery('#steps-uid-1-t-1').parent().removeClass('current').addClass('disabled');
			jQuery('.email-template-step1').slideUp();
			jQuery('.email-template-step2').slideDown( '400', function() {
				getVisible();
			});
		}
	});

	jQuery('#edit-email-template2').on('click', function() {
		jQuery('.email-template-step2 .email-template-middle, .email-template-step2 .email-template-left, .email-template-step2 .pm-step2-nav').slideUp();
		jQuery('.email-template-step3').slideDown();
		jQuery('body').addClass('pm-disable-edit');
		jQuery('div[contenteditable=true], a[contenteditable=true]').attr('contenteditable', false);
	});

	jQuery('#back-edit-email-template').on('click', function() {
		jQuery('.email-template-step2').slideUp();
		jQuery('.email-template-step1').slideDown();
	});

	jQuery('#back-email-template-style').on('click', function() {
		jQuery('.email-template-step3').slideUp();
		jQuery('.email-template-step2 .email-template-middle, .email-template-step2 .email-template-left, .email-template-step2 .pm-step2-nav').slideDown();
		jQuery('div[contenteditable=false], a[contenteditable=false]').attr('contenteditable', true);
		jQuery('body').removeClass('pm-disable-edit');
	});

	jQuery('.wpcolorpicker-overlay').wpColorPicker({

		change: function(event, ui) {
			jQuery('.email-popup-preview-box-overlay').css('background', ui.color.toString());
		},
		clear: function() {
			jQuery('.email-popup-preview-box-overlay').css('background', '');
		}
	});

	jQuery('.wpcolorpicker-boxshadow').wpColorPicker({
		change: function(event, ui) {
			var shadow_horizontal = jQuery('#email-template-box-shadow-horizontal').val();
			var shadow_vertical = jQuery('#email-template-box-shadow-vertical').val();
			var shadow_blur = jQuery('#email-template-box-shadow-blur').val();
			var shadow_spread = jQuery('#email-template-box-shadow-spread').val();
			var shadow_color_code = ui.color.toString();
			var shadow_color_hex = pm_hexToRgb(shadow_color_code);
			var shadow_color_opacity = jQuery('.colorpicker-opacity.box-shadow').slider("option", "value");
			var shadow_color = 'rgba('+shadow_color_hex.r+', '+shadow_color_hex.g+', '+shadow_color_hex.b+', '+shadow_color_opacity+')';

			var shadow_type = '';
			if ( jQuery('#email-template-box-shadow-type').val() == 'inset' ) {
				shadow_type = 'inset';
			}
			var box_shadow_style = shadow_horizontal+'px '+shadow_vertical+'px '+shadow_blur+'px '+shadow_spread+'px '+shadow_color+' '+shadow_type;

			jQuery('.email-popup-preview').css('box-shadow', box_shadow_style);
			// jQuery('.email-popup-preview-box-overlay').css('background', ui.color.toString());
		},
		clear: function() {
			// jQuery('.email-popup-preview-box-overlay').css('background', '');
		}
	});

	jQuery('.colorpicker-opacity:not(.box-shadow)').slider({
		min: 0,
		max: 1,
		step: 0.1,
		value: 1,
		slide: function( event, ui ) {
			jQuery('.email-popup-preview-box-overlay').css('opacity', ui.value);
		}
	});

	jQuery('.colorpicker-opacity.box-shadow').slider({
		min: 0,
		max: 1,
		step: 0.1,
		value: 1,
		slide: function( event, ui ) {
			var shadow_horizontal = jQuery('#email-template-box-shadow-horizontal').val();
			var shadow_vertical = jQuery('#email-template-box-shadow-vertical').val();
			var shadow_blur = jQuery('#email-template-box-shadow-blur').val();
			var shadow_spread = jQuery('#email-template-box-shadow-spread').val();
			var shadow_color_code = jQuery('#email-template-box-shadow-color').val();
			var shadow_color_hex = pm_hexToRgb(shadow_color_code);
			var shadow_color_opacity = ui.value;
			var shadow_color = 'rgba('+shadow_color_hex.r+', '+shadow_color_hex.g+', '+shadow_color_hex.b+', '+shadow_color_opacity+')';

			var shadow_type = '';
			if ( jQuery('#email-template-box-shadow-type').val() == 'inset' ) {
				shadow_type = 'inset';
			}
			var box_shadow_style = shadow_horizontal+'px '+shadow_vertical+'px '+shadow_blur+'px '+shadow_spread+'px '+shadow_color+' '+shadow_type;

			jQuery('.email-popup-preview').css('box-shadow', box_shadow_style);
		}
	});

	jQuery(document).on('click', '.pm-schedule-popup', function() {
		jQuery(this).parent().find('.popup-schedule-dialog').dialog({
			width: 500,
			dialogClass: "popup-schedule",
			modal: true,
			resizable: false,
			draggable: false
		});
	});

	jQuery(document).on('click', '.schedule-date-ok', function() {
		var popup_schedule = jQuery(this);
		var errors = 0;

		popup_schedule.parent().parent().find('.schedule-date-start').removeClass('invalid');
		popup_schedule.parent().parent().find('.schedule-date-end').removeClass('invalid');

		if ( popup_schedule.parent().parent().find('.schedule-time-start').val() == '' ) {
			popup_schedule.parent().parent().find('.schedule-time-start').val('00:00:00');
		}

		if ( popup_schedule.parent().parent().find('.schedule-time-end').val() == '' ) {
			popup_schedule.parent().parent().find('.schedule-time-end').val('23:59:59');
		}

		if ( popup_schedule.parent().parent().find('.schedule-date-start').val() == '' ) {
			popup_schedule.parent().parent().find('.schedule-date-start').addClass('invalid');
			errors++;
		} else {
			popup_schedule.parent().parent().find('.schedule-date-start').removeClass('invalid');
		}

		if ( popup_schedule.parent().parent().find('.schedule-date-end').val() == '' ) {
			popup_schedule.parent().parent().find('.schedule-date-end').addClass('invalid');
			errors++;
		} else {
			popup_schedule.parent().parent().find('.schedule-date-end').removeClass('invalid');
		}

		if ( errors == 0 ) {
			jQuery.ajax({
				type: 'POST',
				url: pm_main.ajaxurl,
				data: { 
					'action': 'pm_popup_schedule',
					'popup_id': popup_schedule.parent().parent().find('.popup-schedule-id').val(),
					'schedule_start': popup_schedule.parent().parent().find('.schedule-date-start').val()+' '+popup_schedule.parent().parent().find('.schedule-time-start').val(),
					'schedule_end': popup_schedule.parent().parent().find('.schedule-date-end').val()+' '+popup_schedule.parent().parent().find('.schedule-time-end').val(),
				},
				success: function(data) {
					if ( data == 'success' ) {
						window.location = window.location.href;
					}
				}
			});
		}
	});

	jQuery(document).on('input', '.schedule-date-start, .schedule-date-end', function() {
		var text = jQuery(this).val();
		var input_element = jQuery(this);
		input_element.removeClass('invalid');
		if(/([0-1][1-9])\/([0-3][0-9]|[3][0-1])\/((19|20)[0-9]{2})/.test(text)){
			var tokens = text.split('/');
			var day    = parseInt(tokens[0], 10);
			var month  = parseInt(tokens[1], 10);
			var year   = parseInt(tokens[2], 10);
		} else {
			input_element.addClass('invalid');
		}
	});

	jQuery(document).on('click', '.schedule-date-cancel', function() {
		jQuery(this).parent().parent().dialog( "destroy" );
	});

	jQuery('.schedule-time-start, .schedule-time-end').mask("99:99:99",{
		placeholder:"hh:mm:ss",
		completed: function() {
			var new_string = '';
			var value = this.val().split(':');
			var hours = parseInt(value['0']);
			var minutes = parseInt(value['1']);
			var seconds = parseInt(value['1']);

			// // Validation
			if ( hours > 23 ) { new_string += '23:' } else { new_string += hours + ':' }
			if ( minutes > 59 ) { new_string += '59:' } else { new_string += minutes + ':' }
			if ( seconds > 59 ) { new_string += '59' } else { new_string += seconds }

			this.val( new_string );
		}
	});

	jQuery(document).on('blur', '.schedule-time-start, .schedule-time-end', function() {
		console.log(jQuery(this).val());
	});
	
	var $colorpicker2;
	jQuery('.wpcolorpicker:not(.popup)').wpColorPicker({
		change: function(event, ui) {
			$colorpicker2 = jQuery(this);
			if ( $colorpicker2.attr('id').replace('email-template-', '') == 'background-color' && ui.color.toString() == '#010000' ) {
				jQuery(this).parent().parent().find('.wp-color-result').css('background-color', '#fff');
			} else {
				jQuery(jQuery('#email-template-last-clicked').val()).css($colorpicker2.attr('id').replace('email-template-', ''), ui.color.toString());
			}
		},
		clear: function() {
			jQuery(jQuery('#email-template-last-clicked').val()).css($colorpicker2.attr('id').replace('email-template-', ''), '');
		}
	});

	jQuery('.wpcolorpicker.popup').wpColorPicker({
		change: function(event, ui) {
			jQuery('.email-popup-preview').css('background-color', ui.color.toString());
		},
		clear: function() {
			jQuery('.email-popup-preview').css('background-color', '');
		}
	});

	jQuery('.pm-number-minus').on('click', function() {
		if ( jQuery(this).parent().find('input').val() == '' ) {
			jQuery(this).parent().find('input').val('0');
		}
		jQuery(this).parent().find('input').val(parseInt(jQuery(this).parent().find('input').val())-1);
	});

	var $pm_number_minus;
	jQuery('.pm-number-minus').on('mousedown', function() {
		var current_element = jQuery(this);
		$pm_number_minus = setInterval(function() {
			if ( current_element.parent().find('input').val() == '' ) {
				current_element.parent().find('input').val('0');
			}
			current_element.parent().find('input').val(parseInt(current_element.parent().find('input').val())-1);
		}, 100);
	}).on('mouseup mouseout', function() {
		clearInterval($pm_number_minus);
	});

	jQuery('.pm-number-plus').on('click', function() {
		if ( jQuery(this).parent().find('input').val() == '' ) {
			jQuery(this).parent().find('input').val('0');
		}
		jQuery(this).parent().find('input').val(parseInt(jQuery(this).parent().find('input').val())+1);
	});

	var $pm_number_plus;
	jQuery('.pm-number-plus').on('mousedown', function() {
		var current_element = jQuery(this);
		$pm_number_plus = setInterval(function() {
			if ( current_element.parent().find('input').val() == '' ) {
				current_element.parent().find('input').val('0');
			}
			current_element.parent().find('input').val(parseInt(current_element.parent().find('input').val())+1);
		}, 100);
	}).on('mouseup mouseout', function() {
		clearInterval($pm_number_plus);
	});

	jQuery(document).on('click', '.form-input-wrapper a, .email-popup-preview-inner div.form-input-wrapper > div, .pm-bottom-button a, .wpcf7pm-form p input, .wpcf7pm-form p textarea, .email-popup-preview form input, .email-popup-preview form textarea, .email-popup-close', function(e) {
		if ( !jQuery('.email-popup-preview-box ').length ) {
			return;
		}
		var current_element = jQuery(this);
		if ( typeof jQuery(this).attr('class') != 'undefined' ) {
			if ( typeof jQuery(this).attr('class') != 'undefined' && jQuery(this).attr('class').split(' ')['0'] == 'wpcf7pm-form-control' ) {
				jQuery('#email-template-last-clicked').val('.'+jQuery(this).attr('class').split(' ')['0']+'.'+jQuery(this).attr('class').split(' ')['1']);
			} else if ( typeof jQuery(this).attr('class') != 'undefined' && jQuery(this).attr('class').split(' ')['0'] == 'ninja-forms-field' ) {
				if ( jQuery(this).is('input') && jQuery(this).attr('type') == 'submit' ) {
					jQuery('#email-template-last-clicked').val(jQuery(this).prop('tagName')+'[type='+jQuery(this).attr('type')+'].'+jQuery(this).attr('class').replace(/\  /g, ' ').replace(/\s/g, '.').slice(0, -1));
				} else if ( jQuery(this).is('textarea') ) {
					jQuery('#email-template-last-clicked').val(jQuery(this).prop('tagName')+'.'+jQuery(this).attr('class').replace(/\  /g, ' ').replace(/\s/g, '.'));
				} else {
					jQuery('#email-template-last-clicked').val(jQuery(this).prop('tagName')+'.'+jQuery(this).attr('class').replace(/\  /g, ' ').replace(/\s/g, '.').slice(0, -1));
				}
			} else if ( typeof jQuery(e.target).attr('class') != 'undefined' )  {
				current_element = jQuery(e.target);
				jQuery('#email-template-last-clicked').val('.'+current_element.attr('class').replace(/\s/g, '.'));
			} else {
				current_element = jQuery(this);
				jQuery('#email-template-last-clicked').val('.'+current_element.parent().attr('class')+' '+current_element.prop('tagName'));
			}
		} else {
			jQuery('#email-template-last-clicked').val('.'+current_element.parent().attr('class')+' '+current_element.prop('tagName'));
		}

		if ( current_element.attr('class') == 'pm-verification-accept' || current_element.attr('class') == 'pm-verification-deny' ) {
			jQuery('.form-group.verification-custom-url').show();
			if ( typeof current_element.attr('data-custom-url') != 'undefined' ) {
				jQuery('#verification-custom-url').val(current_element.attr('data-custom-url'));
			} else {
				jQuery('#verification-custom-url').val('');
			}
		} else {
			jQuery('.form-group.verification-custom-url').hide();
		}

		jQuery('.form-input-wrapper').removeClass('active');
		current_element.parent().addClass('active');

		jQuery('#email-template-font-size').val(parseInt(current_element.css('font-size')));
		jQuery('#email-template-line-height').val(parseInt(current_element.css('line-height')));
		jQuery('#email-template-border-radius').val(parseInt(current_element.css('border-radius')));
		jQuery('#email-template-padding-top').val(parseInt(current_element.css('padding-top')));
		jQuery('#email-template-padding-left').val(parseInt(current_element.css('padding-left')));
		jQuery('#email-template-padding-bottom').val(parseInt(current_element.css('padding-bottom')));
		jQuery('#email-template-padding-right').val(parseInt(current_element.css('padding-right')));
		jQuery('#email-template-font-family').val(current_element.css('font-family').replace('"', '').replace('"', ''));

		if ( current_element.css('text-align') == 'start' ) {
			jQuery('#email-template-text-align').val('left');
		} else {
			jQuery('#email-template-text-align').val(current_element.css('text-align'));
		}
		if ( current_element.css('font-weight') == 'bold' ) {
			jQuery('#email-template-font-weight').val('700');
		} else {
			jQuery('#email-template-font-weight').val(current_element.css('font-weight'));
		}

		jQuery('#email-template-color').wpColorPicker('color', current_element.css('color'));
		if ( current_element.css('background-color') != 'rgba(0, 0, 0, 0)' ) {
			jQuery('#email-template-background-color:not(.popup)').wpColorPicker('color', current_element.css('background-color'));
		} else {
			jQuery('#email-template-background-color:not(.popup)').wpColorPicker('color', '#010000');
		}
		jQuery('#email-template-border-color').wpColorPicker('color', current_element.css('border-color'));

		jQuery('.alert.choose-field, .form-group.show-for-input, .form-group.show-for-text').hide();
		
		if ( current_element.is('input') || current_element.is('textarea') ) {
			jQuery('.form-group.show-for-input').show();
			jQuery('.form-group.link-edit').hide();
		} else {
			jQuery('.form-group.show-for-text').show();
		}

		if ( current_element.is('a') ) {
			jQuery('#email-template-text-align').parent().hide();
		}

		if ( typeof current_element.attr('data-entry') != 'undefined' ) {
			jQuery('#email-template-element-entrance').val( current_element.attr('data-entry') );
		} else {
			jQuery('#email-template-element-entrance').val('');
		}

		if ( typeof current_element.attr('data-exit') != 'undefined' ) {
			jQuery('#email-template-element-exit').val( current_element.attr('data-exit') );
		} else {
			jQuery('#email-template-element-exit').val('');
		}

		jQuery('.email-template-left > div').css('background-color', '#FFF9E0');
		setTimeout(function(){
			jQuery('.email-template-left > div').css('background-color', '');
		}, 500);
	});

	jQuery(document).on('click', '.email-popup-close', function() {
		jQuery('#email-template-text-align').parent().hide();
	});

	jQuery('.pm-number-minus:not(.popup), .pm-number-plus:not(.popup)').on('click', function() {
		var style_value = '';
		var input_style_value = jQuery(this).parent().find('input').attr('id').replace('email-template-', '');
		if ( input_style_value == 'border-radius' || input_style_value == 'font-size' || input_style_value == 'line-height' || input_style_value == 'padding-top' || input_style_value == 'padding-bottom' || input_style_value == 'padding-left' || input_style_value == 'padding-right' ) {
			style_value = 'px';
		}
		jQuery(jQuery('#email-template-last-clicked').val()).css(input_style_value, jQuery(this).parent().find('input').val()+style_value);
	});

	jQuery('.pm-number-field input:not(.popup)').on('input', function() {
		var style_value = '';
		if ( jQuery(this).attr('id').replace('email-template-', '').indexOf('padding-') >= 0 || jQuery(this).attr('id').replace('email-template-', '') == 'border-radius' || jQuery(this).attr('id').replace('email-template-', '') == 'font-size' || jQuery(this).attr('id').replace('email-template-', '') == 'line-height' ) {
			style_value = 'px';
		}
		jQuery(jQuery('#email-template-last-clicked').val()).css(jQuery(this).attr('id').replace('email-template-', ''), jQuery(this).val()+style_value);
	});

	jQuery('.pm-number-field input.popup').on('input', function() {
		jQuery('.email-popup-preview').css(jQuery(this).attr('id').replace('email-template-popup-', ''), jQuery(this).val()+'px');
	});

	jQuery('.pm-number-minus, .pm-number-plus').on('click', function() {
		// jQuery('.email-popup-preview').css('padding', jQuery(this).parent().find('input').val()+'px');
		jQuery(this).parent().find('input').trigger('input');
	});

	jQuery('#email-template-font-weight').on('change', function() {
		jQuery(jQuery('#email-template-last-clicked').val()).css(jQuery(this).attr('id').replace('email-template-', ''), jQuery(this).val());
	});

	jQuery('#email-template-text-align').on('change', function() {
		jQuery(jQuery('#email-template-last-clicked').val()).css(jQuery(this).attr('id').replace('email-template-', ''), jQuery(this).val());
	});

	jQuery(document).on('blur', '.email-popup-preview form input:not([type="submit"])', function() {
		if ( jQuery(this).val() != '' ) {
			jQuery(this).attr('value', jQuery(this).val());
		}
	});

	jQuery(document).on('click', '.email-popup-preview form input[type="submit"]', function(e) {
		e.preventDefault();
	});

	jQuery('#email-template-popup-location').on('change', function() {
		jQuery('.email-popup-preview').attr('class', 'email-popup-preview');
		jQuery('.email-popup-preview-wrapper').attr('class', 'email-popup-preview-wrapper');
		jQuery('.email-popup-preview').removeClass('animate');
		jQuery('.email-popup-preview, .email-popup-preview-wrapper').addClass(jQuery(this).val());
		jQuery('.email-popup-preview-box').addClass('modal-popup-overlay');
	});

	if ( jQuery('.email-popup-preview').length && jQuery('.email-popup-preview').css('background-image') != 'none' ) {
		var current_bg = jQuery('.email-popup-preview').css('background-image').replace('url("', '').replace('")', '');
		jQuery('#email-template-background-image').val(current_bg);
		jQuery('#email-template-background-image').parent().find('.delete-image').removeClass('hidden');
	}

	jQuery('#email-template-background-image').on('input', function() {
		if( jQuery(this).val() != '' ) {
			jQuery('.email-popup-preview').css('background', 'url('+jQuery(this).val()+') no-repeat');
		} else {
			jQuery('.email-popup-preview').css('background', 'url() no-repeat');
		}
	});

	jQuery('#email-template-popup-trigger').on('change', function() {
		jQuery('.form-group.trigger-input').hide();
		jQuery('.popup-trigger-explanation').html(jQuery(this).find('[value="'+jQuery(this).val()+'"]').data('trigger-explanation'));
		if ( jQuery(this).val() == 'timer' || jQuery(this).val() == 'inactive' ) {
			jQuery('.form-group.trigger-input #email-template-popup-time').parent().parent().show();
		} else if ( jQuery(this).val() == 'referrer' || jQuery(this).val() == 'browser' || jQuery(this).val() == 'click' ) {
			jQuery('.form-group.trigger-input #email-template-popup-target-input').parent().find('h4').html(jQuery(this).val());
			jQuery('.form-group.trigger-input #email-template-popup-target-input').parent().show();
		}
	});

	function getVisible() {
		if ( !jQuery('.email-template-right > .pm-card-box').length ) {
			return;
		}
		var step_top = jQuery('.pm-steps').offset().top-jQuery('.pm-steps').height()+32+22;
		jQuery('.pm-scroll-reference').css({'height': jQuery('.pm-steps').height()+jQuery('.pm-steps').offset().top-32+'px', 'top': '-'+step_top+'px'});
		
		if ( $('.pm-scroll-reference').length ) {
			var $el = $('.pm-scroll-reference'),
				scrollTop = $(this).scrollTop(),
				scrollBot = scrollTop + $(this).height(),
				elTop = $el.offset().top,
				elBottom = elTop + $el.outerHeight(),
				visibleTop = elTop < scrollTop ? scrollTop : elTop,
				visibleBottom = elBottom > scrollBot ? scrollBot : elBottom,
				topValue = visibleBottom - visibleTop;
			if ( topValue <= 32 ) {
				topValue = 47;
			}
			// jQuery("div[class^='pm-step']").offset().top
			if ( jQuery('.pm-step2-nav').css('display') == 'block' ) {
				var steps_visible = jQuery('.pm-step2-nav').offset().top-jQuery(document).scrollTop();
			} else if ( jQuery('.pm-step3-nav').css('display') == 'block' ) {
				var steps_visible = jQuery('.pm-step3-nav').offset().top-jQuery(document).scrollTop();
			}
			
			if ( steps_visible < 45 ) {
				steps_visible = 45;
			}
			jQuery('.email-template-right > .pm-card-box').css({'width': jQuery('.email-template-right').width() + 15 + 'px', 'height': jQuery(window).height() - 10 - steps_visible + 'px'});
		}
	}

	jQuery(document).on('ready', getVisible);
	jQuery(window).on('scroll resize', getVisible);

	jQuery('.form-group.file-upload a.delete-image').click(function() {
		if ( confirm('Do you want to remove your image?') ) {
			jQuery(this).parent().find('input').val('').trigger('input');
			jQuery(this).parent().find('input').val('No file');
			jQuery('#email-template-background-color').wpColorPicker('color', jQuery('#email-template-background-color').parent().parent().find('.wp-color-result').css('background-color'));
			jQuery(this).addClass('hidden');
		};
	});

	jQuery(document).on('click', '.form-group.file-upload a.choose-image', function() {
		var $wpimageupload = jQuery(this).parent().find('input');
		var $wpdeleteimage = jQuery(this).parent().find('a.delete-image');
		var image = wp.media({ 
			title: 'Upload Image',
			multiple: false
		}).open().on('select', function(e){
			console.log($wpimageupload);
			var uploaded_image = image.state().get('selection').first();
			var image_url = uploaded_image.toJSON().url;
			$wpimageupload.val(image_url).trigger('input');
			$wpdeleteimage.removeClass('hidden');
		});
	});

	jQuery('#email-template-close-link-type').on('change', function() {
		jQuery(this).parent().parent().removeClass( 'text image nothing' );
		jQuery(this).parent().parent().addClass( jQuery(this).val() );

		if ( jQuery(this).val() == '' || jQuery(this).val() == 'nothing' ) {
			jQuery('.email-popup-close').html('');
		}
	});
	jQuery('#email-template-close-link-type').trigger('change');

	jQuery('#email-template-close-link-source').on('change', function() {
		jQuery(this).parent().parent().removeClass( 'upload predefined' );
		jQuery(this).parent().parent().addClass( jQuery(this).val() );
	});
	jQuery('#email-template-close-link-source').trigger('change');

	jQuery(document).on('click', '.close-link-images img', function() {
		jQuery('.close-link-images img').removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.email-popup-close').html('<img src="'+jQuery(this).attr('src')+'" alt="" style="width: '+jQuery('#email-template-close-image-width').val()+'px; height: '+jQuery('#email-template-close-image-width').val()+'px;">');
		jQuery('#email-template-predefined-img').attr('value', jQuery(this).attr('data-type'));
	});

	jQuery('#email-template-close-image-width').on('input', function() {
		jQuery('.email-popup-close img').css({'width': jQuery(this).val()+'px', 'height': jQuery(this).val()+'px'})
	});

	jQuery('#email-template-close-link-position').on('change', function() {
		var popup_padding = jQuery('.email-popup-preview').css('padding');
		var image_width = jQuery('#email-template-close-image-width').val();
		if ( jQuery(this).val() == 'inside' ) {
			jQuery('.email-popup-preview-box > .email-popup-close').remove();
			jQuery('.email-popup-close-wrapper').removeClass('close-outside');
			jQuery('.email-popup-close').css({'top': '-20px', 'right': '-20px'});
		} else if ( jQuery(this).val() == 'edge' ) {
			jQuery('.email-popup-preview-box > .email-popup-close').remove();
			jQuery('.email-popup-close-wrapper').removeClass('close-outside');
			jQuery('.email-popup-close').css({'top': '-'+(parseInt(popup_padding.replace('px', ''))+image_width/2)+'px', 'right': '-'+(parseInt(popup_padding.replace('px', ''))+image_width/2)+'px'});
		} else if ( jQuery(this).val() == 'outside' ) {
			jQuery('.email-popup-close').css({'top': '20px', 'right': '20px'});
			jQuery('.email-popup-preview-box').prepend(jQuery('.email-popup-close')['0'].outerHTML);
			jQuery('.email-popup-close-wrapper').addClass('close-outside');
		}
	});

	if ( jQuery('.email-popup-close-wrapper').hasClass('close-outside') ) {
		jQuery('.email-popup-preview-box').prepend(jQuery('.email-popup-close-wrapper .email-popup-close')['0'].outerHTML);
	}

	jQuery('#email-template-close-link-text').on('input', function() {
		if ( jQuery('#email-template-close-link-type').val() != 'text' ) {
			return;
		}
		jQuery('.email-popup-close').html(jQuery(this).val());
	});
	jQuery('#email-template-close-link-text').trigger('input');

	jQuery('#email-template-entrance-animation, #email-template-exit-animation').on('change', function() {
		// jQuery('.email-popup-preview').attr('class', 'email-popup-preview');
		jQuery('.email-popup-preview-box').addClass('modal-popup-overlay');
		jQuery('.email-popup-preview').addClass('animated ' + jQuery(this).val());

		setTimeout(function() {
			// jQuery('.email-popup-preview').attr('class', 'email-popup-preview');
			var lastClass = jQuery('.email-popup-preview').attr('class').split(' ').pop();
			jQuery('.email-popup-preview').removeClass(lastClass);
			// jQuery('.email-popup-preview-box').removeClass('modal-popup-overlay');
		}, 2000);
	});

	function pm_hexToRgb(hex) {
		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? {
			r: parseInt(result[1], 16),
			g: parseInt(result[2], 16),
			b: parseInt(result[3], 16)
		} : null;
	}

	if ( jQuery('#email-template-box-shadow-type').length ) {
		var box_shadow_style = jQuery('.email-popup-preview').css('box-shadow').split(' ');

		if ( box_shadow_style['0'] == 'none' ) {
			jQuery('#email-template-box-shadow-type').val('none');
		} else {
			var shadow_color = box_shadow_style['0']+box_shadow_style['1']+box_shadow_style['2']+box_shadow_style['3'];
			jQuery('.colorpicker-opacity.box-shadow').slider('option', 'value', box_shadow_style['3'].replace(')', ''));
			if ( typeof box_shadow_style['4'] != 'undefined' ) {
				jQuery('#email-template-box-shadow-horizontal').attr('value', box_shadow_style['4'].replace('px', ''));
			}
			if ( typeof box_shadow_style['5'] != 'undefined' ) {
				jQuery('#email-template-box-shadow-vertical').attr('value', box_shadow_style['5'].replace('px', ''));
			}
			if ( typeof box_shadow_style['6'] != 'undefined' ) {
				jQuery('#email-template-box-shadow-blur').attr('value', box_shadow_style['6'].replace('px', ''));
			}
			if ( typeof box_shadow_style['7'] != 'undefined' ) {
				jQuery('#email-template-box-shadow-spread').attr('value', box_shadow_style['7'].replace('px', ''));
			}
			if ( typeof box_shadow_style['8'] != 'undefined' && box_shadow_style['8'] == 'inset' ) {
				jQuery('#email-template-box-shadow-type').val('inset');
			} else {
				jQuery('#email-template-box-shadow-type').val('outset');
			}
			jQuery('#email-template-box-shadow-color').wpColorPicker('color', shadow_color.toString());
		}
	}

	jQuery('#email-template-box-shadow-type').on('change', function() {
		if ( jQuery(this).val() == 'none' ) {
			jQuery('.email-popup-preview').css('box-shadow', 'none');
		} else {
			var shadow_horizontal = jQuery('#email-template-box-shadow-horizontal').val();
			var shadow_vertical = jQuery('#email-template-box-shadow-vertical').val();
			var shadow_blur = jQuery('#email-template-box-shadow-blur').val();
			var shadow_spread = jQuery('#email-template-box-shadow-spread').val();
			var shadow_color_code = jQuery('#email-template-box-shadow-color').val();
			var shadow_color_hex = pm_hexToRgb(shadow_color_code);
			var shadow_color_opacity = jQuery('.colorpicker-opacity.box-shadow').slider("option", "value");
			var shadow_color = 'rgba('+shadow_color_hex.r+', '+shadow_color_hex.g+', '+shadow_color_hex.b+', '+shadow_color_opacity+')';

			var shadow_type = '';
			if ( jQuery(this).val() == 'inset' ) {
				shadow_type = 'inset';
			}
			var box_shadow_style = shadow_horizontal+'px '+shadow_vertical+'px '+shadow_blur+'px '+shadow_spread+'px '+shadow_color+' '+shadow_type;

			jQuery('.email-popup-preview').css('box-shadow', box_shadow_style);
		}
	});

	jQuery('input[type="number"].box-shadow').on('input', function() {
		var shadow_horizontal = jQuery('#email-template-box-shadow-horizontal').val();
		var shadow_vertical = jQuery('#email-template-box-shadow-vertical').val();
		var shadow_blur = jQuery('#email-template-box-shadow-blur').val();
		var shadow_spread = jQuery('#email-template-box-shadow-spread').val();
		var shadow_color_code = jQuery('#email-template-box-shadow-color').val();
		var shadow_color_hex = pm_hexToRgb(shadow_color_code);
		var shadow_color_opacity = jQuery('.colorpicker-opacity.box-shadow').slider("option", "value");
		var shadow_color = 'rgba('+shadow_color_hex.r+', '+shadow_color_hex.g+', '+shadow_color_hex.b+', '+shadow_color_opacity+')';
		var shadow_type = '';
		if ( jQuery('#email-template-box-shadow-type').val() == 'inset' ) {
			shadow_type = 'inset';
		}
		var box_shadow_style = shadow_horizontal+'px '+shadow_vertical+'px '+shadow_blur+'px '+shadow_spread+'px '+shadow_color+' '+shadow_type;

		jQuery('.email-popup-preview').css('box-shadow', box_shadow_style);
	});

	function pm_validate_popup() {
		var invalid = 0;
		jQuery('.form-group').removeClass('invalid');
		if ( jQuery('#email-template-popup-name').val() == '' ) {
			jQuery('#email-template-popup-name').parent().addClass('invalid');
			invalid++;
		}
		if ( jQuery('#email-template-popup-location').val() != 'inline' && jQuery('#email-template-entrance-animation').val() == '' ) {
			jQuery('#email-template-entrance-animation').parent().addClass('invalid');
			invalid++;
		}
		if ( jQuery('#email-template-popup-location').val() != 'inline' && jQuery('#email-template-exit-animation').val() == '' ) {
			jQuery('#email-template-exit-animation').parent().addClass('invalid');
			invalid++;
		}
		if ( jQuery('#email-template-popup-location').val() == '' ) {
			jQuery('#email-template-popup-location').parent().addClass('invalid');
			invalid++;
		}
		if ( jQuery('#email-template-popup-location').val() != 'inline' && jQuery('#email-template-popup-trigger').val() == '' ) {
			jQuery('#email-template-popup-trigger').parent().addClass('invalid');
			invalid++;
		}
		if ( invalid == 0 ) {
			return true;
		} else {
			return false;
		}
	}

	function getUrlParameter(sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : sParameterName[1];
			}
		}
	}

	jQuery('#save-email-template').on('click', function() {
		// Validate fields, send ajax and move to next step on success
		if ( pm_validate_popup() ) {
			var style_object = '';
			jQuery('.email-popup-preview-inner div.form-input-wrapper > div, .pm-bottom-button a, .wpcf7pm-form p input:not([type=hidden]), .wpcf7pm-form p textarea, .email-popup-preview input:not([type=hidden]), .email-popup-preview textarea, .email-popup-close, .email-popup-preview, .email-popup-preview-box-overlay').each(function() {
				if ( typeof jQuery(this).attr('style') != 'undefined' && jQuery(this).attr('style') != '' ) {
					if ( typeof jQuery(this).attr('class') != 'undefined' && jQuery(this).attr('class').split(' ')['0'] == 'wpcf7pm-form-control' ) {
						style_object += '".'+jQuery(this).attr('class').split(' ')['0']+'.'+jQuery(this).attr('class').split(' ')['1']+'":"'+jQuery(this).attr('style').replace(/"/g, "'")+'",'
					} else if ( typeof jQuery(this).attr('class') != 'undefined' && jQuery(this).attr('class').split(' ')['0'] == 'ninja-forms-field' ) {
						if ( jQuery(this).is('input') && jQuery(this).attr('type') == 'submit' ) {
							style_object += '"' + jQuery(this).prop('tagName')+'[type='+jQuery(this).attr('type')+'].'+jQuery(this).attr('class').replace(/\  /g, ' ').replace(/\s/g, '.').slice(0, -1) + '":"'+jQuery(this).attr('style').replace(/"/g, "'")+'",';
						} else if ( jQuery(this).is('textarea') ) {
							style_object += '"' + jQuery(this).prop('tagName')+'.'+jQuery(this).attr('class').replace(/\  /g, ' ').replace(/\s/g, '.') + '":"'+jQuery(this).attr('style').replace(/"/g, "'")+'",';
						} else {
							style_object += '"' + jQuery(this).prop('tagName')+'.'+jQuery(this).attr('class').replace(/\  /g, ' ').replace(/\s/g, '.').slice(0, -1) + '":"'+jQuery(this).attr('style').replace(/"/g, "'")+'",';
						}
					} else if ( typeof jQuery(this).attr('class') != 'undefined' ) {
						style_object += '".'+jQuery(this).attr('class').split(' ')['0']+'":"'+jQuery(this).attr('style').replace(/"/g, "'")+'",'
					} else if ( typeof jQuery(this).attr('id') != 'undefined' ) {
						style_object += '"#'+jQuery(this).attr('id')+'":"'+jQuery(this).attr('style').replace(/"/g, "'")+'",'
					}
				}
			});

			var styles = '{"popup_styles": { ' + style_object.slice(0,-1) + ' },';
			styles += ' "form_action": "' + jQuery('.email-popup-preview').find('form').attr('action') + '",';
			styles += '"popup_template": "'+ getUrlParameter('pm-template') +'",';
			styles += '"popup_template_style": "'+ jQuery('#email-template-style').val() +'",';
			styles += '"popup_location": "'+ jQuery('#email-template-popup-location').val() +'",';
			styles += '"popup_timer": "'+ jQuery('#email-template-popup-time').val() +'",';
			styles += '"popup_trigger": "'+ jQuery('#email-template-popup-trigger').val() +'",';
			styles += '"popup_entry_animation": "'+ jQuery('#email-template-entrance-animation').val() +'",';
			styles += '"popup_exit_animation": "'+ jQuery('#email-template-exit-animation').val() +'",';
			if ( jQuery('#pm-video-embed').length ) {
				styles += '"popup_video": "'+ jQuery('#pm-video-embed').val().replace(/"/g, "'") +'",';
			}
			var popup_title_text = '';
			if ( jQuery('.email-popup-main-title').length ) {
				popup_title_text = jQuery('.email-popup-main-title').html().replace(/"/g, "'");
			}
			styles += '"popup_title": "'+ popup_title_text +'",';
			var popup_disclimer_text = '';
			if ( jQuery('.email-popup-disclaimer').length ) {
				popup_disclimer_text = jQuery('.email-popup-disclaimer').html().replace(/"/g, "'");
			}
			styles += '"popup_disclaimer": "'+ popup_disclimer_text +'",';
			styles += '"popup_close_type": "'+ jQuery('#email-template-close-link-type').val() +'",';
			if ( jQuery('.email-popup-close').length ) {
				styles += '"popup_close": "'+ jQuery('.email-popup-close').html().replace(/"/g, "'") +'",';
			}
			if ( jQuery('#pm-image-url').length ) {
				styles += '"image_bg": "'+ jQuery('#pm-image-url').val().replace(/"/g, "'") +'",';
			}
			if ( jQuery('#pm-image-to-url').length ) {
				styles += '"image_link": "'+ jQuery('#pm-image-to-url').val().replace(/"/g, "'") +'",';
			}
			if ( jQuery('#pm-contact-form').length ) {
				styles += '"popup_contact_form": "'+ jQuery('#pm-contact-form').val().replace(/"/g, "'") +'",';
			}
			if ( jQuery('#pm-contact-map').length ) {
				styles += '"popup_contact_map": "'+ jQuery('#pm-contact-map').val().replace(/"/g, "'") +'",';
			}
			if ( jQuery('#email-template-popup-target-input').length ) {
				styles += '"popup_target_input": "'+ jQuery('#email-template-popup-target-input').val() +'",';
				styles += '"popup_target_first_time": "'+ jQuery('#email-template-popup-first-time').is(":checked") +'",';
				styles += '"popup_target_reset": "'+ jQuery('#email-template-popup-cookie-reset').val() +'",';
				styles += '"popup_target_page_visits": "'+ jQuery('#email-template-popup-visited-pages').val() +'",';
				styles += '"popup_target_page_after_visit": "'+ jQuery('#email-template-popup-after-visited-pages').val() +'",';
			}
			if ( jQuery('#email-template-popup-location-position').length ) {
				styles += '"popup_target_inline_location": "'+ jQuery('#email-template-popup-location-position').val() +'",';
			}
			if ( jQuery('#email-template-popup-geo-ip').length ) {
				styles += '"popup_geo_ip": "'+ jQuery('#email-template-popup-geo-ip').val().replace(/"/g, "'") +'",';
				var countries = '';
				if ( typeof jQuery('#email-template-popup-geo-country').val() != 'null' ) {
					jQuery.each(jQuery('#email-template-popup-geo-country').val(), function(index, value) {
						countries += value+'|';
					});
					countries = countries.slice(0, -1);
				}
				styles += '"popup_geo_country": "'+ countries +'",';
				styles += '"popup_geo_city": "'+ jQuery('#email-template-popup-geo-city').val().replace(/"/g, "'") +'",';
			}
			if ( jQuery('#pm-facebook-url').length ) {
				styles += '"popup_facebook_url": "'+ jQuery('#pm-facebook-url').val().replace(/"/g, "'") +'",';
			}
			if ( jQuery('#pm-ribbon-url').length ) {
				styles += '"popup_ribbon_url": "'+ jQuery('#pm-ribbon-url').val().replace(/"/g, "'") +'",';
			}
			if ( jQuery('#email-template-popup-selector').length ) {
				styles += '"popup_selector": "'+ jQuery('#email-template-popup-selector').val() +'",';
			}
			if ( jQuery('#email-template-popup-closing').length ) {
				styles += '"popup_closing": "'+ jQuery('#email-template-popup-closing').is(":checked") +'",';
			}
			if ( jQuery('#pm-cookie-readmore').length ) {
				styles += '"popup_cookie_readmore": "'+ jQuery('#pm-cookie-readmore').val() +'",';
			}
			styles += '"popup_close_source": "'+ jQuery('#email-template-close-link-source').val() +'",';
			styles += '"popup_close_position": "'+ jQuery('#email-template-close-link-position').val() +'",';
			styles += '"popup_close_width": "'+ jQuery('#email-template-close-image-width').val() +'",';
			styles += '"popup_predefined_image": "'+ jQuery('#email-template-predefined-img').val() +'",';
			if ( jQuery('.popup-schedule-start').val() != '' && jQuery('.popup-schedule-end').val() != '' ) {
				styles += '"popup_schedule": {"start":"'+jQuery('.popup-schedule-start').val()+'","end":"'+jQuery('.popup-schedule-end').val()+'"},';
			}
			if ( jQuery('#email-template-fonts').length ) {
				jQuery('.email-popup-preview-inner div.form-input-wrapper > div, .pm-bottom-button a, .wpcf7pm-form p input, .wpcf7pm-form p textarea, .email-popup-preview form input, .email-popup-preview form textarea, .email-popup-close').each(function() {
					var font_values = jQuery('#email-template-fonts').val().split('|');
					var current_font = jQuery(this).css('font-family').replace('"', '').replace('"', '');

					if ( current_font != 'Source Sans Pro' && jQuery.inArray( current_font, font_values ) == -1 ) {
						if ( jQuery('#email-template-fonts').val() == '' ) {
							jQuery('#email-template-fonts').val( jQuery(this).css('font-family').replace('"', '').replace('"', '') );
						} else {
							jQuery('#email-template-fonts').val( jQuery('#email-template-fonts').val() + '|' + jQuery(this).css('font-family').replace('"', '').replace('"', '') );
						}
					}
				});
				styles += '"popup_fonts": "'+ jQuery('#email-template-fonts').val() +'",';
			}
			if ( jQuery('#email-template-popup-target').length ) {
				var page_targets = '';
				if ( jQuery('#email-template-popup-target').val() ) {
					jQuery.each(jQuery('#email-template-popup-target').val(), function(index, value) {
						page_targets += value+'|';
					});
					page_targets = page_targets.slice(0, -1);
				}
				styles += '"popup_page_targets": "'+ page_targets +'",';
			}
			if ( jQuery('#email-template-popup-disable-mobile').length ) {
				styles += '"popup_disabled_mobile": "'+ jQuery('#email-template-popup-disable-mobile').prop('checked') +'",';
				styles += '"popup_disabled_mobile_width": "'+ jQuery('#email-template-popup-disable-mobile-width').val() +'",';
				
			}
			if ( jQuery('#email-template-popup-exclude').length ) {
				var page_exclude = '';
				if ( jQuery('#email-template-popup-exclude').val() ) {
					jQuery.each(jQuery('#email-template-popup-exclude').val(), function(index, value) {
						page_exclude += value+'|';
					});
					page_exclude = page_exclude.slice(0, -1);
				}
				styles += '"popup_page_exclude": "'+ page_exclude +'",';
			}
			if ( jQuery('.pm-card-box.pm-locker-options').length ) {
				jQuery('.pm-card-box.pm-locker-options .form-group input').each(function() {
					var setting_name = jQuery(this).attr('id').replace('email-template-', '').replace(/\-/g, '_');
					if ( jQuery(this).attr('type') != 'checkbox' ) {
						styles += '"'+setting_name+'": "'+ jQuery(this).val() +'",';
					} else {
						styles += '"'+setting_name+'": "'+ jQuery(this).prop('checked') +'",';
					}
				});
			}
			if ( jQuery('.main-survey-wrapper').length ) {
				var survey_main_json = '';
				jQuery('.survey-inner .survey-question-wrapper').each(function(index) {
					var survey_json = '"question_settings'+index+'": {"question": "';
					survey_json += jQuery(this).find('.survey-main-question').val()+'",';
					survey_json += '"answers": {';
					if ( !jQuery('.email-popup-preview-box').hasClass('quiz-style') && !jQuery('.email-popup-preview-box').hasClass('quiz2-style') && !jQuery('.email-popup-preview-box').hasClass('quiz3-style') ) {
						jQuery(this).find('.survey-answers .surver-answer').each(function(indx) {
							if ( jQuery(this).find('select').length ) {
								survey_json += '"option'+indx+'":"select|';
								jQuery(this).find('select option').each(function() {
									survey_json += jQuery(this).html()+'::';
								});
								survey_json = survey_json.slice(0, -2);
								survey_json += '",';
							} else if ( jQuery(this).find('input').length ) {
								survey_json += '"option'+indx+'":"input:'+jQuery(this).find('input').attr('type')+'|'+jQuery(this).find('input').val()+'",';
							} else if ( jQuery(this).find('textarea').length ) {
								survey_json += '"option'+indx+'":"textarea|'+jQuery(this).find('textarea').val()+'",';
							}
						});
					} else {
						jQuery(this).find('.survey-answers .surver-answer').each(function(indx) {
							if ( jQuery(this).find('.survey-correct.active').length ) {
								survey_json += '"option'+indx+'":"1|'+jQuery(this).find('input').val()+'",';
							} else {
								survey_json += '"option'+indx+'":"0|'+jQuery(this).find('input').val()+'",';
							}
						});
					}
					
					survey_json = survey_json.slice(0, -1);
					survey_json += '}';
					if ( jQuery('.email-popup-preview-box').hasClass('quiz-style') ) {
						survey_json += ',"question_image": "'+jQuery(this).find('.quiz-main-image').val()+'"';
					}

					survey_json += '},';

					survey_main_json += survey_json;
				});
				survey_main_json = survey_main_json.slice(0, -1);

				styles += '"survey_data": {'+ survey_main_json +'},';

				var survey_settings_json = '';
				survey_settings_json += '"style": "'+jQuery('#survey-question-style').val()+'",';
				survey_settings_json += '"collection": "'+jQuery('#survey-question-collection').val()+'",';
				if ( jQuery('#survey-question-vote-results').length ) {
					survey_settings_json += '"vote_results": "'+jQuery('#survey-question-vote-results').val()+'",';
					jQuery('.main-survey-wrapper').attr('data-vote-results', jQuery('#survey-question-vote-results').val());
				}
				survey_settings_json += '"share_buttons": "'+jQuery('.quiz-share-buttons input').prop('checked')+'"';
				styles += '"survey_settings": {'+ survey_settings_json +'},';

				jQuery('.main-survey-wrapper').attr('data-style', jQuery('#survey-question-style').val()).attr('data-collection', jQuery('#survey-question-collection').val());
				jQuery('.main-survey-wrapper').attr('data-title', jQuery('.survey-thankyou-title').val()).attr('data-text', jQuery('.survey-thankyou-text').val());

				if ( jQuery('.quiz-share-text').length ) {
					jQuery('.main-survey-wrapper').attr('data-share-title', jQuery('.quiz-share-text').val());
				}

				if ( !jQuery('.email-popup-preview-inner').find('.quiz-share-buttons').length && jQuery('.quiz-share-buttons input').length && jQuery('.quiz-share-buttons input').prop('checked') === true ) {
					var twitter_button = '<a href="http://twitter.com/share?text=<<sharetext>>&url=<<shareurl>>" class="quiz-twitter-share pmicon-twitter" target="_blank"></a>';
					var facebook_button = '<a href="http://www.facebook.com/sharer.php?u=<<shareurl>>" class="quiz-facebook-share pmicon-facebook-official" target="_blank"></a>';
					var gplus_button = '<a href="https://plus.google.com/share?url=<<shareurl>>" class="quiz-gplus-share pmicon-gplus" target="_blank"></a>';
					jQuery('.email-popup-preview-inner').append('<div class="quiz-share-buttons" style="display: none;">'+twitter_button+facebook_button+gplus_button+'</div>');
				}


			}
			if ( jQuery('#email-template-thank-you-text').length ) {
				var old_text = jQuery('#email-template-thank-you-text').val().replace(/"/g, "'").replace(/\n/g, "<br>");
				var new_text = pm_strip_tags(old_text, '<br><a>');
				styles += '"popup_thankyou": "'+ new_text +'",';
			}
			if ( jQuery('#email-template-popup-closing-cond').length ) {
				styles += '"popup_closing_cond": "'+ jQuery('#email-template-popup-closing-cond').val() +'",';
				styles += '"popup_closing_timer": "'+ jQuery('#email-template-popup-closing-timer').val() +'",';
			}
			if ( jQuery('#email-template-popup-height').length ) {
				styles += '"popup_height_select": "'+ jQuery('#email-template-popup-height-select').val() +'",';
				styles += '"popup_height": "'+ jQuery('#email-template-popup-height').val() +'",';
			}
			if ( jQuery('#email-template-popup-bg-size-select').length ) {
				styles += '"popup_bg_size": "'+ jQuery('#email-template-popup-bg-size-select').val() +'",';
				styles += '"popup_bg_position": "'+ jQuery('#email-template-popup-bg-position-select').val() +'",';
			}
			var popup_secondary_text = '';
			if ( jQuery('.email-popup-secondary-title').length ) {
				popup_secondary_text = jQuery('.email-popup-secondary-title').html().replace(/"/g, "'");
			}
			styles += '"popup_text": "'+ popup_secondary_text +'"';
			styles += '}';
			var form_action = 'save';
			var form_id = -1;
			if ( typeof getUrlParameter('edit_popup') != 'undefined' ) {
				form_action = 'update';
				form_id = getUrlParameter('edit_popup');
			}
			if ( jQuery('.pm-survey-add-question').length ) {
				jQuery('.pm-survey-add-question, .pm-survey-settings, .survey-edit-question, .survey-delete-question').remove();
			}
			var popup_html = jQuery('.email-popup-preview')['0'].outerHTML;

			if ( jQuery('.pm-card-box.pm-locker-options').length ) {
				popup_html = jQuery(popup_html).find('.pm-locker-wrapper').html('{facebooke_like_button}{facebooke_share_button}{twitter_tweet_button}{twitter_follow_button}{gplus_button}{gplus_share_button}{linkedin_button}{pinterest_button}').closest('.email-popup-preview')['0'].outerHTML;
			}

			var google_maps_key = '';
			if ( jQuery('#pm-google-maps-key').length ) {
				google_maps_key = jQuery('#pm-google-maps-key').val();
			}

			jQuery.ajax({
				type: 'POST',
				url: pm_main.ajaxurl,
				data: { 
					'action': 'pm_save_data',
					'form_name': jQuery('#email-template-popup-name').val(), 
					'form_data': styles,
					'form_action': form_action,
					'form_id': form_id,
					'popup_html': popup_html,
					'google_key': google_maps_key
				},
				success: function(data) {
					if ( jQuery.isNumeric(data) ) {
						window.location = window.location.href+'&popup_id='+data;
					} else if ( data == 'updated' ) {
						window.location = pm_main.submenu;
					} else if ( data == 'failed' ) {
						alert('There\'s an issue and we couldn\'t save/update your popup!');
					}
				}
			});
		}
	});

	function pm_strip_tags(input, allowed) {
		allowed = (((allowed || '') + '')
			.toLowerCase()
			.match(/<[a-z][a-z0-9]*>/g) || [])
			.join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
		var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
			commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
		return input.replace(commentsAndPhpTags, '')
			.replace(tags, function($0, $1) {
		  		return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
		});
	}

	jQuery('.pm-delete-popup').on('click', function(e) {
		e.preventDefault();
		var popup_delete = jQuery(this);
		if ( confirm('Do you really want to delete this popup?') ) {
			jQuery.ajax({
				type: 'POST',
				url: pm_main.ajaxurl,
				data: { 
					'action': 'pm_delete_popup',
					'popup_id': popup_delete.parent().parent().find('td:first-child').attr('data-pid')
				},
				success: function(data) {
					if ( data == 'success' ) {
						var deleted_id = popup_delete.parent().parent().find('td:first-child').attr('data-pid');
						popup_delete.parent().parent().remove();
						if ( jQuery('tr.child.parent-'+deleted_id).length ) {
							jQuery('tr.child.parent-'+deleted_id).remove();
						}
					}
				}
			});
		}
	});

	jQuery(document).on('click', '.pm-edit-popup', function() {
		jQuery.ajax({
			type: 'POST',
			url: pm_main.ajaxurl,
			data: { 
				'action': 'pm_edit_link',
				'popup_id': jQuery(this).parent().parent().find('td:first-child').attr('data-pid')
			},
			success: function(data) {
				if ( data ) {
					window.location = data;
				}
			}
		});
	});

	jQuery('.email-template-middle input[type="hidden"]').each(function() {
		jQuery('#'+jQuery(this).attr('class')).val(jQuery(this).val());
		if ( jQuery(this).attr('class') == 'email-template-close-link-type' ) {
			jQuery('#'+jQuery(this).attr('class')).trigger('change');
		} else if ( jQuery(this).attr('class') == 'email-template-popup-first-time' && jQuery(this).val() == 'true' ) {
			jQuery('#'+jQuery(this).attr('class')).prop('checked', true);
			jQuery('#'+jQuery(this).attr('class')).trigger('change');
		} else if ( jQuery(this).attr('class') == 'email-template-popup-closing' && jQuery(this).val() == 'true' ) {
			jQuery('#'+jQuery(this).attr('class')).prop('checked', true);
			jQuery('#'+jQuery(this).attr('class')).trigger('change');
		} else if ( ( jQuery(this).attr('class') == 'email-template-locker-twitter-check' || jQuery(this).attr('class') == 'email-template-locker-twitter-follow-check' || jQuery(this).attr('class') == 'email-template-locker-facebook-like-status' || jQuery(this).attr('class') == 'email-template-locker-facebook-share-status' || jQuery(this).attr('class') == 'email-template-locker-twitter-status' || jQuery(this).attr('class') == 'email-template-locker-twitter-follow-status' || jQuery(this).attr('class') == 'email-template-locker-gplus-status' || jQuery(this).attr('class') == 'email-template-locker-gplus-share-status' || jQuery(this).attr('class') == 'email-template-locker-linkedin-status' || jQuery(this).attr('class') == 'email-template-locker-pinterest-status' ) || jQuery(this).attr('class') == 'email-template-popup-disable-mobile' && jQuery(this).val() == 'true' ) {
			jQuery('#'+jQuery(this).attr('class')).prop('checked', true);
		} else if ( jQuery(this).attr('class') == 'email-template-predefined-img' ) {
			jQuery('.close-link-images img[data-type="'+jQuery(this).val()+'"]').addClass('selected');
		} else if ( jQuery(this).attr('class') == 'email-template-popup-target' || jQuery(this).attr('class') == 'email-template-popup-exclude' || jQuery(this).attr('class') == 'email-template-popup-geo-country' ) {
			jQuery('#'+jQuery(this).attr('class')).val(jQuery(this).val().split('|'));
		}
	});
	jQuery('#email-template-popup-trigger, #email-template-close-link-source, #email-template-popup-target, #email-template-popup-exclude, #email-template-popup-height-select, #email-template-popup-bg-size-select, #email-template-popup-disable-mobile, #email-template-popup-closing-cond').trigger('change');

	jQuery('a.email-popup-preview').on('click', function(e) {
		return false;
	});

	if ( jQuery('.popup-extra-style').length && jQuery('.popup-extra-style').html() != '' ) {
		var style_json = jQuery.parseJSON(jQuery('.popup-extra-style').first().html());
		var style_tag = '<style type="text/css">';
		jQuery.each(style_json.styles, function(index, el) {
			if ( index.indexOf('.wpcf7pm-form-control') >= 0 ) {
				index = '.email-popup-preview .pm-contact-form '+index;
			}
			style_tag += index+'{'+el+'}';
		});
		style_tag += '</style>';
		jQuery('.email-template-right > div').prepend(style_tag);
	}

	if ( typeof jQuery('.email-popup-preview').attr('style') != 'undefined' ) {
		var styles = jQuery('.email-popup-preview').attr('style').split(';');
		jQuery.each(styles, function( index, val ) {
			var cur_style = val.split(':');
			var style_name = cur_style['0'].replace(' ', '');
			if ( style_name != 'background' && typeof cur_style['1'] != 'undefined' ) {
				var style_value = cur_style['1'].replace(' ', '').replace('px', '');
				jQuery('#email-template-popup-'+style_name).val(style_value);
			}
		})
	}

	if ( typeof jQuery('.email-popup-preview-box-overlay').css('opacity') != 'undefined' ) {
		jQuery('.colorpicker-opacity:not(.box-shadow)').slider('option', 'value', jQuery('.email-popup-preview-box-overlay').css('opacity'));
		jQuery('.email-popup-preview-box-overlay').css('opacity', jQuery('.email-popup-preview-box-overlay').css('opacity'));
	}

	if ( typeof jQuery('.email-popup-preview-box-overlay').css('background-color') != 'undefined' && jQuery('.email-popup-preview-box-overlay').css('background-color') != 'rgba(0, 0, 0, 0)' ) {
		jQuery('.wpcolorpicker-overlay').wpColorPicker('color', jQuery('.email-popup-preview-box-overlay').css('background-color').toString());
	}

	jQuery('#email-template-close-link-image').on('input', function() {
		if ( jQuery('#email-template-close-link-type').val() != 'image' || jQuery('#email-template-close-link-source').val() == 'predefined' ) {
			return;
		}
		if( jQuery(this).val() != '' ) {
			jQuery('.email-popup-close').html('<img src="'+jQuery(this).val()+'" alt="">');
		} else {
			jQuery('.email-popup-close').html('');
		}
	});
	jQuery('#email-template-close-link-image').trigger('input');

	if ( typeof getUrlParameter('pm-style') != 'undefined' && getUrlParameter('pm-style') == 'contacts' ) {
		jQuery('#pm-contact-map').parent().hide();
	}

	jQuery('#email-template-popup-first-time').trigger('change');
	if ( jQuery('#email-template-popup-visited-pages').length && jQuery('#email-template-popup-visited-pages').val() != '' ) {
		jQuery('#email-template-popup-visited-pages').trigger('input');
	} else if ( jQuery('#email-template-popup-after-visited-pages').length && jQuery('#email-template-popup-after-visited-pages').val() != '' ) {
		jQuery('#email-template-popup-after-visited-pages').trigger('input');
	}

	jQuery(document).on('click', '.pm-rating-dismiss', function() {
		jQuery.ajax({
			type: 'POST',
			url: pm_main.ajaxurl,
			data: { 
				'action': 'pm_dismiss_notice'
			},
			success: function(data) {
				jQuery('.pm-rating-notice').remove();
			}
		});
	});

	if ( !jQuery('.email-popup-main-form').length && jQuery('.email-popup-preview-box').hasClass('sidebar-template') ) {
		jQuery('.email-template-step1, #back-edit-email-template').hide();
		jQuery('.email-template-step2').show();
	}

	jQuery(document).on('input', '#email-insert-url', function() {
		if ( jQuery('#email-insert-url-index').val() != '' ) {
			var elemet_class = jQuery('#email-insert-url-index').val().split('|')['1'];
			var elemet_index = jQuery('#email-insert-url-index').val().split('|')['0'];
			if ( jQuery(this).val() != '' ) {
				jQuery('.'+elemet_class.replace(/ /g, ".")).find('a').eq( elemet_index ).attr('href', jQuery(this).val());
			} else {
				jQuery('.'+elemet_class.replace(/ /g, ".")).find('a').eq( elemet_index ).contents().unwrap();
				jQuery('#email-insert-url-index').val('');
			}
		}
	});

	jQuery(document).on('click', '#steps-uid-1-t-1', function() {
		jQuery('.email-template-step3 .pm-step3-nav a:first-child').click();
		jQuery('.email-template-step2 .pm-step2-nav a:first-child').click();
	});

	jQuery('#steps-uid-1-t-0').on('click', function(e) {
		if ( jQuery(this).parent().hasClass('done') ) {
			if ( !confirm('You\'ll lose all unsaved data!') ) {
				e.preventDefault();
			}
		}
	});

	if ( jQuery('.pm-template-selection').length || jQuery('.email-template-step1').length ) {
		jQuery('#steps-uid-1-t-1').parent().show();
	} else {
		jQuery('#steps-uid-1-t-2').parent().addClass('current').removeClass('disabled');
	}

	var step_count = 1;
	jQuery('.steps > ul > li').each(function() {
		jQuery(this).find('.number').html(step_count+'.');
		if ( jQuery(this).css('display') != 'none' ) {
			step_count++;
		} else {
			jQuery(this).removeClass('current');
		}
	});


	jQuery('.pm-step2-nav a.pm-next-step').on('click', function() {
		jQuery('#steps-uid-1-t-3').parent().addClass('current').removeClass('disabled');
		jQuery('#steps-uid-1-t-2').parent().removeClass('current').addClass('disabled');
	});

	jQuery('.pm-step2-nav a.pm-prev-step').on('click', function() {
		jQuery('#steps-uid-1-t-1').parent().addClass('current').removeClass('disabled');
		jQuery('#steps-uid-1-t-2').parent().removeClass('current').addClass('disabled');
	});

	jQuery('.pm-step3-nav a:first-child').on('click', function() {
		jQuery('#steps-uid-1-t-3').parent().removeClass('current').addClass('disabled');
		jQuery('#steps-uid-1-t-2').parent().addClass('current').removeClass('disabled');
	});

	jQuery('.pm-steps ul li a').on('click', function() {
		if ( jQuery(this).attr('id') == 'steps-uid-1-t-1' ) {
			if ( jQuery('.pm-steps ul li.current a').attr('id') == 'steps-uid-1-t-2' ) {
				jQuery('.pm-step2-nav .pm-prev-step').click();
			} else if ( jQuery('.pm-steps ul li.current a').attr('id') == 'steps-uid-1-t-3' ) {
				jQuery('.pm-step3-nav .pm-prev-step').click();
				jQuery('.pm-step2-nav .pm-prev-step').click();
			}
		} else if ( jQuery(this).attr('id') == 'steps-uid-1-t-2' ) {
			if ( jQuery('.pm-steps ul li.current a').attr('id') == 'steps-uid-1-t-1' ) {
				jQuery('.email-template-step1 .pm-next-step').click();
			} else if ( jQuery('.pm-steps ul li.current a').attr('id') == 'steps-uid-1-t-3' ) {
				jQuery('.pm-step3-nav .pm-prev-step').click();
			}
		} else if ( jQuery(this).attr('id') == 'steps-uid-1-t-3' ) {
			if ( jQuery('.pm-steps ul li.current a').attr('id') == 'steps-uid-1-t-1' ) {
				jQuery('.email-template-step1 .pm-next-step').click();
				setTimeout(function() {
					if ( jQuery('.email-template-step2').css('display') != 'none' ) {
						jQuery('.pm-step2-nav .pm-next-step').click();
					}
				}, 500);
			} else if ( jQuery('.pm-steps ul li.current a').attr('id') == 'steps-uid-1-t-2' ) {
				jQuery('.pm-step2-nav .pm-next-step').click();
			}
		} else if ( jQuery(this).attr('id') == 'steps-uid-1-t-4' ) {
			if ( jQuery('.pm-steps ul li.current a').attr('id') == 'steps-uid-1-t-1' ) {
				jQuery('.email-template-step1 .pm-next-step').click();
				setTimeout(function() {
					if ( jQuery('.email-template-step2').css('display') != 'none' ) {
						jQuery('.pm-step2-nav .pm-next-step').click();
						jQuery('.pm-step3-nav .pm-next-step').click();
					}
				}, 500);
			} else if ( jQuery('.pm-steps ul li.current a').attr('id') == 'steps-uid-1-t-2' ) {
				jQuery('.pm-step2-nav .pm-next-step').click();
				jQuery('.pm-step3-nav .pm-next-step').click();
			} else if ( jQuery('.pm-steps ul li.current a').attr('id') == 'steps-uid-1-t-3' ) {
				jQuery('.pm-step3-nav .pm-next-step').click();
			}
		}
	});

	jQuery(document).on('click', '.pm-clone-popup', function() {
		if ( confirm('Are you sere you want to clone this popup?') ) {
			var popup_clone = jQuery(this);
			jQuery.ajax({
				type: 'POST',
				url: pm_main.ajaxurl,
				data: { 
					'action': 'pm_clone_popup',
					'popup_id': popup_clone.parent().parent().find('td:first-child').html()
				},
				success: function(data) {
					if ( data != 'failed' ) {
						var old_data = popup_clone.parent().parent().html();
						var old_id = popup_clone.parent().parent().find('td:first-child').html();
						var new_data = jQuery('<tr role="row">'+old_data+'</tr>');
						new_data.find('td:nth-child(1)').html(data).attr('data-pid', data);
						new_data.find('td:nth-child(2)').html(new_data.find('td:nth-child(2)').html()+' Cloned');
						new_data.find('td:nth-child(3)').html('[popup_manager id="'+data+'"]');
						new_data.find('td:nth-child(7)').html(new_data.find('td:nth-child(7)').html().replace(old_id, data));
						jQuery('.pm-table.list').prepend(new_data);
					}
				}
			});
		}
	});

	jQuery(document).on('click', '.pm-status-popup', function() {
		var popup_status = jQuery(this);
		jQuery.ajax({
			type: 'POST',
			url: pm_main.ajaxurl,
			data: { 
				'action': 'pm_popup_status',
				'popup_id': popup_status.parent().parent().find('td:first-child').html(),
				'popup_status': popup_status.attr('class').replace('pm-status-popup ', '')
			},
			success: function(data) {
				if ( popup_status.attr('class').replace('pm-status-popup ', '') == 'live' ) {
					var tooltip = 'Paused';
				} else {
					var tooltip = 'Live';
				}
				if ( data == 'success' ) {
					popup_status.toggleClass('live').toggleClass('paused').attr('data-tooltip', tooltip);
				}
			}
		});
	});

	if ( jQuery('.pm-template-selection').length ) {
		jQuery('.pm-template-selection li').each(function() {
			jQuery(this).append('<a href="javascript:void(0)" class="preview-popup">Preview popup</a>');
		});
	}

	jQuery(document).on('click', '.pm-template-selection .preview-popup', function() {
		var url = jQuery(this).parent().find('.pm-card-box').attr('href');
		var url_attributes = url.split('?');
		var url_attribute = url_attributes['1'].split('&');
		var popup_template = url_attribute['1'].replace('pm-template=', '');
		var popup_style = '';
		if ( typeof url_attribute['2'] != 'undefined' ) {
			popup_style = url_attribute['2'].replace('pm-style=', '');
		}
		if ( popup_template == 'image' || popup_style == 'minimalistic' || popup_style == 'dark' || popup_style == 'plain' || popup_style == 'party' || popup_style == 'paris' || popup_style == 'universe' || popup_template == 'video' || popup_template == 'likebox' || popup_style == 'style1' || popup_style == 'actionbar1' ) {
			var close_icon = pm_main.pm_plugin_uri+'admin/images/close-white.png';
		} else {
			var close_icon = pm_main.pm_plugin_uri+'admin/images/close.png';
		}

		var template_inputs = '';
		if ( popup_style == 'default' || popup_style == 'inline' || popup_style == 'sunny' || popup_style == 'plain' || popup_style == 'party' || popup_style == 'stuff' || popup_style == 'paris' || popup_style == 'christmas' || popup_style == 'universe' || popup_style == 'world' || popup_style == 'big' || popup_style == 'minimal' || popup_style == 'style2' || popup_template == 'actionbar' || popup_style == 'massive' || popup_style == 'minired' ) {
			template_inputs = '<div class="form-input-wrapper"><input type="email" value="Your email address" class="form-input-77235"></div><div class="form-input-wrapper"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="form-input-72936"></div>';
		} else if ( popup_style == 'minimalistic' || popup_style == 'dark' || popup_style == 'man' || popup_style == 'subtle' ) {
			template_inputs = '<div class="form-input-wrapper"><input type="text" value="Your name" class="form-input-77235"></div><div class="form-input-wrapper"><input type="email" value="Your email address" name="EMAIL" class="form-input-77235" id="mce-EMAIL"></div><div class="form-input-wrapper"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="form-input-72936"></div>';
		} else if ( popup_style == 'colorful' ) {
			template_inputs = '<div class="form-input-wrapper"><input type="text" placeholder="Your name" class="form-input-77235"></div><div class="form-input-wrapper"><input type="email" placeholder="Your email address" name="EMAIL" class="form-input-77235" id="mce-EMAIL"></div><div class="form-input-wrapper"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="form-input-72936"></div>';
		}
		
		jQuery.ajax({
			type: 'POST',
			url: pm_main.ajaxurl,
			data: { 
				'action': 'pm_demo_popup',
				'popup_template': popup_template,
				'popup_style': popup_style
			},
			success: function(data) {
				jQuery('#popup-preview-box').addClass('opened').addClass(popup_template).addClass(popup_style);
				jQuery('#popup-preview-box .inner-box').html(data);
				jQuery('#popup-preview-box .inner-box').find('.email-popup-main-form').append(template_inputs);
				jQuery('#popup-preview-box .inner-box').find('.email-popup-close').html('<img src="'+close_icon+'" alt="" />');
				if ( popup_style == 'party' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-close').css({'top': '0px', 'right': '0px'});
				}
				jQuery('#popup-preview-box .inner-box').find('[contenteditable="true"]').attr('contenteditable', 'false');
				if ( popup_template == 'image' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').css('min-height', '300px');
				}
				if ( popup_style == 'christmas' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-secondary-title').css('width', '50%');
				}
				if ( popup_template == 'likebox' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').append('<div class="pm-facebook-widget"><iframe allowtransparency="true" frameborder="0" scrolling="no" style="margin: 0;width: 100%;height: 154px;" src="//www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/cohhethemes&amp;width=490&amp;height=214&amp;colorscheme=light&amp;show_faces=true&amp;show_border=false&amp;stream=false&amp;header=false"></iframe></div>');
				}
				if ( popup_template == 'video' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').append('<iframe width="560" height="315" src="https://www.youtube.com/embed/6v2L2UGZJAM" frameborder="0" allowfullscreen></iframe>');
				}
				if ( popup_style == 'contacts' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-close').css({'top': '-20px', 'right': '-20px'});
					jQuery('#popup-preview-box .inner-box').find('.email-popup-main-title').css({'text-align': 'center', 'color': '#fff'});
					jQuery('#popup-preview-box .inner-box').find('.pm-contact-form').append('<div class="pm-contact-form" style="color: #fff;"><div role="form" class="wpcf7" id="wpcf7pm-f488-o1" lang="en-US" dir="ltr"><div class="screen-reader-response"></div><form action="" method="post" class="wpcf7pm-form" novalidate="novalidate"><p>Your Name (required)<br><span class="wpcf7pm-form-control-wrap your-name"><input type="text" name="your-name" value="" size="40" class="wpcf7pm-form-control wpcf7pm-text wpcf7pm-validates-as-required" aria-required="true" aria-invalid="false" style="border-color: #fff;"></span> </p><p>Your Email (required)<br><span class="wpcf7pm-form-control-wrap your-email"><input type="email" name="your-email" value="" size="40" class="wpcf7pm-form-control wpcf7pm-text wpcf7pm-email wpcf7pm-validates-as-required wpcf7pm-validates-as-email" aria-required="true" aria-invalid="false" style="border-color: #fff;"></span> </p><p>Subject<br><span class="wpcf7pm-form-control-wrap your-subject"><input type="text" name="your-subject" value="" size="40" class="wpcf7pm-form-control wpcf7pm-text" aria-invalid="false" style="border-color: #fff;"></span> </p><p>Your Message<br><span class="wpcf7pm-form-control-wrap your-message"><textarea name="your-message" cols="40" rows="10" class="wpcf7pm-form-control wpcf7pm-textarea" aria-invalid="false" style="border-color: #fff;"></textarea></span> </p><p><input type="submit" value="Send" class="wpcf7pm-form-control wpcf7pm-submit" style="background-color: #389851;border-color: #389851;color: #fff;"></p><div class="wpcf7pm-response-output wpcf7pm-display-none"></div></form></div></div>');
				}
				if ( popup_style == 'yellow' ) {
					jQuery('#popup-preview-box .inner-box').find('.pm-contact-form').append('<div class="pm-contact-form" style="color: #fff;"><div role="form" class="wpcf7" id="wpcf7pm-f488-o1" lang="en-US" dir="ltr"><div class="screen-reader-response"></div><form action="" method="post" class="wpcf7pm-form" novalidate="novalidate"><p>Your Name (required)<br><span class="wpcf7pm-form-control-wrap your-name"><input type="text" name="your-name" value="" size="40" class="wpcf7pm-form-control wpcf7pm-text wpcf7pm-validates-as-required" aria-required="true" aria-invalid="false" style="border-color: #fff;"></span> </p><p>Your Email (required)<br><span class="wpcf7pm-form-control-wrap your-email"><input type="email" name="your-email" value="" size="40" class="wpcf7pm-form-control wpcf7pm-text wpcf7pm-email wpcf7pm-validates-as-required wpcf7pm-validates-as-email" aria-required="true" aria-invalid="false" style="border-color: #fff;"></span> </p><p>Subject<br><span class="wpcf7pm-form-control-wrap your-subject"><input type="text" name="your-subject" value="" size="40" class="wpcf7pm-form-control wpcf7pm-text" aria-invalid="false" style="border-color: #fff;"></span> </p><p>Your Message<br><span class="wpcf7pm-form-control-wrap your-message"><textarea name="your-message" cols="40" rows="10" class="wpcf7pm-form-control wpcf7pm-textarea" aria-invalid="false" style="border-color: #fff;"></textarea></span> </p><p><input type="submit" value="Send" class="wpcf7pm-form-control wpcf7pm-submit" style="background-color: #389851;border-color: #389851;color: #fff;"></p><div class="wpcf7pm-response-output wpcf7pm-display-none"></div></form></div></div>');
					jQuery('#popup-preview-box .inner-box').find('.pm-contact-map').append('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d158857.72810871372!2d-0.24167964561640784!3d51.52877184029047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondon%2C+UK!5e0!3m2!1sen!2slv!4v1466492500767" width="600" height="450" frameborder="0" style="display: block; width: 100%; height: 625px;" allowfullscreen=""></iframe>');
					jQuery('#popup-preview-box .inner-box').find('.wpcf7pm-submit').css({'background-color': '#9D926F', 'border': '1px solid #9D926F'});
				}
				if ( popup_style == 'horizontal' ) {
					jQuery('#popup-preview-box .inner-box').find('.pm-contact-form').append('<div class="pm-contact-form" style="color: #fff;"><div role="form" class="wpcf7" id="wpcf7pm-f488-o1" lang="en-US" dir="ltr"><div class="screen-reader-response"></div><form action="" method="post" class="wpcf7pm-form" novalidate="novalidate"><p>Your Email (required)<br><span class="wpcf7pm-form-control-wrap your-email"><input type="email" name="your-email" value="" size="40" class="wpcf7pm-form-control wpcf7pm-text wpcf7pm-email wpcf7pm-validates-as-required wpcf7pm-validates-as-email" aria-required="true" aria-invalid="false" style="border-color: #fff;"></span> </p><p>Your Message<br><span class="wpcf7pm-form-control-wrap your-message"><textarea name="your-message" cols="40" rows="10" class="wpcf7pm-form-control wpcf7pm-textarea" aria-invalid="false" style="border-color: #fff;"></textarea></span> </p><p><input type="submit" value="Send" class="wpcf7pm-form-control wpcf7pm-submit" style="background-color: #389851;border-color: #389851;color: #fff;"></p><div class="wpcf7pm-response-output wpcf7pm-display-none"></div></form></div></div>');
					jQuery('#popup-preview-box .inner-box').find('.pm-contact-map').append('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d158857.72810871372!2d-0.24167964561640784!3d51.52877184029047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondon%2C+UK!5e0!3m2!1sen!2slv!4v1466492500767" width="600" height="450" frameborder="0" style="display: block; width: 100%; height: 150px;" allowfullscreen=""></iframe>');
					jQuery('#popup-preview-box .inner-box').find('.wpcf7pm-submit').css({'background-color': '#000', 'border': '1px solid #000'});
				}
				if ( popup_style == 'hyped' ) {
					jQuery('#popup-preview-box .inner-box').find('.pm-contact-form').css('padding', '0 20px 20px');
					jQuery('#popup-preview-box .inner-box').find('.pm-contact-form').append('<div class="pm-contact-form" style="color: #fff;"><div role="form" class="wpcf7" id="wpcf7pm-f488-o1" lang="en-US" dir="ltr"><div class="screen-reader-response"></div><form action="" method="post" class="wpcf7pm-form" novalidate="novalidate"><p style="color: #333;">Your Email (required)<br><span class="wpcf7pm-form-control-wrap your-email"><input type="email" name="your-email" value="" size="40" class="wpcf7pm-form-control wpcf7pm-text wpcf7pm-email wpcf7pm-validates-as-required wpcf7pm-validates-as-email" aria-required="true" aria-invalid="false"></span> </p><p style="color: #333;">Subject<br><span class="wpcf7pm-form-control-wrap your-subject"><input type="text" name="your-subject" value="" size="40" class="wpcf7pm-form-control wpcf7pm-text" aria-invalid="false"></span> </p><p style="color: #333;">Your Message<br><span class="wpcf7pm-form-control-wrap your-message"><textarea name="your-message" cols="40" rows="10" class="wpcf7pm-form-control wpcf7pm-textarea" aria-invalid="false"></textarea></span> </p><p><input type="submit" value="Send" class="wpcf7pm-form-control wpcf7pm-submit" style="background-color: #389851;border-color: #389851;color: #fff;"></p><div class="wpcf7pm-response-output wpcf7pm-display-none"></div></form></div></div>');
					jQuery('#popup-preview-box .inner-box').find('.pm-contact-map').append('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d158857.72810871372!2d-0.24167964561640784!3d51.52877184029047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondon%2C+UK!5e0!3m2!1sen!2slv!4v1466492500767" width="600" height="450" frameborder="0" style="display: block; width: 100%; height: 514px;" allowfullscreen=""></iframe>');
					jQuery('#popup-preview-box .inner-box').find('.wpcf7pm-submit').css({'background-color': '#1e73be', 'border': '1px solid #1e73be'});
				}
				if ( popup_style == 'right' ) {
					jQuery('#popup-preview-box .inner-box').find('.pm-contact-form').append('<div class="pm-contact-form" style="color: #fff;"><div role="form" class="wpcf7" id="wpcf7pm-f488-o1" lang="en-US" dir="ltr"><div class="screen-reader-response"></div><form action="" method="post" class="wpcf7pm-form" novalidate="novalidate"><p style="color: #555;">Your Email (required)<br><span class="wpcf7pm-form-control-wrap your-email"><input type="email" name="your-email" value="" size="40" class="wpcf7pm-form-control wpcf7pm-text wpcf7pm-email wpcf7pm-validates-as-required wpcf7pm-validates-as-email" aria-required="true" aria-invalid="false"></span> </p><p style="color: #555;">Your Message<br><span class="wpcf7pm-form-control-wrap your-message"><textarea name="your-message" cols="40" rows="10" class="wpcf7pm-form-control wpcf7pm-textarea" aria-invalid="false"></textarea></span> </p><p style="color: #555;"><input type="submit" value="Send" class="wpcf7pm-form-control wpcf7pm-submit" style="background-color: #389851;border-color: #389851;color: #fff;"></p><div class="wpcf7pm-response-output wpcf7pm-display-none"></div></form></div></div>');
					jQuery('#popup-preview-box .inner-box').find('.pm-contact-map').append('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d158857.72810871372!2d-0.24167964561640784!3d51.52877184029047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8a00baf21de75%3A0x52963a5addd52a99!2sLondon%2C+UK!5e0!3m2!1sen!2slv!4v1466492500767" width="600" height="450" frameborder="0" style="display: block; width: 100%; height: 150px;" allowfullscreen=""></iframe>');
					jQuery('#popup-preview-box .inner-box').find('.wpcf7pm-submit').css({'background-color': '#000', 'border': '1px solid #000'});
				}
				if ( popup_template == 'sidebar' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').css({
						'right': '0',
						'left': 'auto',
						'top': '32px',
						'-ms-transform': 'translate(0, 0)',
						'-webkit-transform': 'translate(0, 0)',
						'transform': 'translate(0, 0)'
					});
				}
				if ( popup_style == 'style2' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-disclaimer').css('margin-bottom', '30px');
				}
				if ( popup_template == 'actionbar' || popup_template == 'cookie' ) {
					if ( popup_style != 'cookie6' ) {
						jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').css({
							'width': '100%',
							'top': '32px',
							'-ms-transform': 'translate(-50%, 0)',
							'-webkit-transform': 'translate(-50%, 0)',
							'transform': 'translate(-50%, 0)'
						});
					} else {
						jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').css({
							'width': '400px',
							'bottom': '0px',
							'top': 'auto',
							'right': '0px',
							'left': 'auto',
							'-ms-transform': 'none',
							'-webkit-transform': 'none',
							'transform': 'none'
						});
					}
				}
				if ( popup_style == 'ribbon1' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').css({
						'top': '73px',
						'left': '180px',
						'-ms-transform': 'translate(0, 0)',
						'-webkit-transform': 'translate(0, 0)',
						'transform': 'translate(0, 0)'
					});
				}
				if ( popup_style == 'ribbon2' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').css({
						'top': '32px',
						'-ms-transform': 'translate(0, 0)',
						'-webkit-transform': 'translate(0, 0)',
						'transform': 'translate(0, 0)'
					});
				}
				if ( popup_style == 'ribbon3' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').css({
						'-ms-transform': 'rotate(45deg)',
						'-webkit-transform': 'rotate(45deg)',
						'transform': 'rotate(45deg)',
						'-webkit-transform-origin': '40% 265%',
						'-moz-transform-origin': '40% 265%',
						'-ms-transform-origin': '40% 265%',
						'-o-transform-origin': '40% 265%',
						'transform-origin': '40% 265%',
						'top': '0',
						'right': '0',
						'left': 'auto'
					});
				}
				if ( popup_template == 'tab' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').css({
						'right': '0',
						'left': 'auto',
						'-ms-transform': 'translate(0, -50%)',
						'-webkit-transform': 'translate(0, -50%)',
						'transform': 'translate(0, -50%)'
					});
				}
				if ( popup_template == 'messenger' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').css({
						'top': 'auto',
						'bottom': '0',
						'left': 'auto',
						'right': '30px',
						'-ms-transform': 'translate(0, 0)',
						'-webkit-transform': 'translate(0, 0)',
						'transform': 'translate(0, 0)'
					});
				}
				if ( popup_style == 'cookie1' || popup_style == 'cookie2' || popup_style == 'cookie5' ) {
					jQuery('#popup-preview-box .inner-box').find('.form-input-wrapper').after('<div class="clearfix"></div>');
				}
				if ( popup_template == 'locker' ) {
					var whole_html = jQuery('#popup-preview-box .inner-box').html();
					whole_html = whole_html.replace("{facebooke_like_button}", "<div class=\"pm-locker-item facebook-like\"><span class=\"locker-icon-overlay pmicon-facebook-official\"></span></div>");
					whole_html = whole_html.replace("{facebooke_share_button}", "");
					whole_html = whole_html.replace("{twitter_tweet_button}", "<div class=\"pm-locker-item twitter\"><span class=\"locker-icon-overlay pmicon-twitter\"></span></div>");
					whole_html = whole_html.replace("{twitter_follow_button}", "");
					whole_html = whole_html.replace("{gplus_button}", "<div class=\"pm-locker-item gplus\"><span class=\"locker-icon-overlay pmicon-gplus\"></span></div>");
					whole_html = whole_html.replace("{gplus_share_button}", "");
					whole_html = whole_html.replace("{linkedin_button}", "<div class=\"pm-locker-item linkedin\"><span class=\"locker-icon-overlay pmicon-linkedin-squared\"></span></div>");
					whole_html = whole_html.replace("{pinterest_button}", "<div class=\"pm-locker-item pinterest\"><span class=\"locker-icon-overlay pmicon-pinterest-squared\"></span></div>");
					jQuery('#popup-preview-box .inner-box').html(whole_html);
					jQuery('#popup-preview-box .inner-box').find('.pm-locker-item').css('display', 'inline-block');
				}
				if ( popup_style == 'massive' ) {
					jQuery('#popup-preview-box .inner-box').find('.email-popup-preview').css({
						'box-shadow': '0px 0px 0px 7px rgba(255, 255, 255, 0.4)'
					});
				}
				if ( popup_style == 'survey1' ) {
					jQuery('#popup-preview-box .main-survey-wrapper').addClass('fake-survey').append('<span class="survey-question">What are you expecting from us?</span><span class="survey-choice">Good service</span><span class="survey-choice">Fast responses</span><span class="survey-choice">24/7 support</span>');
				}
				if ( popup_style == 'survey2' ) {
					jQuery('#popup-preview-box .main-survey-wrapper').addClass('fake-survey').append('<div class="survey-question-wrapper" data-multiple="false"><span class="survey-question">Is our user interface easy to use?</span><div class="survey-answer-wrapper"><span class="survey-choice" data-key="option0">Yes</span><span class="survey-choice" data-key="option1">No</span><span class="survey-choice" data-key="option2">It needs improvements</span></div></div>');
				}
				if ( popup_style == 'survey3' ) {
					jQuery('#popup-preview-box .main-survey-wrapper').addClass('fake-survey').append('<div class="survey-question-wrapper" data-multiple="false"><span class="survey-question">Is there room to improve?</span><div class="survey-answer-wrapper"><span class="survey-choice" data-key="option0">No</span><span class="survey-choice" data-key="option1">Yes</span><span class="survey-choice" data-key="option2">Always</span></div></div>');
				}
				if ( popup_style == 'quiz' ) {
					jQuery('#popup-preview-box .inner-box').find('.form-input-wrapper').hide();
					jQuery('#popup-preview-box .main-survey-wrapper').addClass('fake-quiz').append('<div class="survey-question-wrapper quiz" data-multiple="false"><span class="survey-question">Where is the Eiffel tower located?</span><div class="main-quiz-image"><img src="http://cdn.history.com/sites/2/2015/04/hith-eiffel-tower-iStock_000016468972Large.jpg" alt=""></div><div class="survey-answer-wrapper"><span class="survey-choice" data-key="option0">London</span><span class="survey-choice" data-key="option1">Paris</span><span class="survey-choice" data-key="option2">India</span></div></div>');
				}
				if ( popup_style == 'quiz2' ) {
					jQuery('#popup-preview-box .inner-box').find('.form-input-wrapper').hide();
					jQuery('#popup-preview-box .main-survey-wrapper').addClass('fake-quiz').append('<div class="survey-question-wrapper quiz quiz2" data-multiple="false" style="background: #fff;"><span class="survey-question">Is this a mammal?</span><div class="main-quiz-image"><img src="http://www.paulnoll.com/Books/Clear-English/stereotype-mammal-37.jpg" alt="" style="width: 100%;display: block;"></div><div class="survey-answer-wrapper"><span class="survey-choice" data-key="option1">Yes</span><span class="survey-choice" data-key="option0">No</span></div></div>');
				}
				if ( popup_style == 'quiz3' ) {
					jQuery('#popup-preview-box .inner-box').find('.form-input-wrapper').hide();
					jQuery('#popup-preview-box .main-survey-wrapper').addClass('fake-quiz').append('<div class="survey-question-wrapper quiz quiz3" data-multiple="false"><div class="main-quiz-image"><img src="http://i.stack.imgur.com/goBR5.jpg" alt="" style="display: block;width: 100%;"></div><span class="survey-question">Does rain contain vitamin B12?</span><div class="survey-answer-wrapper"><span class="survey-choice" data-key="option0">No</span><span class="survey-choice" data-key="option1">Yes</span><span class="survey-choice" data-key="option2">Only when there is thunder</span></div></div>');
				}
				if ( popup_style == 'subtle' ) {
					var new_link = jQuery('#popup-preview-box .inner-box').find('.email-popup-close img').attr('src').replace('close.png', 'close-images/close-1.png');
					jQuery('#popup-preview-box .inner-box').find('.email-popup-close img').attr('src', new_link);
				}
			}
		});
	});

	jQuery(document).on('click', '#popup-preview-box .email-popup-close, #popup-preview-box .pm-verification-accept, #popup-preview-box .pm-verification-deny, #popup-preview-box.ribbon, #popup-preview-box.tab, #popup-preview-box.messenger, #popup-preview-box .cookie-law-agree, #popup-preview-box .cookie-law-readmore, #popup-preview-box.locker .inner-box', function() {
		jQuery('#popup-preview-box').attr('class', '');
		jQuery('#popup-preview-box .inner-box').html('');
	});

	jQuery(document).on('click', '.email-popup-preview-box a.email-popup-preview', function(e) {
		e.preventDefault();
	});

	function pm_get_parameter_from_url( url, parameter ) {
		if ( url == '' || typeof url == 'undefined' ) {
			return false;
		}
		var url_parsed = url.split('?');
		var correct_value = '';

		jQuery.each(url_parsed['1'].split('&'), function(index, value) {
			var curr_value = value.split('=');

			if ( curr_value['0'] == parameter ) {
				correct_value = curr_value['1'];
				return false;
			}
		});

		return correct_value;
	}

	if ( jQuery('.pm-template-selection').length ) {
		var active_templates = [];
		jQuery('.pm-template-selection li').each(function() {
			var curr_template = pm_get_parameter_from_url(jQuery(this).find('a.pm-card-box').attr('href'), 'pm-template');

			if ( jQuery.inArray( curr_template, active_templates ) === -1 && curr_template ) {
				active_templates.push(curr_template);
			}
		});

		jQuery.each(active_templates, function(index, value) {
			jQuery('.pm-sorting-wrapper').append('<a href="javascript:void(0)" class="pm-sorting-item" data-sorting="'+value+'">'+value+'</a>');
		});
	}

	jQuery(document).on('click', '.pm-sorting-wrapper a', function() {
		if ( jQuery(this).attr('data-sorting') == 'all' ) {
			jQuery('.pm-sorting-wrapper a').removeClass('active');
			jQuery('.pm-template-selection li').removeClass('sorting-hidden');
		} else {
			jQuery('.pm-sorting-wrapper a[data-sorting="all"]').removeClass('active');
		}
		jQuery(this).toggleClass('active');

		var sorting_array = [];
		jQuery('.pm-sorting-wrapper a.active').each(function() {
			if ( jQuery.inArray( jQuery(this).attr('data-sorting'), sorting_array) === -1 ) {
				sorting_array.push(jQuery(this).attr('data-sorting'));
			}
		});

		if ( sorting_array.length == 0 ) {
			jQuery('.pm-template-selection li').removeClass('sorting-hidden');
			jQuery('.pm-sorting-wrapper a[data-sorting="all"]').addClass('active');
		}

		if ( jQuery(this).attr('data-sorting') != 'all' && sorting_array.length > 0 ) {
			jQuery('.pm-template-selection li').each(function() {
				var curr_template = pm_get_parameter_from_url(jQuery(this).find('a.pm-card-box').attr('href'), 'pm-template');
				var current_template_item = jQuery(this);

				if ( jQuery.inArray( curr_template, sorting_array ) !== -1 ) {
					current_template_item.removeClass('sorting-hidden');
				} else {
					current_template_item.addClass('sorting-hidden');
				}
			});
			jQuery('.pm-template-selection li:last-child').removeClass('sorting-hidden');
		}
	});

	jQuery(document).on('click', '.popup-live-preview', function() {
		jQuery('.email-popup-live-preview').addClass('opened');
		if ( jQuery('.email-popup-preview-box > .email-popup-close').length ) {
			jQuery('.preview-device-inner').append(jQuery('.email-popup-preview-box > .email-popup-close')['0'].outerHTML);
		}
		jQuery('.preview-device-inner').append(jQuery('.email-popup-preview-box-overlay')['0'].outerHTML+jQuery('.email-popup-preview')['0'].outerHTML);
		jQuery('.preview-device-inner [contenteditable="true"]').attr('contenteditable', 'false');

		var selected_device = jQuery('.preview-controls ul li.selected').attr('data-device');
		var device_width = jQuery('.preview-device-wrapper').find('.preview-device-inner').width();
		var popup_width = jQuery('.email-popup-preview-box').find('.email-popup-preview').css('width').replace('px', '');

		if ( device_width < popup_width ) {
			if ( jQuery('.preview-device-inner').find('.email-popup-preview').hasClass('modal-fullscreen') || jQuery('.preview-device-inner').find('.email-popup-preview').hasClass('full-width') ) {
				jQuery('.preview-device-inner').find('.email-popup-preview').css('width', '100%');
			} else {
				jQuery('.preview-device-inner').find('.email-popup-preview').css('width', '90%');
			}
		} else {
			jQuery('.preview-device-inner').find('.email-popup-preview').css('width', popup_width);
		}
	});

	jQuery(document).on('click', '.preview-controls li', function() {
		jQuery('.preview-controls li').removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.preview-device-wrapper').attr('class', 'preview-device-wrapper '+jQuery(this).attr('data-device'));

		var selected_device = jQuery('.preview-controls ul li.selected').attr('data-device');
		var device_width = jQuery('.preview-device-wrapper').find('.preview-device-inner').width();
		var popup_width = jQuery('.email-popup-preview-box').find('.email-popup-preview').css('width').replace('px', '');

		if ( device_width*0.9 < popup_width ) {
			if ( jQuery('.preview-device-inner').find('.email-popup-preview').hasClass('modal-fullscreen') || jQuery('.preview-device-inner').find('.email-popup-preview').hasClass('full-width') ) {
				jQuery('.preview-device-inner').find('.email-popup-preview').css('width', '100%');
			} else {
				jQuery('.preview-device-inner').find('.email-popup-preview').css('width', '90%');
			}
		} else {
			jQuery('.preview-device-inner').find('.email-popup-preview').css('width', popup_width);
		}

	});

	jQuery(document).on('click', '.live-preview-close', function() {
		jQuery('.email-popup-live-preview').removeClass('opened');
		jQuery('.preview-device-inner').html('');
	});

	jQuery('#email-template-popup-location').trigger('change');

	if ( jQuery('#email-template-popup-target').val() != null ) {
		jQuery('#email-template-popup-target').trigger('change');
	} else {
		jQuery('#email-template-popup-exclude').trigger('change');
	}

	jQuery('[contenteditable="false"]').each(function() {
		jQuery(this).attr('contenteditable', 'true');
	});

	if ( jQuery('.email-popup-preview').length ) {
		var popup_html = jQuery('.email-popup-preview').attr('class', 'email-popup-preview')['0'].outerHTML;
		jQuery('.email-popup-preview').remove();
		jQuery('.email-popup-preview-box').append('<div class="email-popup-preview-wrapper">'+popup_html+'</div>');
		jQuery('#email-template-popup-location').trigger('change');

		jQuery(window).on('scroll resize', function() {
			jQuery('.email-popup-preview-box').height(jQuery('.email-popup-preview-box').parent().height()-(jQuery('.email-popup-preview-box').offset().top - jQuery('.email-popup-preview-box').parent().offset().top - jQuery('.email-popup-preview-box').parent().scrollTop()));
		});
	}

});

jQuery(window).load(function() {
	jQuery('#email-template-locker-facebook-like-text, #email-template-locker-facebook-share-text, #email-template-locker-twitter-text, #email-template-locker-twitter-follow-text, #email-template-locker-gplus-text, #email-template-locker-gplus-share-text, #email-template-locker-linkedin-text, #email-template-locker-pinterest-text').trigger("input");
	jQuery('#email-template-locker-facebook-like-status, #email-template-locker-facebook-share-status, #email-template-locker-twitter-status, #email-template-locker-twitter-follow-status, #email-template-locker-gplus-status, #email-template-locker-gplus-share-status, #email-template-locker-linkedin-status, #email-template-locker-pinterest-status').trigger('change');

	if ( jQuery('.email-popup-preview').length ) {
		jQuery('.email-popup-preview-box').height(jQuery('.email-popup-preview-box').parent().height()-(jQuery('.email-popup-preview-box').offset().top - jQuery('.email-popup-preview-box').parent().offset().top - jQuery('.email-popup-preview-box').parent().scrollTop()));
	}

	jQuery('#email-template-popup-bg-size-select, #email-template-popup-bg-position-select').trigger('change');
});

(function($) {    
  if ($.fn.style) {
    return;
  }

  // Escape regex chars with \
  var escape = function(text) {
    return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
  };

  // For those who need them (< IE 9), add support for CSS functions
  var isStyleFuncSupported = !!CSSStyleDeclaration.prototype.getPropertyValue;
  if (!isStyleFuncSupported) {
    CSSStyleDeclaration.prototype.getPropertyValue = function(a) {
      return this.getAttribute(a);
    };
    CSSStyleDeclaration.prototype.setProperty = function(styleName, value, priority) {
      this.setAttribute(styleName, value);
      var priority = typeof priority != 'undefined' ? priority : '';
      if (priority != '') {
        // Add priority manually
        var rule = new RegExp(escape(styleName) + '\\s*:\\s*' + escape(value) +
            '(\\s*;)?', 'gmi');
        this.cssText =
            this.cssText.replace(rule, styleName + ': ' + value + ' !' + priority + ';');
      }
    };
    CSSStyleDeclaration.prototype.removeProperty = function(a) {
      return this.removeAttribute(a);
    };
    CSSStyleDeclaration.prototype.getPropertyPriority = function(styleName) {
      var rule = new RegExp(escape(styleName) + '\\s*:\\s*[^\\s]*\\s*!important(\\s*;)?',
          'gmi');
      return rule.test(this.cssText) ? 'important' : '';
    }
  }

  // The style function
  $.fn.style = function(styleName, value, priority) {
    // DOM node
    var node = this.get(0);
    // Ensure we have a DOM node
    if (typeof node == 'undefined') {
      return this;
    }
    // CSSStyleDeclaration
    var style = this.get(0).style;
    // Getter/Setter
    if (typeof styleName != 'undefined') {
      if (typeof value != 'undefined') {
        // Set style property
        priority = typeof priority != 'undefined' ? priority : '';
        style.setProperty(styleName, value, priority);
        return this;
      } else {
        // Get style property
        return style.getPropertyValue(styleName);
      }
    } else {
      // Get CSSStyleDeclaration
      return style;
    }
  };
})(jQuery);