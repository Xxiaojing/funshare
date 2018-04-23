$(document).ready(function(){

	$('button[name=likes]').on('click', function(){
		var id = $(this).attr("id");
		$('input[name=likeVar]').val(id);
    });
	
	$('button[name=comment]').on('click', function(){
		var id = $(this).attr("id");
		$('input[name=commentVar]').val(id);
    });	
	
/*	
    $('#postID').on('change', function(){
        var postID = $(this).val();
        if(postID){
            $.ajax({
                type: 'POST',
                url: 'update.php',
                data: { name: "John", location: "Boston" }
                success:function(html){
                    $('#postID').html(html);
                }
            });
        }
    });	
	
	
    $('#postID').on('change', function(){
        var postID = $(this).val();
        if(postID){
            $.ajax({
                type: 'POST',
                url: 'update.php',
                data: 'countries_id='+countryID,
                success:function(html){
                    $('#postID').html(html);
                }
            });
        }
    });
    
    $('#postID').on('change', function(){
        var postID = $(this).val();
        if(postID){
			$.ajax({
			  method: "POST",
			  url: "some.php",
			  data: { name: "John", location: "Boston" }
			})
		    .done(function( msg ) {
			  alert( "Data Saved: " + msg );
		    });
        }
    });
*/
    
});