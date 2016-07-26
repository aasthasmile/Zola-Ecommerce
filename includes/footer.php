</div><br><br>
	<footer class="text-center" id="footer"> &copy: Copyright 2015-2018 Zolas Ecommerce</footer>



<script >
	jQuery(window).scroll(function(){
		var vscroll=jQuery(this).scrollTop();
		jQuery('#text').css({
			"transform" :"translate(0px,"+vscroll/2+"px)"
		});

	});
	


function detailsmodal(id){
	var data={"id":id};
	jQuery.ajax({
		url:'/ecommerce/includes/detailsmodal.php',
		method :"post",
		data : data,
		success: function(data){
			jQuery('body').append(data);
			jQuery('#details-modal').modal('toggle');
		},
		error: function(){
			 alert('Something went wrong');
		} 

	});
}	
</script>
</body>
</html>	