$(function (){
	
	/*======================== Add a new link ====================================*/
	$(".Addlink").autosubmit('.msg','<i class="fa fa-spin fa-spinner"></i> الإختصار جار ...');
	
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
					alert('عذرا، لقد حدث خطأ غير متوقع، أعد المحاولة . ');
				}
			},
		}).submit();
	
	});

	/*=========================== Update profile ==============================*/
	$('#updateProfile').autosubmit('.msg','جار الحفظ ...');

	/*=========================== Update password ==============================*/
	$('#updatePassword').autosubmit('.msg','جار الحفظ ...');

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

		if (confirm('هل أنت متأكد من حذف هذا الرابط ؟'))
		{
			$.ajax({
				url: $.url()+'/../../../ajax',
				type: 'POST',
				data: 'id='+id+'&deleteLink=yes',
				success: function(r,s,xhr)
				{
					if (s == 'success')
					{
						alert(r);
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

	$('#updateUserSettings').autosubmit('.msg','الحفظ جار ...');

	/*========================= delete Account By User  deleteAccountByUser ============================*/

	$('#deleteAccountByUser').click(function(){
		btn = $(this);
		
		if (confirm('هل أنت متأكد من حذف حسابك ؟'))
		{
			var pass = window.prompt('أدخل كلمة المرور لحذف حسابك');
			if (pass)
			{
				$.ajax({
					url: $.url()+'/../ajax',
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