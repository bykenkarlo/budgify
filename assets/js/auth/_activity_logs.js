if(_state == 'activity_logs'){
	search = $("#_search").val();
	getActivityLogs(1,search);
}
$('#_log_pagination').on('click','a',function(e){
    e.preventDefault(); 
	search = $("#_search").val();
    page_no = $(this).attr('data-ci-pagination-page');
    getActivityLogs(page_no, search);
});
$('#_sort_by_date').on('click',function(){
	search = $("#_search").val();
    page_no = $(this).attr('data-ci-pagination-page');
    getActivityLogs(page_no, search);
});
$("#_search_form").on('submit', function(e){
	e.preventDefault();
	search = $("#_search").val();
	getActivityLogs(1, search)
})
function refreshActivityLogs(){
    $("#_search").val('');
    getActivityLogs(1, '');
}
function getActivityLogs(page_no, search){
    $("#_logs_tbl").html("<tr class='text-center'><td colspan='5'>Loading data...</td></tr>");
    _select_date = $('#_select_date').val();
	from = _select_date.substring(0, 10);
	to = _select_date.substring(_select_date.length, 13);

    let params = new URLSearchParams({'page_no':page_no, 'from':from, 'to':to, 'search':search});
    fetch(base_url+'api/v1/report/_activity_logs?'+params , {
        method: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        displayLogs(page_no, res.data.result, res.data.pagination, res.data.count )
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
function displayLogs(page_no, result, pagination, count){
    string = "";

    $('#_log_pagination').html(pagination);
	$('#_log_count').text('Total count: '+count);
	if (result.length > 0) {
		for(var i = 0; i < result.length; i++){
			string +='<tr>'
				+'<td>'+result[i].user+'</td>'
				+'<td>'+result[i].message_log+'</td>'
				+'<td>'+result[i].browser+'</td>'
				+'<td>'+result[i].platform+'</td>'
				+'<td>'+result[i].created_at+'</td>'
			+'</tr>'
		}
		$('#_logs_tbl').html(string);
	}
	else{
		$("#_logs_tbl").html("<tr class='text-center'><td colspan='5'>No records found!</td></tr>");
	}
}