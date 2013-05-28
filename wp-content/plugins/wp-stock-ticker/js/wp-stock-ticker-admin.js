
jQuery(function($) {

  //$('ul#stocks').liScroll({travelocity: 0.05});

  $('#add_admin_stock_field').click(function() {
	if ( $('#st_options_body tr').length >= 5 ){
		alert( 'This version only supports 5 stock codes and 5 currencies to be added to the plugin. Consider going Pro!' );
		return false;
	}
    $('#st_options_body').append(
      '<tr valign="top" class="stock_ticker_row">' + 
      '<td><input type="text" class="st_symbol" name="s_ticker_stock_codes[]" value="" /></td>' + 
	  '<td><input type="text" class="st_symbol" name="s_ticker_stock_names[]" value="" /></td>' +
      '<td><a href="" class="label delete" id="delete_admin_stock">delete</a></td></tr>'
    );
    return false;
  });
  
  $('#add_admin_currency_field').click(function() {
	if ( $('#st_currency_options_body tr').length >= 5 ){
		alert( 'This version only supports 5 stock codes and 5 currencies to be added to the plugin. Consider going Pro!' );
		return false;
	}
	$('#st_currency_options_body').append(
      '<tr valign="top" class="stock_ticker_row">' + 
      '<td><input type="text" class="st_symbol" name="s_ticker_currency_codes[]" value="" /></td>' + 
	  '<td><input type="text" class="st_symbol" name="s_ticker_currency_names[]" value="" /></td>' +
      '<td><a href="" class="label delete" id="delete_admin_currency">delete</a></td></tr>'
    );
    return false;											
  });

  $('.st_symbol').live('change', function() {
    vvalue = $(this).val();
    $(this).attr('value', vvalue);
  });

  $('#delete_admin_stock').live('click', function() {
    $(this).parents('tr').remove();
    return false;
  });
  
   $('#delete_admin_currency').live('click', function() {
    $(this).parents('tr').remove();
    return false;
  });
})