/*!
 * Start Bootstrap - SB Admin 2 v3.3.7+1 (http://startbootstrap.com/template-overviews/sb-admin-2)
 * Copyright 2013-2016 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
$(function() {
    $('#side-menu').metisMenu();
});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});

$(document).ready(function() {
	
	$('[data-toggle="popover"]').popover();
	$('#ed-usr-blk').hide();
	$('#del-usr-blk').hide();			
	$('#ed-cat-blk').hide();
	$('#edusr-blk').hide();
	$('#chpwd-blk').hide();
	$('#ed-cat-blk').hide();	
	$('#add-cat-item-blk').hide();
	$("#edcat-blk-win").hide();

/* Adding / Editing of user info - begins here */	
	// Add user block display routine
	$('#add-user').on("click", function(e) {
		e.preventDefault();
		$('#add-usr-blk').toggle('slow');	
		$('#ed-cat-blk').hide();
		$('#add-cat-item-blk').hide();
	});

	// Adding a new user window display routine
	$('#add-usr-btn').on("click", function(e) {
		e.preventDefault();
		$("#addnusr input[type=text], #addnusr input[type=password]").each(function() {
			$("#" + $(this).attr("id") + "-error").empty();
			$("#" + $(this).attr("id") + "-status").val('');
			$(this).css("border", "1px solid #ccc");	
		});
		
		$('#new-usr-blk').toggle('slow');	
		$('#ed-usr-blk').hide();
		$('#del-usr-blk').hide();
	});

	// Edit user window display routine
	$('#ed-usr-btn').on("click", function(e) {
		e.preventDefault();
		$('#ed-get-usr').prop('selectedIndex',0).trigger("change");		
		$('#new-usr-blk').hide();	
		$('#ed-usr-blk').toggle('slow');
		$('#del-usr-blk').hide();
	});

	// If no option is selected, hide all edit window sliders
	$("#ed-get-usr").on("change", function() {
		var opval = $(this).val();
		
		if(opval == '')
		{
			$("#ed-blk").children().hide();
		}
	});
	
	// Delete user window display routine
	$('#del-usr-btn').on("click", function(e) {
		e.preventDefault();
		$('#new-usr-blk').hide();	
		$('#ed-usr-blk').hide();
		$('#del-usr-blk').toggle('slow');
	});
	
	// Edit selected user routine - Starts here
	$('#ed-sel-usr').on("click", function(e) {		
		e.preventDefault();	
		// Reset all error messages		
		$("#edusr input[type=text]").each(function() {
			$("#" + $(this).attr("id") + "-error").empty();
		});
		
		$("#chpwd-blk").hide();		
		var sel = $('#ed-get-usr').val();
		if(sel != '')
		{						
			$.ajax({
				url: 'http://localhost/budgcal/login/user_exist_ajax',
				data: {"e-usr":sel, "usr": "edit"},
				dataType: "json",	
				type: "POST",
				beforeSend: function(){
					//$('#eml-load').append('<img src="http://localhost/budgcal/assets/images/loading_30x30.gif" alt="loader">');
				}, 
				complete: function() {
					//$('#eml-load').hide();
				},
				success: function(data) {
					
					if(data)
					{
						$('#e-fname').val(data.first_name);
						$('#e-lname').val(data.last_name);
						$('#e-eml').val(data.email);						
						$('#ed-usr-id').val(sel);						
						$('#edusr-blk').toggle('slow');												
					}
				},
				error: function(data) {
					;
				}
			});		
		}
		else
		{
			bootbox.alert({
				message: "Please choose one of the options",
				backdrop: true
			});			
			$('#edusr-blk').hide();
		}
	});
	// Edit selected user routine - Ends here
	
	// Change password for selected user routine - Starts here
	$('#ed-ch-pwd-usr').on("click", function(e) {
		e.preventDefault();
		// Reset all error messages		
		$("#edchpwd input[type=password]").each(function() {
			$("#" + $(this).attr("id") + "-error").empty();
		});
		
		// Get user id
		var sel = $('#ed-get-usr').val();
		if(sel != '')
		{
			// Show change password block	
			$("#chpwd-blk").toggle('slow');
			$('#edusr-blk').hide();		
			
			// Populate hidden field with user id value										
			$("#usr-pw-id").val(sel);			
		}
		else
		{
			bootbox.alert({
				message: "Please choose one of the options",
				backdrop: true
			});			
			$("#chpwd-blk").hide();
		}
	});
	// Change password for selected user routine - Ends here
		
	$("#ed-del-usr").on("click", function(e) {
		e.preventDefault();
		var sel = $('#ed-get-usr').val();
		if(sel != '')
		{
			$("#chpwd-blk").hide();
			$('#edusr-blk').hide();												
						
			bootbox.confirm("Are you sure you want to delete this user?", function(result) {
				if(result)
				{
					$.ajax({
						url: 'http://localhost/budgcal/login/del_user_ajax',
						data: {"user":sel},	
						type: "POST",
						beforeSend: function(){
							//$('#eml-load').append('<img src="http://localhost/budgcal/assets/images/loading_30x30.gif" alt="loader">');
						}, 
						complete: function() {
							//$('#eml-load').hide();
						},
						success: function(data) {
							console.log(data);
							if(data)
							{
								bootbox.alert({
									message: "User deleted successfully",
									backdrop: true,
									callback: function () {
 								       location.reload();
    								}
								});			
							}
							else
							{
								bootbox.alert({
									message: "There was an error. Please try again later!",
									backdrop: true
								});			
							}
						},
						error: function(data) {
							;
						}
					});	
				}
			})
		}
		else
		{
			bootbox.alert({
				message: "Please choose one of the options",
				backdrop: true
			});						
		}
	});

	// Add new user routine - Starts here
	$("#add-new-usr-btn").on("click", function(e) {
		e.preventDefault();
		
		var status = [];		
		$("#addnusr input[type=text], #addnusr input[type=password]").each(function() {
			val = $("#" + $(this).attr('id')).val();
			
			if(val === '')
			{
				$("#" + $(this).attr('id') + "-error").empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Required field</span>');							
				$("#" + $(this).attr('id')).css("border", "1px solid #aa0828").trigger("change");
				$("#" + $(this).attr('id') + "-status").val('error');
			}
			status.push($("#" + $(this).attr('id') + "-status").val());					
		});
				
		if($.inArray("error", status) === -1)
		{
			// If no error is found
			$("#" + $(this).attr('id')).css("border", "1px solid #ccc").trigger("change");							
			$.ajax({
				url: 'http://localhost/budgcal/login/edit_user_ajax',
				data: $("#addnusr").serialize(),
				type: "POST",
				beforeSend: function(){
					//$('#eml-load').append('<img src="http://localhost/budgcal/assets/images/loading_30x30.gif" alt="loader">');
				}, 
				complete: function() {
					//$('#eml-load').hide();
				},
				success: function(data) {
					if(data > 0)
					{
						bootbox.alert({
							message: "New user successfully created",
							backdrop: true,
							callback: function () {
						       location.reload();
							}							
						});			
					}
					else
					{
						bootbox.alert({
							message: "Seems like there was a problem. Please try again later.",
							backdrop: true
						});			
					}
				},
				error: function(data) {
					bootbox.alert({
						message: "Seems like there was a problem. Please try again later.",
						backdrop: true
					});			
				}
			});			
		}
		else
		{
			$("#" + $(this).attr('id')).css("border", "1px solid #aa0828").trigger("change");							
			return false;
		}
	});
	// Add new user routine - Ends here
		
	// Edit user info routine - Starts here
	$("#ed-usr-info-btn").on("click", function(e) {
		e.preventDefault();
		var status = [];		
		
		$("#edusr input[type=text]").each(function() {
			var edval = $("#" + $(this).attr('id')).val();
			
			if(edval === '')
			{
				//$("#" + $(this).attr('id') + "-error").empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Required field</span>');							
				$("#" + $(this).attr('id') + "-error").empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="alert alert-danger">Required field</span>');							
				$("#" + $(this).attr('id') + "-status").val('error');
				$("#" + $(this).attr('id')).css("border", "1px solid #aa0828").trigger("change");				
			}
			status.push($("#" + $(this).attr('id') + "-status").val());				
		});

		if($.inArray("error", status) !== -1)
		{
			$("#" + $(this).attr('id')).css("border", "1px solid #aa0828").trigger("change");						
			return false;
		}
		else
		{
			$("#" + $(this).attr('id')).css("border", "1px solid #ccc").trigger("change");						
			$.ajax({
				url: 'http://localhost/budgcal/login/edit_user_ajax',
				data: $("#edusr").serialize(),
				type: "POST",
				beforeSend: function(){
					//$('#eml-load').append('<img src="http://localhost/budgcal/assets/images/loading_30x30.gif" alt="loader">');
				}, 
				complete: function() {
					//$('#eml-load').hide();
				},
				success: function(data) {
					if(data != 'exist')
					{
						bootbox.alert({
							message: "User info changes recorded successfully",
							backdrop: true,
							callback: function () {
						       location.reload();
							}							
						});			
					}
					else
					{
						bootbox.alert({
							message: "No new information detected. Database record remains unchanged.",
							backdrop: true
						});			
					}
				},
				error: function(data) {
					;
				}
			});
		}
	});
	// Edit user info routine - Ends here

	// Edit user reset button routine - Starts here
	$("#ed-usr-rst-btn, #add-new-rst-btn, #ed-chpwd-rst-btn, #add-cat-rst-btn").on("click", function(e) {
		e.preventDefault();
		$("#edusr input[type=text], #edchpwd input[type=password], #addnusr input[type=text], #addnusr input[type=password], #category-add input[type=text]").each(function() {
			console.log($(this).attr("id"));
			$(this).val('');
			$("#" + $(this).attr('id') + "-error").empty();
			$("#" + $(this).attr('id')).css("border", "1px solid #ccc").trigger("change");							
		});
	});
	// Edit user reset button routine - Ends here	
	
	// Password change routine - Starts here		
	$('#ed-usr-chpwd-btn').on("click", function(e) {
		e.preventDefault();
		var status = [];		
		var pass = '';
				
		$("#edchpwd input[type=password]").each(function() {
			pass = $("#" + $(this).attr('id')).val();
			
			if(pass === '')
			{
				$("#" + $(this).attr('id') + "-error").empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Required field</span>');							
				$("#" + $(this).attr('id') + "-status").val('error');
				$(this).css("border", "1px solid #aa0828").trigger("change");
			}
			status.push($("#" + $(this).attr('id') + "-status").val());							
		});

		if($.inArray("error", status) !== -1)
		{
			$("#" + $(this).attr('id')).css("border", "1px solid #aa0828").trigger("change");											
			return false;			
		}
		else
		{
			$("#" + $(this).attr('id')).css("border", "1px solid #ccc").trigger("change");											
			$.ajax({
				url: 'http://localhost/budgcal/login/change_pass_ajax',
				data: $("#edchpwd").serialize(),
				type: "POST",
				beforeSend: function(){
					//$('#eml-load').append('<img src="http://localhost/budgcal/assets/images/loading_30x30.gif" alt="loader">');
				}, 
				complete: function() {
					//$('#eml-load').hide();
				},
				success: function(data) {
					if(data == true)
					{
						bootbox.alert({
							message: "Password has been successfully updated",
							backdrop: true,
							callback: function () {
						       location.reload();
							}																					
						});			
					}
					else
					{
						bootbox.alert({
							message: "There was an error. Please try again later!",
							backdrop: true
						});			
					}
				},
				error: function(data) {
					;
				}
			});						
		}
	});
