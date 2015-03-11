/**
 * Functionality specific to Bootship.
 *
 * Provides helper functions to enhance the theme experience.
 */

( function( $ ) {
	var body    = $( 'body' ),
	    _window = $( window );

  /**
   * Changed Gravity Forms Default Style to Bootstrap Style
   */
  var gform = $(document).find('.gform_wrapper').attr('class');
  if(typeof gform !== 'undefined' && gform !== 'false'){
    $(document).on('gform_post_render',function(){
      var form = $('.gform_wrapper');
      var required = $('.gfield_contains_required');
      var controlGroup = $('.gfield');
      required.each(function(){
        $(this).find('input, textarea, select').not('input[type="checkbox"], input[type="radio"]').attr('required', 'true');
      });
      $('.gform_fields').each(function(){
        $(this).addClass('row');
      });
      controlGroup.each(function(){
        $(this).addClass('form-group').find('input, textarea, select').not('input[type="checkbox"], input[type="radio"], input[type="file"]').after('<span class="help-block"></span>').addClass('form-control');
      });
      form.find("input[type='submit'], input[type='button']").addClass('btn btn-primary btn-lg pull-right').end().find('.gfield_error').removeClass('gfield_error').addClass('has-error');
      $('.gfield_checkbox, .gfield_radio').find('input[type="checkbox"], input[type="radio"]').each(function(){
        var sib = $(this).siblings('label');
        $(this).prependTo(sib);
      }).end().each(function(){
        $(this).after('<span class="help-block"></span>');
        if($(this).is('.gfield_checkbox')){
          $(this).addClass('checkbox');
        } else {
          $(this).addClass('radio');
        }
      });
      $('.validation_message').each(function(){
        var sib = $(this).prev().find('.help-block');
        $(this).appendTo(sib);
      });
      $('.validation_error').addClass('alert alert-danger');
      $('.gf_progressbar').addClass('progress progress-striped active').children('.gf_progressbar_percentage').addClass('progress-bar progress-bar-success');
    });
  }

	/**
	 * Adds a top margin to the footer if the sidebar widget area is higher
	 * than the rest of the page, to help the footer always visually clear
	 * the sidebar.
	 */
	$( function() {
		if ( body.is( '.sidebar' ) ) {
			var sidebar   = $( '#secondary .widget-area' ),
			    secondary = ( 0 === sidebar.length ) ? -40 : sidebar.height(),
			    margin    = $( '#tertiary .widget-area' ).height() - $( '#content' ).height() - secondary;

			if ( margin > 0 && _window.innerWidth() > 999 ) {
				$( '#colophon' ).css( 'margin-top', margin + 'px' );
			}
		}
	} );

	/**
	 * Enables menu toggle for small screens.
	 */
	( function() {
		var nav = $( '#site-navigation' ), button, menu;
		if ( ! nav ) {
			return;
		}

		button = nav.find( '.menu-toggle' );
		if ( ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		button.on( 'click.bootship', function() {
			nav.toggleClass( 'toggled-on' );
		} );

		// Better focus for hidden submenu items for accessibility.
		menu.find( 'a' ).on( 'focus.bootship blur.bootship', function() {
			$( this ).parents( '.menu-item, .page_item' ).toggleClass( 'focus' );
		} );
	} )();

	/**
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
	_window.on( 'hashchange.bootship', function() {
		var element = document.getElementById( location.hash.substring( 1 ) );

		if ( element ) {
			if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
				element.tabIndex = -1;
			}

			element.focus();
		}
	} );

	/**
	 * Arranges footer widgets vertically.
	 */
	if ( $.isFunction( $.fn.masonry ) ) {
		var columnWidth = body.is( '.sidebar' ) ? 228 : 245;

		$( '#secondary .widget-area' ).masonry( {
			itemSelector: '.widget',
			columnWidth: columnWidth,
			gutterWidth: 20,
			isRTL: body.is( '.rtl' )
		} );
	}
} )( jQuery );
