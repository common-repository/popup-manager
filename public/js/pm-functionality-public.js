(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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
	if ( jQuery('.email-popup-preview-wrapper.pm-image-template').length ) {
		var popup_height = parseInt(jQuery('.email-popup-preview-wrapper.pm-image-template .email-popup-preview').css('height').replace('px', ''));
		var popup_width = parseInt(jQuery('.email-popup-preview-wrapper.pm-image-template .email-popup-preview').css('width').replace('px', ''));
		if ( popup_width > jQuery(window).width() ) {
			jQuery('.email-popup-preview-wrapper.pm-image-template .email-popup-preview').style('width', (jQuery(window).width()*0.9)+'px', 'important');
		}
		if ( popup_height > jQuery(window).height() ) {
			jQuery('.email-popup-preview-wrapper.pm-image-template .email-popup-preview').style('height', (jQuery(window).height()*0.9)+'px', 'important');
		}
	};

	jQuery('.email-popup-preview.modal-fullscreen').append(jQuery('.email-popup-preview.modal-fullscreen .email-popup-close-wrapper').html());
	jQuery('.email-popup-preview.modal-fullscreen .email-popup-close-wrapper').hide();

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
		jQuery('.email-main-wrapper').prepend(style_tag);
	}

	jQuery(document).on('click', '.email-popup-preview', function(e) {
		if ( jQuery(e.target).is('img') ) {
			e.preventDefault();
		}
	});

	if ( jQuery('.email-popup-preview-inner input[type=submit]').length ) {
		jQuery('.email-popup-preview-inner input[type=submit]').css('background', jQuery('.email-popup-preview-inner input[type=submit]').css('background-color'))
	}

	if ( jQuery('.email-popup-close-wrapper').hasClass('close-outside') ) {
		jQuery('.email-main-wrapper').prepend(jQuery('.email-popup-close-wrapper .email-popup-close').css('z-index', '9999')['0'].outerHTML);
	}

	var class_change = setInterval(function() {
		if ( jQuery(".email-main-wrapper").hasClass("opened") ) {
			clearInterval(class_change);
			
			setTimeout(function() {
				jQuery(".email-main-wrapper").addClass('remove-blur');
			}, 1000);
		}
	}, 250);

	jQuery(document).on('click', 'input[type="checkbox"], input[type="radio"]', function() {
		jQuery(this).parent().toggleClass('active');
	});

	jQuery(document).on('submit', 'form.email-popup-main-form', function(e) {
		var current_email_form = jQuery(this);

		if ( current_email_form.attr('action').indexOf('constantcontact.com') >= 0 ) {
			e.preventDefault();

			current_email_form.find('[type="submit"]').addClass('form-loading');
			jQuery.ajax({
				url: current_email_form.attr('action'),
				type: 'post',
				data: current_email_form.serialize(),
				success: function( data ) {
					if ( data.success == true ) {
						current_email_form.find('.form-input-error').hide();
						current_email_form.parent().find('.email-popup-close').click();
					}
					current_email_form.find('[type="submit"]').removeClass('form-loading');
				},
				error: function( data ) {
					var parsed_response = jQuery.parseJSON( data.responseText );

					if ( current_email_form.find('.form-input-error').length ) {
						current_email_form.find('.form-input-error').html(parsed_response.offenders['0'].err);
					} else {
						current_email_form.find('[type="submit"]').before('<span class="form-input-error">'+parsed_response.offenders['0'].err+'</span>');
					}
					current_email_form.find('[type="submit"]').removeClass('form-loading');
				}
			});
		}
	});
});

jQuery(window).load(function() {

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