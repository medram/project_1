/*------------ navbar scroled ------------*/

window.onscroll = function (){

	// add check the navbar theme
	changeNavbarTheme();
};

// change the theme of navbar onscrolling
function changeNavbarTheme()
{
	let navbar = document.querySelector('.navbar');

	if (window.pageYOffset < 10 && navbar.classList.contains('navbar-scrolled'))
	{
		// remove class
		navbar.classList.remove('navbar-scrolled');
	}
	else if (window.pageYOffset > 10 && !navbar.classList.contains('navbar-scrolled'))
	{
		// add class
		navbar.classList.add('navbar-scrolled');
	}
}


(function ($){

	$.url = function ()
	{
		var protocol = window.location.protocol;
		var hostname = window.location.hostname;
		var pathname = window.location.pathname;
		var search   = window.location.search;
		var hash     = window.location.hash;

		var url = protocol+'//'+hostname+pathname;
		//console.log(path);
		return url;
	};

	$.fn.autosubmit = function(Msg,btnString='')
	{
		this.submit(function(e) {

			e.preventDefault();

			var form = $(this);
			//var form = $(e.target);
			var btn = form.find('button');
			var btndata = btn.html();

			if (btnString == '')
			{
				btnString = btndata;
			}

			//alert(form.serialize());

			//alert(form.attr('method'));

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				beforeSend: function ()
				{
					$(Msg).slideUp();
					btn.attr("disabled","disabled").html(btnString);
				},
				success: function (r,s,xhr)
				{
					if (s == 'success')
					{
						$(Msg).html(r).slideDown('slow',function (){
							btn.removeAttr('disabled').html(btndata);
						});
					}
				},
				error: function (xhr)
				{
					alert("Error : "+xhr.status+" "+xhr.statusText);
				},
			});
			//return false;
		})
		return false;
	}



})(jQuery);