// Change password routine - Ends here

/* Adding / Editing of category - begins here */	

	// Edit category block display routine
	$('#edit-cat').on("click", function(e) {
		e.preventDefault();
		$('#add-usr-blk').hide();	
		$('#ed-cat-blk').toggle('slow');
		$('#add-cat-item-blk').hide();
	});

	// Add category block display routine
	$('#add-cat-item').on("click", function(e) {
		e.preventDefault();
		$('#add-usr-blk').hide();	
		$('#ed-cat-blk').hide();
		$('#add-cat-item-blk').toggle('slow');
	});
	
	$('#add-cat-btn').on("click", function(e) {
		e.preventDefault();
		var cat = $("#a-c-name").val();
		if(cat === '')
		{
			bootbox.alert({
				message: "Please enter a value",
				backdrop: true
			});
			$("#a-c-name-status").val('error');
			$("#a-c-name").css("border", "1px solid #aa0828");
		}
		else
		{
			$("#a-c-name").css("border", "1px solid #ccc");			
		}

		var status = $("#a-c-name-status").val();							

		console.log(status)				
		if(status === '')
		{
			$.ajax({
				url: 'http://localhost/budgcal/login/add_cat_ajax',
				data: $("#category-add").serialize(),
				type: "POST",
				success: function(data) {
					console.log(data);
					if(data)
					{
						bootbox.alert({
							message: "New category successfully created",
							backdrop: true,
							callback: function () {
							   location.reload();
							}																					
						});			
					}
					else
					{
						bootbox.alert({
							message: "There was a problem. Please try again later!",
							backdrop: true
						});			
					}
				},
				error: function(data) {
					;
				}
			});						
		}
		else
		{
			;	
		}
	});

	// Edit selected category routine - Starts here
	$('#edcat-blk-btn').on("click", function(e) {		
		e.preventDefault();	
		// Reset all error messages		
		$("#edcat-blk-win input[type=text]").each(function() {
			$("#" + $(this).attr("id") + "-error").empty();
		});
		
		var sel = $('select#ed-sel-cat option:selected').text();
		var sval = $("#ed-sel-cat").val();
		
		if(sel != 'Select')
		{
			$('#e-category').val(sel);
			$('#edcat-blk-win').show('slow');												
		}
		else
		{
			bootbox.alert({
				message: "Please choose one of the options",
				backdrop: true
			});			
			$('#edcat-blk-win').hide();
		}
	});
	
	$("#ed-cat-btn").on("click", function() {
		
		var ecat = $("#e-category").val();
		$.ajax({
			url: 'http://localhost/budgcal/login/get_cat_ajax',
			data: {"ecat":ecat, "cat": "edit"},
			dataType: "json",	
			type: "POST",
			success: function(data) {					
				if(data)
				{
					$('#e-category').val(data.category_name);
					$('#edcat-blk-win').toggle('slow');												
				}
				else
				{
					bootbox.alert({
						message: "No new information detected. Database record remains unchanged.",
						backdrop: true
					});								
				}
			},
			error: function(data) {
				;
			}
		});				
	})
	// Edit selected category routine - Ends here
	
