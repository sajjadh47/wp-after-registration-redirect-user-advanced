jQuery( document ).ready( function( $ )
{
	$( document ).on( 'keydown.autocomplete', '#wparua_registration_redirect_url', function()
	{
		var options = { source: WpAfterRegistrationRedirectUserAdvanced.urlSugestions };

		$( this ).autocomplete( options );
	} );

	$( '#wparua_registration_redirect_enable' ).click( function( event )
	{
		$( '.wparua_registration_redirect_filter_message' ).hide( 'slow' );
		
		var data =
		{
			wparua_registration_redirect_enable : 'off',
			action  							: 'wparua_save_enable_disable_toggle',
			wparua_nonce   						: $( '#wparua_nonce' ).val(),
		};
		
		if ( $( this ).is( ':checked' ) )
		{
			data.wparua_registration_redirect_enable = 'on';
		}
		
		$.post( ajaxurl, data, function( response )
		{
			$( '.wparua_registration_redirect_filter_message p' ).text( response.message );

			$( '.wparua_registration_redirect_filter_message' ).removeClass( 'notice-error notice-success' ).addClass( response.type ).show( 'slow' );

			if ( response.type == 'notice-error' )
			{
				if ( $( _this ).is( ':checked' ) )
				{
					$( _this ).prop( 'checked', false );
				}
				else
				{
					$( _this ).prop( 'checked', true );
				}
			}
		} );
	} );

	$( '#wparua_registration_redirect_filter_submit' ).click( function( event )
	{
		event.preventDefault();

		$( '.wparua_registration_redirect_filter_message' ).hide( 'slow' );

		$( this ).text( WpAfterRegistrationRedirectUserAdvanced.savingTxt ).prop( 'disabled', true );

		var data =
		{
			wparua_registration_redirect_to_url :  $( '#wparua_registration_redirect_url' ).val(),
			action  							: 'wparua_save_redirect_filter',
			wparua_nonce   						: $( '#wparua_nonce' ).val(),
		};

		$.post( ajaxurl, data, function( response )
		{
			$( '#wparua_registration_redirect_filter_submit' ).text( WpAfterRegistrationRedirectUserAdvanced.settingsSavedTxt );

			setTimeout( function()
			{
				$( '#wparua_registration_redirect_filter_submit' ).text( WpAfterRegistrationRedirectUserAdvanced.saveChangesTxt ).prop( 'disabled', false );

			}, 2000 );

			$( '.wparua_registration_redirect_filter_message p' ).text( response.message );

			$( '.wparua_registration_redirect_filter_message' ).removeClass( 'notice-error notice-success' ).addClass( response.type ).show( 'slow' );
		} );
	} );
} );