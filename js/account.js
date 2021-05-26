var ajaxStr = {}; // this is Global variable

var BASE_URL = document.querySelector('span[data-base-url]').getAttribute('data-base-url').trim()

/*======================== Get ajax strings ====================================*/
$.ajax({
	url: BASE_URL+'ajax/jsAjaxStrings',
	type: 'GET',
	success: function (r, s, xhr){
		if (s == 'success')
		{
			ajaxStr = r;
			//console.log(ajaxStr);

			$(function (){


				/*======================== Add a new link ====================================*/
				$(".Addlink").autosubmit('.msg','<i class="fa fa-spin fa-spinner"></i> ' + ajaxStr['ajax.str.1']);

				/*======================== show and hide the box profile to change it ========*/

				$('.box-profile-img').mouseenter(function (){
					$('.box-profile-img .pencil').hide();
					$('.box-profile-img span').show();

				});

				$('.box-profile-img').mouseleave(function (){
					$('.box-profile-img .pencil').show();
					$('.box-profile-img span').fadeOut();
				});

				/*======================== upload profile image ====================================*/

				$('input[type=file]').change(function (){

					$('#form-img').ajaxForm({
						beforeSend: function ()
						{
							$(".progressBox").show();
						},
						uploadProgress: function(a,b,c,d)
						{
							$(".progressBox").html(d+"%");
						},
						success: function(r,s,xhr)
						{
							$(".progressBox").fadeOut('slow');
							if (s == 'success')
							{
								$("input[type=file]").val("");
								$('.msg').slideUp(function (){
									$(this).html(r).slideDown('slow').delay(6000).slideUp('slow',function (){
										$(this).html("");
									});
								});

								// reload src of image
								$(".pro-img").attr('src',$('.profile-img').attr('src')+"?"+Math.random());
							}
							else
							{
								alert(ajaxStr['ajax.str.2']);
							}
						},
					}).submit();

				});

				/*=========================== Update withdrawal method ==============================*/
				$('#updateWithdrawalMethod').autosubmit('.msg', ajaxStr['ajax.str.3']);

				/*=========================== Update profile ==============================*/
				$('#updateProfile').autosubmit('.msg', ajaxStr['ajax.str.3']);

				/*=========================== Update password ==============================*/
				$('#updatePassword').autosubmit('.msg', ajaxStr['ajax.str.3']);

				/*=========================== Hide the box of shorted links ==============================*/

				$('#goBack').click(function (){
					$('.msg').fadeOut();
					$('#urls').slideUp(function (){
						$('#boxToAddLink').slideDown();
					});
				});

				/*============================ delete links =============================*/

				$('.boxLink .deleteLink').click(function(){
					var id = $(this).attr('id');
					var box = $(this).parents('.boxLink');

					if (confirm(ajaxStr['ajax.str.4']))
					{
						$.ajax({
							url: BASE_URL+'account/ajax',
							type: 'POST',
							data: 'id='+id+'&deleteLink=yes',
							success: function(r,s,xhr)
							{
								if (s == 'success')
								{
									alert(r.replace(new RegExp("\n\r", 'g'), ''));
									box.slideUp(function ()
									{
										$(this).html('');
									});
								}
							},
							error: function(xhr)
							{
								alert("Error : "+xhr.status+" "+xhr.statusText);
							}
						});
					}

				});

				/*=========================== auto copy the urls ==============================*/

				$('.copy').click(function (){
					var children = this.parentElement.parentElement.children;
					var input = children[1];
					input.select();
					document.execCommand('copy');

					this.classList.replace('btn-primary', 'btn-success');
					this.textContent = 'Copied';
					clearSelection();

					setTimeout((function (){
						this.textContent = 'Copy';
						this.classList.replace('btn-success', 'btn-primary');
					}).bind(this), 2000);
				});

				// clear selected items
				function clearSelection() {
				    if ( document.selection ) {
				        document.selection.empty();
				    } else if ( window.getSelection ) {
				        window.getSelection().removeAllRanges();
				    }
				}

				/*=========================== update User Settings ==============================*/

				$('#updateUserSettings').autosubmit('.msg', ajaxStr['ajax.str.3']);

				/*========================= delete Account By User  deleteAccountByUser ============================*/

				$('#deleteAccountByUser').click(function(){
					var btn = $(this);

					if (confirm(ajaxStr['ajax.str.5']))
					{
						var pass = window.prompt(ajaxStr['ajax.str.6']);
						if (pass)
						{
							$.ajax({
								url: BASE_URL+'account/ajax',
								type: 'POST',
								data: 'pass='+pass+'&blockAccount=yes',
								beforeSend: function ()
								{
									$('.msg').hide();
									btn.hide();
								},
								success: function(r,s,xhr)
								{
									if (s == 'success')
									{
										//alert(r);
										$('.msg').html(r).slideDown();
									}
								},
								error: function(xhr)
								{
									alert("Error : "+xhr.status+" "+xhr.statusText);
								}
							});
						}
					}
				});

			}); // end
		}
	},
	error: function (xhr){
		console.log("Error : "+xhr.status+" "+xhr.statusText);
	},
});

