$(function (){

	function getAjaxURL()
	{
		return location.href.split('adminpanel')[0] + "adminpanel/ajax"
	}
	/*=========================== auto copy the urls ==============================*/

	$('.copy').click(function (){
		var children = this.parentElement.parentElement.children;
		var input = children[0];
		//console.log(children);

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

	/*================== Show tooltip =============================*/
	$('[data-toggle="tooltip"]').tooltip();

	/*================== delete user by id ========================*/
	$(".delete").click(function (){
		var id = $(this).attr('id');
	    var tr = $(this).parents('tr');

	    //alert($.url());

	    if(confirm("Are you sure you want to delete this user (id: "+id+") ?")){
	       $.ajax({
	       		url: getAjaxURL(),
	       		type: 'POST',
	       		data: "deleteUser=1&id="+id,
	       		success: function(r,s,xhr)
	       		{
	       			if (s == "success")
	       			{
	       				$(tr).slideUp('slow',function (){
	       					alert(r);
	       				});
	       			}
	       			else
	       			{
	       				alert(xhr.responseText);
	       			}
	       		},
	       });
	    }
	    else
	    {
	        return false;
	    }
	});


	/*================ Delete profile image =================*/

	$(".DeleteProfile").click(function (){
		var token = $(this).attr('id');

		if (confirm("Are you sure to Delete this profile image ?"))
		{
			$.ajax({
				url: getAjaxURL(),
				type: 'POST',
				data: "delete_image=1&token="+token,
				success: function (r,s,xhr)
				{
					if (s == 'success')
					{
						alert(r);
					}
				},
                error: function (xhr)
                {
                    alert(xhr.statusText);
                },
			});
		}
		else
		{
			return false;
		}
	});

	/*================ update profile data from admin =================*/
	$('#updateProfileUser').autosubmit('.msg','Saving ...');

	/*===================== Delete pages ======================*/

	$(".deletePage").click(function (){
	    var id = $(this).attr('id');
	    var tr = $(this).parents('tr');

	    if(confirm("Are you sure you want to delete this Page (id: "+id+")?"))
	    {
	       $.ajax({
	            url: getAjaxURL(),
	            type: 'POST',
	            data: "deletePage=1&id="+id,
	            success: function(r,s,xhr)
	            {
	                if (s == "success")
	                {
	                    $(tr).slideUp('slow',function (){
	                        alert(r);
	                    });
	                }
	            },
	            error: function (xhr)
	            {
	                alert(xhr.statusText);
	            },
	       });
	    }
	    else
	    {
	        return false;
	    }
	});

	/*===================== Delete pages ======================*/
	$(".deletePaymentMethod").click(function (){
	    var id = $(this).attr('id');
	    var tr = $(this).parents('tr');

	    if(confirm("Deleting a payment method is not recommended, you cound deactivate it instead. \n\nNo, I know what I'm doing, \njust delete this payment method (id: "+id+")?"))
	    {
	       $.ajax({
	            url: getAjaxURL(),
	            type: 'POST',
	            data: "deletePaymentMethod=1&id="+id,
	            success: function(r,s,xhr)
	            {
	                if (s == "success")
	                {
	                    $(tr).slideUp('slow',function (){
	                        alert(r);
	                    });
	                }
	            },
	            error: function (xhr)
	            {
	                alert(xhr.statusText);
	            },
	       });
	    }
	    else
	    {
	        return false;
	    }
	});
	/*======================= Edit the page data =========================*/
	$('#editPage').autosubmit('.msg','Saving ...');

	/*========================= upload logo adn icon ============================*/
	$(".upload").mouseenter(function(){
		$(this).children('.choose-image').show();
	});

	$(".upload").mouseleave(function(){
		$(this).children('.choose-image').hide();
	});

	$(".uploadLogoImage").change(function (){
		var input = $(this);
		var span = $(this).parents('.upload').children('.progress');
		var dataspan = span.html();
		var img = $(this).parents('.upload').children('img');

		$(this).parents('form').ajaxForm({
			beforeSend: function ()
			{
				$('.uploadMsg').hide();
				span.show();
			},
			uploadProgress: function (a,b,c,d)
			{
				span.html("<i class='fa fa-upload'></i> "+d+'%');
			},
			success: function (r,s,xhr)
			{
				//alert(r);
				$('.uploadMsg').html(r).slideDown(function (){
					span.fadeOut().html(dataspan);

					var src = img.attr('src');
					img.attr('src',src+'?m='+Math.random());
				});
				input.val('');
			},

		}).submit();
	});

	/*======================== Update settings data of the website ==============================*/
	$('.optionForm').autosubmit('.msg','Saving ...');

	/*================== delete link by id ========================*/
	$(".delete_link").click(function (){
		var id = $(this).attr('id');
	    var box = $(this).parents('.panel-info');

	    //alert(id);

	    if(confirm("Are you sure you want to delete this link (id: "+id+") ?")){
	       $.ajax({
	       		url: getAjaxURL(),
	       		type: 'POST',
	       		data: "deleteLink=1&id="+id,
	       		success: function(r,s,xhr)
	       		{
	       			if (s == "success")
	       			{
	       				$(box).slideUp('slow',function (){
	       					alert(r);
	       					$(this).html('');
	       				});
	       			}
	       			else
	       			{
	       				alert(xhr.responseText);
	       			}
	       		},
	       });
	    }
	    else
	    {
	        return false;
	    }
	});

	/*===================== Delete language ======================*/

	$(".deleteLang").click(function (){
	    var id = $(this).attr('id');
	    var tr = $(this).parents('tr');

	    if(confirm("Are you sure you want to delete this language (ID: "+id+")?\nremember, the translated files will be removed."))
	    {
	       $.ajax({
	            url: getAjaxURL(),
	            type: 'POST',
	            data: "deleteLang=1&id="+id,
	            success: function(r,s,xhr)
	            {
	                if (s == "success")
	                {
	                    $(tr).slideUp('slow',function (){
	                        alert(r);
	                    });
	                }
	            },
	            error: function (xhr)
	            {
	                alert(xhr.statusText);
	            },
	       });
	    }
	    else
	    {
	        return false;
	    }
	});

	/*===================== wysihtml5 ======================*/
	$('#some-textarea').wysihtml5();


}); // end
