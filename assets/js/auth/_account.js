$("#_add_new_user").on('click', function(){
	$("#_add_new_user_modal").modal('toggle');
});
$("#add_new_user_form").on('submit', function(e){
	e.preventDefault();
	let formData = new FormData(this);
	$("#save_user_details").text('Saving...').attr('disabled', 'disabled');
	$("#loader").removeAttr('hidden','hidden');
	e.preventDefault();
	$.ajax({
		url: base_url+'api/v1/user/_new_user',
		type: 'POST',
		data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	    statusCode: {
		403: function() {
				_error403();
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			Swal.fire({
			  	icon: 'success',
			  	title: 'Success!',
			 	text: res.data.message,
			})
			$("#_add_new_user_modal").modal('hide')
			$('#add_new_user_form .form-control').val('');
            _showUsersList(1,'');
		}
		else if(res.data.message.username) {
			Swal.fire({
				icon: 'error',
				title: 'Error!',
			    html: res.data.message.username,
		  })
		}
		else if(res.data.message.email_address) {
			Swal.fire({
				icon: 'error',
				title: 'Error!',
			    html: res.data.message.email_address,
		  })
		}
		else if(res.data.message.mobile_number) {
			Swal.fire({
				icon: 'error',
				title: 'Error!',
			    html: res.data.message.mobile_number,
		  })
		}
		else{
			Swal.fire({
				icon: 'error',
				title: 'Error!',
			    html: res.data.message,
		  })
		}
		$("#loader").attr('hidden','hidden');
		$("#save_user_details").removeAttr('disabled', 'disabled').text('Save Details');
		_csrfNonce();
	})
})
function _showUsersList(page_no, search){
	$("#_user_tbl").html("<tr class='text-center'><td colspan='6'>Loading data...</td></tr>");
	search = $("#_search").val();

	let params = new URLSearchParams({'page_no':page_no, 'search':search});
	fetch(base_url+'api/v1/user/_get_list?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		_displayUsersList(page_no, res.data.result, res.data.pagination, res.data.count);
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}

function _displayUsersList(page_no, result, pagination, count){
	check_stat = '';
	string ='';
	user_type = '';
	user_roles = '';
	$('#_user_pagination').html(pagination);
	if (result.length > 0) {
		for(var i = 0; i < result.length; i++){
			if (result[i].status == 'active') {
				check_stat = 'checked';
			}
			else{
				check_stat = '';
			}
			user_type = result[i].user_type

			if (user_type == 'sys_admin') {
				user_type = 'System Admin';
				user_roles = '';
			}
			else if(user_type == 'admin'){
				user_roles = '';
			}
			else if(user_type == 'staff'){
				user_roles = '<a href="#roles" onclick="_userRoles(\''+result[i].user_id+'\')" class="font-16 text-secondary" ><i class="uil-sliders-v"></i> </a>';
			}

			string +='<tr>'
				+'<td></td>'
				+'<td>'+result[i].name+'</td>'
				+'<td class="text-capitalize">'+user_type+'</td>'
				+'<td>'
	               	+'<input onchange="_activeStatusCheckBox(\''+result[i].user_id+'\')" type="checkbox" id="_checkbox_status_'+result[i].user_id+'" '+check_stat+' data-switch="success"/>'
	               	+'<label for="_checkbox_status_'+result[i].user_id+'" data-on-label="Yes" data-off-label="No" class="mb-0 d-block"></label>'
	            +'</td>'
				+'<td>'+result[i].created_at+'</td>'
				+'<td>'
					+'<a href="#edit" onclick="_editUser(\''+result[i].user_id+'\',\''+page_no+'\')" class="font-16 text-secondary" ><i class="uil-edit"></i> </a>'
					// +'<a href="#edit" onclick="_changePassword(\''+result[i].user_id+'\')" class="font-16 text-secondary" ><i class="uil-key-skeleton"></i> </a>'
					+'<a href="#delete" class="font-16 text-secondary" onclick="_deleteUser(\''+result[i].user_id+'\',\''+page_no+'\')"><i class="uil-trash-alt"></i> </a>'
					+user_roles
				+'</td>'
			+'</tr>'
		}
		$('#_user_tbl').html(string);
	}
	else{
		$("#_user_tbl").html("<tr class='text-center'><td colspan='6'>No records found!</td></tr>");
	}
}
function _activeStatusCheckBox(id){
	csrf_token = $("#_gflobal_csrf").val();
	status = '';
	if (true) {}
	if(!$("#_checkbox_status_"+id).is(':checked') ) {
		status = 'disabled';
    }
    else{
		status = 'active';
    }

    $.ajax({
		url: base_url+'api/v1/user/_update_status',
		type: 'POST',
		dataType: 'JSON',
		data: {status:status,id:id,csrf_token:csrf_token},
        statusCode: {
		403: function() {
			  	_error403();
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'error') {
			Swal.fire({
				icon: 'error',
				title: 'Error!',
				text: res.data.message,
			});
		}
		else{
			
		}
		_csrfNonce();
	})
}
function refreshUsersList(){
    search = $("#_search").val('');
    _showUsersList(1, '');
}
if(_state == 'users_list'){
	_showUsersList(1,'');
}
function _deleteUser(id, page_no){
	csrf_token = $("#_global_csrf").val();
	Swal.fire({
		title: 'Delete?',
	 	icon: 'warning',
	 	text: 'Are you sure to remove this user? This cannot be undone!',
		showCancelButton: true,
		confirmButtonText: 'Yes, proceed!',
	}).then((result) => {
	  	if (result.isConfirmed) {
	  		$.ajax({
				url: base_url+'api/v1/user/_delete_user',
				type: 'POST',
				dataType: 'JSON',
				data: {id:id,csrf_token:csrf_token},
		        statusCode: {
				403: function() {
					  	_error403();
					}
				}
			})
			.done(function(res) {
				if (res.data.status == 'success') {
					Swal.fire('Success!', res.data.message, 'success');
					_showUsersList(page_no);
				}
				else{
					Swal.fire('Error!', res.data.message, 'error');
				}
				_csrfNonce();
			})
	  	} 
	})
}
function _editUser(id){
	let params = new URLSearchParams({'id':id});
	fetch(base_url+'api/v1/user/_get_data?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		// options = '';
		$('#_edit_user_type option[value="'+res.data.user_type+'"]').attr('selected','selected');
		$("#_edit_name").val(res.data.name)
		$("#_edit_username").val(res.data.username)
		$("#_edit_email").val(res.data.email_address)
		$("#_edit_mobile_number").val(res.data.mobile_number)
		$("#_user_id").val(res.data.user_id)
		$("#_edit_user_modal").modal('toggle');
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
$('#_edit_user_form').on('submit', function(e){
	e.preventDefault();
	let formData = new FormData(this);
	
	$("#_submit_user_update_btn").attr('disabled','disabled').text('Updating...');
	$.ajax({
		url: base_url+'api/v1/user/_edit_user',
		type: 'POST',
		data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	    statusCode: {
		403: function() {
			_error403();
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			Swal.fire({
			  	icon: 'success',
			  	title: 'Success!',
			 	text: res.data.message,
			})
			$("#_edit_user_modal").modal('hide');
			$('#_edit_user_modal input').val('');
			_showUsersList(1);
		}
		else{
			
			if (res.data.message.email_address) {
				message =  res.data.message.email_address
			}
			else if( res.data.message.mobile_number){
				message =  res.data.message.mobile_number
			}
			else if( res.data.message.username){
				message =  res.data.message.username
			}
			else {
				message = res.data.message
			}
			Swal.fire({
			  	icon: 'error',
			  	title: 'Error!',
			 	text: message,
			})
		}
		_csrfNonce();
		$("#_submit_user_update_btn").removeAttr('disabled','disabled').text('Update');
	})
})
$("#show_password").on('click', function(){
	$("#change_password_form .form-control").attr('type','text');
	$(this).attr('hidden','hidden');
	$("#hide_password").removeAttr('hidden','hidden');
})
$("#hide_password").on('click', function(){
	$("#change_password_form .form-control").attr('type','password');
	$(this).attr('hidden','hidden');
	$("#show_password").removeAttr('hidden','hidden');
})
$("#change_password_form").on('submit', function(e){
	e.preventDefault();
	$("#update_pass_btn").text('Updating....').attr('disabled','disabled');
	csrf_token = $("#_global_csrf").val();
	let formData = new FormData(this);
	$.ajax({
		url: base_url+'api/v1/user/_change_password',
		type: 'POST',
		data: formData,
		cache       : false,
	    contentType : false,
	    processData : false,
	    statusCode: {
		403: function() {
				_error403();
			}
		}
	})
	.done(function(res) {
		if (res.data.status == 'success') {
			Swal.fire({
			  	icon: 'success',
			  	title: 'Success!',
			 	text: res.data.message,
			})
			$('#change_password_form .form-control').val('');
		}
		else{
			Swal.fire({
				icon: 'error',
				title: 'Error!',
			    html: res.data.message,
		  })
		}
		$("#update_pass_btn").text('Update').removeAttr('disabled','disabled');
		_csrfNonce();
	})
	.fail(function(){
		$("#update_pass_btn").text('Update').removeAttr('disabled','disabled');
	})
})