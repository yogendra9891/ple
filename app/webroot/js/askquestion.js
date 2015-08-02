$(document).ready(function(){
	   //js for tree view.
	$("#tree").treeview({
		animated: "fast",
		control:"#sidetreecontrol"
	});
	$('.tobetoggle').click(function(){
		$('#collapse').toggleClass('tobehide');
		$('#expand').toggleClass('tobehide');
	});
});
