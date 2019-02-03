/**
 * 
 */
jQuery(document).ready(function(){

	jQuery("#savename").click(function(){
		var name = jQuery('#name').val();

		// you can apply validation here on the name field.
		jQuery.post("/components/com_clubdata/ajax.php?name="+name , {}, 
			function(response){
				jQuery('#results').html(jQuery(response).fadeIn('slow'));
			});
	});
});