/* Adding / Editing of category - ends here */
	
	// User logout processing
	$('#logoutb').on("click", function(e) {
		e.preventDefault();
		var location = $('#lout').attr('href');

		bootbox.confirm("Are you sure you want to logout?", 
			function(result){ 
				if(result)
				{
					console.log('This was logged in the callback: ' + result);
					window.location.replace(location);
				}
			});		
		});

	// Switching to admin dashboard mode
	$('#dboard-btn').on("click", function(e) {
		e.preventDefault();
		var location = $('#dboard').attr('href');

		bootbox.confirm("Are you sure you want to switch to admin mode?", 
			function(result){ 
				if(result)
				{
					console.log('This was logged in the callback: ' + result);
					window.location.replace(location);
				}
			});		
		});
		

/* Form input validation for adding a new user on the admin side - Starts here */

	$('#addnusr input').each(function() {
		$(this).empty();
	});
	
	$('input[type=text], input[type=password]').blur(function() {
		var element_val = $(this).val();
		var element_id = "#" + $(this).attr('id');
		var error_id = "#" + $(this).attr('id') + "-error";
		var status_id = "#" + $(this).attr('id') + "-status";
		
		if(!element_val)
		{
			$(this).css("border", "1px solid #aa0828").trigger("change");
			$(this).effect('shake', {times: 3}, "slow");
			$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Required field</span>');			
//				$("#" + $(this).attr('id') + "-error").empty().html('<span class="alert alert-danger text-small"><i class="fa fa-times"></i>&nbsp;This is a required field</span>');							
			$(status_id).val("error");
		}
		else
		{
			if((element_id == "#fname") || (element_id == "#lname") || (element_id == "#e-fname") || (element_id == "#e-lname"))
			{
				$(error_id).empty().html("<i class='fa fa-check-circle fa-lg text-success'></i>");
				$(this).css("border", "1px solid #ccc").trigger("change");
				$(status_id).val("success");			}
				
			else if((element_id == "#eml") || (element_id == "#e-eml"))
			{	
				switch(element_id) {
					case "#eml":
						if(validate("email", element_val))
						{
							$.ajax({
								url: 'http://localhost/budgcal/login/user_exist_ajax',
								data: {"eml":element_val, "email": "add"},	
								type: "POST",
								beforeSend: function(){
									$('#eml-load').append('<img src="http://localhost/budgcal/assets/images/loading_30x30.gif" alt="loader">');
								}, 
								complete: function() {
									$('#eml-load').hide();
								},
								success: function(data) {
									console.log(data);
									if(data == 1)
									{
										$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">This email address is already registered</span>');
										$(element_id).css("border", "1px solid #aa0828").trigger("change");
										$(status_id).val("error");	
									}
									else
									{
										$(error_id).empty().html("<i class='fa fa-check-circle fa-lg text-success'></i>");	
										$(status_id).val("success");
										$(element_id).css("border", "1px solid #ccc").trigger("change");
									}
								},
								error: function(data) {
									;
								}
							});			
						}
						else
						{
							$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Invalid email address</span>');
							$(status_id).val("error");
							$(element_id).css("border", "1px solid #aa0828").trigger("change");
						}
						break;
					case "#e-eml":
						if(validate("email", element_val))
						{
							var usr_id = $("#ed-usr-id").val()
							$.ajax({
								url: 'http://localhost/budgcal/login/user_exist_ajax',
								data: {"eml":element_val, "usr_id": usr_id, "email": "edit"},	
								type: "POST",
								beforeSend: function(){
									$('#eml-load').append('<img src="http://localhost/budgcal/assets/images/loading_30x30.gif" alt="loader">');
								}, 
								complete: function() {
									$('#eml-load').hide();
								},
								success: function(data) {
									console.log(data);
									if(data == "exist")
									{
										$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">This email address is already registered</span>');
										$(status_id).val("error");
										$(element_id).css("border", "1px solid #aa0828").trigger("change");
									}
									else
									{
										$(error_id).empty().html("<i class='fa fa-check-circle fa-lg text-success'></i>");	
										$(status_id).val("success");
										$(element_id).css("border", "1px solid #ccc").trigger("change");
									}
								},
								error: function(data) {
									;
								}
							});			
						}
						else
						{
							$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Invalid email address</span>');
							$(status_id).val("error");
							$(element_id).css("border", "1px solid #aa0828").trigger("change");
						}					
						break;	
				}
			} 
			else if(element_id == "#uname") 
			{
				if(element_val.length >= 6)
				{
					$.ajax({
						url: 'http://localhost/budgcal/login/user_exist_ajax',
						data: {"un":element_val, "username": "username"},	
						type: "POST",
						beforeSend: function(){
							$('#unl').append('<img src="http://localhost/budgcal/assets/images/loading_30x30.gif" alt="loader">');
						}, 
						complete: function() {
							$('#unl').hide();
						},				
						success: function(data) {
							if(data == 1)
							{
								$('#unl').hide();
								$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">This username is taken</span>');
								$(element_id).css("border", "1px solid #aa0828").trigger("change");
								$(status_id).val("error");								
							}
							else
							{
								$(error_id).empty().html("<i class='fa fa-check-circle fa-lg text-success'></i>");	
								$(status_id).val("success");
								$(element_id).css("border", "1px solid #ccc").trigger("change");
							}
						},
						error: function(data) {
							;
						}
					});			
				}
				else
				{
					$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Minimum 6 characters long</span>');						
					$(status_id).val("error");					
					$(element_id).css("border", "1px solid #ccc").trigger("change");
				}					
			} 
			else if(element_id == "#e-opwd") 
			{
				var uid = $("#usr-pw-id").val();
				$.ajax({
					url: 'http://localhost/budgcal/login/user_exist_ajax',
					data: {"pw":element_val, "uid": uid, "password": "password"},	
					type: "POST",
					beforeSend: function(){
						//$('#unl').append('<img src="http://localhost/budgcal/assets/images/loading_30x30.gif" alt="loader">');
					}, 
					complete: function() {
						//$('#unl').hide();
					},				
					success: function(data) {
						if(data != 1)
						{
							//$('#unl').hide();
							$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Wrong Password</span>');
							$(status_id).val("error");			
							$(element_id).css("border", "1px solid #aa0828").trigger("change");				
						}
						else
						{
							$(error_id).empty().html("<i class='fa fa-check-circle fa-lg text-success'></i>");	
							$(status_id).val("success");
							$(element_id).css("border", "1px solid #ccc").trigger("change");
						}
					},
					error: function(data) {
						;
					}
				});							
			}
			else if((element_id == "#pass") || (element_id == "#e-npwd")) 
			{
					if(!validate("password", element_val))
					{
						$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Password criteria not met</span>');												
						$(status_id).val("error");
						$(element_id).css("border", "1px solid #aa0828").trigger("change");
					}
					else
					{
						if(element_id == "#e-npwd")
						{
							var pass = $("#e-opwd").val();				

							if(element_val == pass)
							{
								$(status_id).val("error");
								$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">New and old password cannot be same</span>');						
								$(element_id).css("border", "1px solid #aa0828").trigger("change");
							}
							else
							{
								$(status_id).val("success");
								$(error_id).empty().html("<i class='fa fa-check-circle fa-lg text-success'></i>");	
								$(element_id).css("border", "1px solid #ccc").trigger("change");
							}
						}
						else
						{
							$(status_id).val("success")
							$(error_id).empty().html("<i class='fa fa-check-circle fa-lg text-success'></i>");
							$(element_id).css("border", "1px solid #ccc").trigger("change");
						}
					}				
			} 
			else if((element_id == "#cpass") || (element_id == "#e-cpwd")) 
			{
				switch(element_id)
				{
					case "#cpass":		
						var pass = $("#pass").val();
						if(element_val == pass)
						{
							$(status_id).val("success")
							$(error_id).empty().html("<i class='fa fa-check-circle fa-lg text-success'></i>");						
							$(element_id).css("border", "1px solid #ccc").trigger("change");
						}
						else
						{
							$(status_id).val("error");
							$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Passwords do not match</span>');						
							$(element_id).css("border", "1px solid #aa0828").trigger("change");
						}
						break;
					case "#e-cpwd":		
						var pass = $("#e-npwd").val();
						if(element_val == pass)
						{
							$(status_id).val("success")
							$(error_id).empty().html("<i class='fa fa-check-circle fa-lg text-success'></i>");						
							$(element_id).css("border", "1px solid #ccc").trigger("change");
						}
						else
						{
							$(status_id).val("error");
							$(error_id).empty().html('<i class="fa fa-times-circle fa-lg text-danger"></i>&nbsp;&nbsp;<span class="rednbold">Passwords do not match</span>');						
							$(element_id).css("border", "1px solid #aa0828").trigger("change");
						}
						break;						
				}
			}
		}	
	});
		
