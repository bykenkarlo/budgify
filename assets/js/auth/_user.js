if(_state == 'dashboard'){
	getAccounts();
	// getCashflowList(1, '', account_id);
	// cashflowStatistics('30_days', account_id);
}
function getAccountData(acct_id){
	$("#account_list .account-btn").removeClass('active')
	$('#account_'+acct_id).addClass('active');
	getCashflowList(1, '', acct_id);
	cashflowStatistics('30_days', acct_id);
}
$(document).on("input", "#amount", function() {
    var $this = $(this);
    $this.val($this.val().replace(/[^\d.]/g, ''));    
});
$(document).on("input", "#account_amount", function() {
    var $this = $(this);
    $this.val($this.val().replace(/[^\d.]/g, ''));    
});
function addAccount(){
	newAccount();
}
function newAccount(){
	getAccountType();
    $('#add_account_modal').modal('toggle');
}
function addCashflow(){
	getCategory();
	getAccountsList();
    $('#_new_record_modal').modal('toggle');
}
$("#close_create_acct_btn").on('click', function(){
    $('#add_account_modal').modal('hide')
})

$("#close_cashflow_btn").on('click', function(){
    $('#_new_record_modal').modal('hide')
})
$("#close_cashflow_btn2").on('click', function(){
    $('#edit_record_modal').modal('hide')
})
$('#cf_pagination').on('click','a',function(e){
    e.preventDefault(); 
	search = $("#_search_surgery").val();
    page_no = $(this).attr('data-ci-pagination-page');
    getCashflowList(page_no, '', account_id);
});
function getCashflowList(page_no, search, acct_id){
	$("#cash_flow_tbl").html("<tr class='text-center'><td colspan='5'>Getting records...</td></tr>");
	let params = new URLSearchParams({'page_no':page_no, 'search':search, 'account_id':acct_id});
	fetch(base_url+'api/v1/user/_get_cashflow?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		displayDataList(page_no, res.data.result, res.data.pagination, res.data.count);
	})
	.catch((error) => {
		$("#cash_flow_tbl").html("<tr class='text-center'><td colspan='3'>No record found!</td></tr>");
		console.error('Error:', error);
	});
}
function displayDataList(page_no, result, pagination, count){
    btn_bg ='';
    p_status ='';
    string ='';
    type ='';
	category_icon = '';
	$('#cf_pagination').html(pagination);
	$('#cf_count').text('Total count: '+count);
	if (result.length > 0) {
		for(var i = 0; i < result.length; i++){
			category = result[i].category;
			let category_data = getCategoryInfo(category);

			if(result[i].type == 'income'){
				type = 'text-success';
			}
			else if(result[i].type == 'expense'){
				type = 'text-danger';
			}
			string +='<tr class="cursor-pointer" onclick="openRecordDetails(\''+result[i].id+'\',\''+page_no+'\')">'
				+'<td width="20"><div class="avatar-sm"><span class="avatar-title '+category_data[1]+' rounded-circle">'+category_data[0]+'</span></div></td>'
				+'<td><span class="fw-700">'+result[i].category+'</span><br><p>'+result[i].description+'</p></td>'
				+'<td><span class="fw-600 '+type+'">'+result[i].currency+result[i].amount+'</span><br><span>'+result[i].date+'</span></td>'
			+'</tr>'
		}
		$('#cash_flow_tbl').html(string);
	}
	else{
		$("#cash_flow_tbl").html("<tr class='text-center'><td colspan='3'>No records found!</td></tr>");
	}
}
function getAccountType(){
    $("#loader").removeAttr('hidden','hidden');
    fetch(base_url+'api/v1/user/_get_account_type', {
        method: "GET",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        string = '<option selected value="1">Cash</option>';
        if (res.data.length > 0) {
            for(var i = 0; i < res.data.length; i++){
                string +='<option value="'+res.data[i].id+'">'+res.data[i].type+'</option>'
            }
            $('.account_type').html(string);
        }
        $("#loader").attr('hidden','hidden');
    })
    .catch((error) => {
        console.error('Error:', error);
        $("#loader").attr('hidden','hidden');
    });
}
function getCategory(){
    $("#loader").removeAttr('hidden','hidden');
    fetch(base_url+'api/v1/user/_get_category', {
        method: "GET",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        string = '<option value="">Select Category</option>';
        if (res.data.length > 0) {
            for(var i = 0; i < res.data.length; i++){
                string +='<option value="'+res.data[i].category_id+'">'+res.data[i].category_name+'</option>'
            }
            $('.category').html(string);
        }
        $("#loader").attr('hidden','hidden');
    })
    .catch((error) => {
        console.error('Error:', error);
        $("#loader").attr('hidden','hidden');
    });
}
$("#add_cashflow_form").on('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);
	$("#save_cashflow_btn").text('Saving...').attr('disabled', 'disabled');
	$("#loader").removeAttr('hidden','hidden');
	e.preventDefault();
	$.ajax({
		url: base_url+'api/v1/user/_new_cashflow_record',
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
		account_id = $("#add_account_select").val()
		if (res.data.status == 'success') {
			Swal.fire({
			  	icon: 'success',
			  	title: 'Success!',
			 	text: res.data.message,
			})
            getCashflowList(1,'', account_id);
			cashflowStatistics('30_days', account_id);
			// getAccounts();

			$("#account_list .account-btn").removeClass('active')
			$('#account_'+account_id).addClass('active');

			$('#add_cashflow_form .cf-input').val('');
			$("#_new_record_modal").modal('hide');
		}
		else{
			Swal.fire({
				icon: 'error',
				title: 'Error!',
			    html: res.data.message,
		  })
		}
		$("#loader").attr('hidden','hidden');
		$("#save_cashflow_btn").removeAttr('disabled', 'disabled').text('Save Details');
		_csrfNonce();
	})
	.fail(function(){
		$("#save_cashflow_btn").removeAttr('disabled', 'disabled').text('Save Details');
		Swal.fire({
			icon: 'error',
			title: 'Error!',
			html: "Something went wrong. Try again!",
		})
		$("#loader").attr('hidden','hidden');
		_csrfNonce();
	})
})
function cashflowStatistics(range, acct_id){
	let params = new URLSearchParams({'range':range,'account_id':acct_id});
	fetch(base_url+'api/v1/user/_get_cashflow_statistics?'+params,{
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		expenseStatChart(res.data.expense_stat)
		$("#balance").text(res.data.currency+res.data.balance)
		$("#expense").text(res.data.currency+res.data.expense)
		$("#savings").text(res.data.currency+res.data.savings)
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
function getCategoryInfo(category){
	icon = '';
	color = '';
	if(category == 'Vehicle'){
		icon = '<i class="uil-car-sideview font-24"></i>';
		color = 'bg-dark';
	}
	else if(category == 'Other'){
		icon = '<i class="uil-ellipsis-h font-24"></i>';
		color = 'bg-secondary';
	}
	else if(category == 'Transportation'){
		icon = '<i class="uil-bus font-24"></i>';
		color = 'bg-info';
	}
	else if(category == 'Transfer'){
		icon = '<i class="uil-exchange font-24"></i>';
		color = 'bg-success';
	}
	else if(category == 'Expense'){
		icon = '<i class="uil-money-insert font-24"></i>';
		color = 'bg-danger';
	}
	else if(category == 'Shopping'){
		icon = '<i class="uil-shopping-bag font-24"></i>';
		color = 'bg-warning';
	}
	else if(category == 'Food & Drinks'){
		icon = '<i class="uil-utensils-alt font-24"></i>';
		color = 'bg-primary';
	}
	else if(category == 'Housing'){
		icon = '<i class="uil-building font-24"></i>';
		color = 'bg-info';
	}
	else if(category == 'Life & Entertainment'){
		icon = '<i class="uil-book-reader font-24"></i>';
		color = 'bg-success';
	}
	else if(category == 'Investments'){
		icon = '<i class="uil-coins font-24"></i>';
		color = 'bg-primary';
	}
	else if(category == 'Communication, PC'){
		icon = '<i class="uil-tv-retro font-24"></i>';
		color = 'bg-danger';
	}
	else if(category == 'Salary'){
		icon = '<i class="uil-usd-circle font-24"></i>';
		color = 'bg-success';
	}
	else if(category == 'Utilities'){
		icon = '<i class="uil-wrench font-24"></i>';
		color = 'bg-dark';
	}
	else {
		icon = '<i class="uil-apps font-24"></i>';
		color = 'bg-secondary';
	}
	let data = [icon, color];
	return data;
}
// const expenseStat = (range) => {
// 	let params = new URLSearchParams({'range':range});
// 	fetch(base_url+'api/v1/user/_get_expense_stat?' + params, {
//   		method: "GET",
// 		  	headers: {
// 		    	'Accept': 'application/json',
// 		    	'Content-Type': 'application/json'
// 		  	},
// 	})
// 	.then(response => response.json())
// 	.then(res => {
// 		displayDataList(page_no, res.data.result, res.data.pagination, res.data.count);
// 	})
// 	.catch((error) => {
// 		$("#actual_expense_wrapper").html("<tr class='text-center'><td colspan='3'>Getting records!</td></tr>");
// 		console.error('Error:', error);
// 	});
// }
var expense_chart;
const expenseStatChart = (data) => {
    let amount = [];
    let category_name = [];

    stats = data;
    for(var i in stats){
        amount.push(stats[i].amount);
        category_name.push(stats[i].category_name);
    }

    if (expense_chart) {
        expense_chart.destroy();
    }  
    color = [];
    
    color = [
        'rgb(54, 153, 255)',
        'rgb(250, 92, 124)',
		'rgb(255, 188, 0)',
		'rgb(5, 203, 98)',
		'rgb(108, 117, 125)',
		'rgb(57, 175, 209)',
        'rgb(5, 138, 215)',
        'rgb(28, 215, 156)',
        'rgb(5, 203, 98)',
        'rgb(203, 28, 215)',
        'rgb(215, 28, 151)',
        'rgb(5, 215, 213)',
        'rgb(215, 28, 54)',
        'rgb(54, 153, 255)',
        'rgb(250, 92, 124)',
		'rgb(255, 188, 0)',
		'rgb(5, 203, 98)',
		'rgb(108, 117, 125)',
		'rgb(57, 175, 209)',
        'rgb(5, 138, 215)',
        'rgb(195, 215, 28)',
        'rgb(28, 215, 76)',
        'rgb(89, 215, 28)',
    ];

    for (var i=0;i<category_name.length;i++) {
        color.push(category_name[i].category_name); 
    }
    const ctx = document.getElementById('expense_structure');
    expense_chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: category_name,
            datasets: [{
                label: '',
                data: amount,
                backgroundColor: color,
                borderColor: '#fff',
                hoverOffset: 10
            }],
        },
        options: {
			cutoutPercentage: 30,
            layout: {
                padding: 10
            },
           
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: 'circle'
                    }

                }
            },
        }
    });
    $("#loader").attr('hidden','hidden');
}
function openRecordDetails(id, page_no){
	$("#loader").removeAttr('hidden','hidden');
	let params = new URLSearchParams({'id':id, 'page_no':page_no});
	fetch(base_url+'api/v1/user/_get_cashflow_details?' + params, {
  		method: "GET",
		  	headers: {
		    	'Accept': 'application/json',
		    	'Content-Type': 'application/json'
		  	},
	})
	.then(response => response.json())
	.then(res => {
		getAccountsListEdit(res.data.account_id, res.data.account_name);

		$("#edit_id").val(res.data.id);
		$("#edit_type").val(res.data.type);
		$("#edit_date").val(res.data.date);
		$("#edit_amount2").val(res.data.amount);
		$("#edit_amount").val(res.data.amount);
		$("#edit_description").val(res.data.description);
		getCategoryEdit(res.data.category_id, res.data.category_name);
		$("#edit_record_modal").modal('toggle');
		$("#loader").attr('hidden','hidden');
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
function getCategoryEdit(category_id, category_name){
    $("#loader").removeAttr('hidden','hidden');
    fetch(base_url+'api/v1/user/_get_category', {
        method: "GET",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
		string = '<option value="'+category_id+'" selected >'+category_name+'</option>';
        if (res.data.length > 0) {
            for(var i = 0; i < res.data.length; i++){
                string +='<option value="'+res.data[i].category_id+'">'+res.data[i].category_name+'</option>'
            }
            $('.category').html(string);
        }
        $("#loader").attr('hidden','hidden');
    })
    .catch((error) => {
        console.error('Error:', error);
        $("#loader").attr('hidden','hidden');
    });
}
$("#update_cashflow_form").on('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);
	$("#save_cashflow_btn").text('Saving...').attr('disabled', 'disabled');
	$("#loader").removeAttr('hidden','hidden');
	e.preventDefault();
	$.ajax({
		url: base_url+'api/v1/user/_update_cashflow_record',
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
            getAccounts();
			$('#update_cashflow_form input').val('');
			$("#edit_record_modal").modal('hide');
		}
		else{
			Swal.fire({
				icon: 'error',
				title: 'Error!',
			    html: res.data.message,
		  })
		}
		$("#loader").attr('hidden','hidden');
		$("#save_cashflow_btn").removeAttr('disabled', 'disabled').text('Save Details');
		_csrfNonce();
	})
	.fail(function(){
		$("#save_cashflow_btn").removeAttr('disabled', 'disabled').text('Save Details');
		Swal.fire({
			icon: 'error',
			title: 'Error!',
			html: "Something went wrong. Try again!",
		})
		$("#loader").attr('hidden','hidden');
		_csrfNonce();
	})
})

$("#add_account_form").on('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);
	$("#create_account_btn").text('Creating..').attr('disabled', 'disabled');
	$("#loader").removeAttr('hidden','hidden');
	e.preventDefault();
	$.ajax({
		url: base_url+'api/v1/user/_new_account',
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
			getAccounts();
			$('#add_account_form input').val('');
			$("#add_account_modal").modal('hide');
		}
		else{
			Swal.fire({
				icon: 'error',
				title: 'Error!',
			    html: res.data.message,
		  })
		}
		$("#create_account_btn").removeAttr('disabled', 'disabled').text('Create');
		$("#loader").attr('hidden','hidden');
	})
	.fail(function(){
		$("#create_account_btn").removeAttr('disabled', 'disabled').text('Create');
		Swal.fire({
			icon: 'error',
			title: 'Error!',
			html: "Something went wrong. Try again!",
		})
		$("#loader").attr('hidden','hidden');
		_csrfNonce();
	})
})
function getAccounts(){
	$("#loader").removeAttr('hidden','hidden');
	string2 = '';
	string3 = '';
	add_btn_count = 1;
	fetch(base_url+'api/v1/user/_get_accounts', {
		method: "GET",
			headers: {
			  'Accept': 'application/json',
			  'Content-Type': 'application/json'
			},
	})
	.then(response => response.json())
	.then(res => {

		add_btn_count = res.data.length + 1;
		
		for(var i = 0; i < res.data.length; i++){
			string2 +='<div class="p-2 accounts-div">'
					+'<div class="account-btn" id="account_'+res.data[i].account_id+'" onclick="getAccountData(\''+res.data[i].account_id+'\')">'
						+'<h5 class="padding-top-5 fw-normal mt-0">'+res.data[i].name+'</h5>'
					+'</div>'
				+'</div>';
		}
		
		string3 +='<div class="p-2 accounts-div">'
				+'<div class="btn btn-outline-primary br-10 add-account" onclick="addAccount()">'
					+'<h5 class="padding-top-5 fw-normal mt-0"><i class="uil uil-plus-circle"></i> Add Account</h5>'
				+'</div>'
			+'</div>';
		
		$('#account_list').html(string2);
		$('#account_list').append(string3);

		if(res.data.length > 0){
			if(res.data[0].account_id){
				getCashflowList(1, '', res.data[0].account_id);
				cashflowStatistics('30_days', res.data[0].account_id);
			}
			$('#account_'+res.data[0].account_id+'').addClass('active');
		}
		if(res.data.length == 1){
			$('.add-cashflow').removeAttr('onclick','newAccount()').attr('onclick','addCashflow()').html('<i class="uil uil-plus"></i>');
		}

		$("#loader").attr('hidden','hidden');
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
function getAccountsList(){
	string2 = '';
	fetch(base_url+'api/v1/user/_get_accounts_list', {
		method: "GET",
			headers: {
			  'Accept': 'application/json',
			  'Content-Type': 'application/json'
			},
	})
	.then(response => response.json())
	.then(res => {
		// string = '<option>Choose</option>';
		string2 = '';
		if (res.data.length > 0) {
            for(var i = 0; i < res.data.length; i++){
                string2 +='<option value="'+res.data[i].account_id+'">'+res.data[i].name+'</option>'
            }
            $('.add-account-select').html(string2);
        }
	})
	.catch((error) => {
		console.error('Error:', error);
	});
}
function getAccountsListEdit(account_id, wallet_name){
	string2 +='<option value="'+account_id+'">'+wallet_name+'</option>'
	$('.add-account-select').html(string2);

}
function comfirmRemoveCashflow(){ //delete article
	id = $("#edit_id").val();
	console.log(id)
	Swal.fire({
		title: 'Are you sure?',
		icon: 'warning',
		text: 'This will remove the item on the list!',
		showCancelButton: true,
		confirmButtonText: 'Yes, proceed!',
	}).then((result) => {
		if (result.isConfirmed) {
			$("#loader").removeAttr('hidden','hidden');
			$.ajax({
			url: base_url+'api/v1/user/_remove_cashflow_data',
			type: 'POST',
			dataType: 'JSON',
			data: {id:id},
			statusCode: {
			403: function() {
					_error403();
				}
			}
		})
		.done(function(res) {
			if (res.data.status == 'success') {
				Swal.fire('Success!', res.data.message, 'success');
				getAccounts();
				$("#edit_record_modal").modal('hide')
			}
			else{
				Swal.fire('Error!', 'Something went wrong! Please Try again!', 'error');
			}
			$("#loader").attr('hidden','hidden');
		})
		} 
	})
}