/* Form input validation for adding new user - Ends here */

	$('#lbtn').on("click", function(e) {
			e.preventDefault();
			var frm = $("#login");
			var uname = $("#username").val();
			var pwd = $("#password").val();
		
			if(!uname && !pwd)
			{
				console.log("missing fields");
				bootbox.alert("All fields are mandatory!");	
			}
			else
			{
				if(!uname)
				{
					console.log("missing username");					
					bootbox.alert("Username field cannot be empty!");
				}
				else
				{
					if(uname.length < 6)
					{
						console.log("username minimum character requirement not met");
						bootbox.alert("Username needs to be atleast 6 characters long!");	
					}
					else
					{
						if(!pwd)
						{
							console.log("missing password");
							bootbox.alert("Password field cannot be empty!");
						}
						else
						{
							console.log("Form submitted<br>");
							$.ajax({
								url: 'http://localhost/budgcal/login/verifyajax',
								data: {"un":uname, "pwd":pwd},	
								type: "POST",
								beforeSend: function(){
									;//$('#loader').show();
								}, 
								complete: function(){
									;//$('#loader').modal('hide');
								},
								success: function(data) {
									console.log(data);
									//$('#loader').modal('hide');
									switch(data)
									{
										case 'active':		
											frm.submit();
											break;
										case 'blocked':
											bootbox.alert("This account is no longer active!");
											break;
										case 'missing':
											bootbox.alert("Incorrect login or user does not exist!");
											break;	
										default:
											bootbox.alert("Try again later!");
											break;													
									}
								},
								error: function(data) {
									;
								}
							});
						}
					}
				}
			}
	}); 
	
});

function validate(prop, val) {
	switch(prop) {
		case "email":		 
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(val);
			break;
		case "password":
			var pw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z@#_-]{8,}$/;
			return pw.test(val);			
			break;
	}
}

function frmValidate(event) {
	event.preventDefault();
	var uname = $("#username").val();
	var pwd = $("#password").val();
	
	if(!uname && !pwd)
	{
		alert("All fields are mandatory!");	
	}
	else
	{
		if(!uname)
		{
			alert("Username field cannot be empty!")
		}
		else
		{
			if(uname.length < 6)
			{
				alert("Username needs to be atleast 6 characters long!");	
			}
			else
			{
				if(!pwd)
				{
					alert("Password field cannot be empty!")
				}
				else
				{
					$("#login").submit();
				}
			}
		}
		
	}
}