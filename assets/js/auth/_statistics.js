function getStatistics(range){

    $("#product_sales").text('₱ 0.00');
    $("#product_stocks").text('0');
    $("#product_orders").text('0');
    $("#net_sales").text('₱ 0.00');
    $("#checked_in").text('0');
    $("#services_offered").text('0');

	let params = new URLSearchParams({'range':range});
    fetch(base_url+'api/v1/statistics/_get_website_stat?'+params, {
        method: "GET",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        $("#product_sales").text(res.data.sales);
        $("#product_stocks").text(res.data.product_stocks);
        $("#product_orders").text(res.data.product_orders);
        $("#net_sales").text(res.data.net_sales);
        $("#checked_in").text(res.data.checked_in);
        $("#services_offered").text(res.data.service_offered);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

if(_state == 'dashboard'){
    range = '7_days';
    getStatistics(range);
    mostSoldProducts('7_days');
    mostSoldService('7_days');
    // productsByQuantity('15_days');
 }
function mostSoldProducts(range){
    $("#prod_filter").text(range.replace('_',' '));
    let params = new URLSearchParams({'range':range});
    fetch(base_url+'api/v1/statistics/_most_sold_products?' + params, {
        method: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        let count = [];
        let percentage = [];
        let product = [];
        let string = "";
        stats = res.data.statistics;
        for(var i in stats){
            count.push(stats[i].count);
            product.push(stats[i].product_name);
            percentage.push(stats[i].percentage);

            string +='<tr>'
                        +'<td>'+stats[i].product_name+'</td>'
                        +'<td>'+stats[i].count+'</td>'
                        +'<td width="180">'
                            +'<div class="progress progress-sm" >'
                                +'<div class="progress-bar bg-primary" role="progressbar" style="width: '+stats[i].percentage+'%" aria-valuenow="'+stats[i].product_name+'" aria-valuemin="0" aria-valuemax="100"></div>'
                            +'</div>'
                        +'</td>'
                    +'<tr>';
        }
        $("#_most_sold_products").html(string);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
function mostSoldService(range){
    $("#service_filter").text(range.replace('_',' '));
    let params = new URLSearchParams({'range':range});
    fetch(base_url+'api/v1/statistics/_most_sold_service?' + params, {
        method: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        let count = [];
        let percentage = [];
        let service = [];
        let string = "";
        stats = res.data.statistics;
        for(var i in stats){
            count.push(stats[i].count);
            service.push(stats[i].service);
            percentage.push(stats[i].percentage);

            string +='<tr>'
                        +'<td>'+stats[i].service+'</td>'
                        +'<td>'+stats[i].count+'</td>'
                        +'<td width="180">'
                            +'<div class="progress progress-sm" >'
                                +'<div class="progress-bar bg-primary" role="progressbar" style="width: '+stats[i].percentage+'%" aria-valuenow="'+stats[i].service+'" aria-valuemin="0" aria-valuemax="100"></div>'
                            +'</div>'
                        +'</td>'
                    +'<tr>';
        }
        $("#_most_sold_service").html(string);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}

function productsByQuantity(range){
    let params = new URLSearchParams({'range':range});
    fetch(base_url+'api/v1/statistics/product_by_qty?' + params, {
        method: "GET",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
    })
    .then(response => response.json())
    .then(res => {
        let count = [];
        let percentage = [];
        let product = [];
        let string = "";
        stats = res.data.statistics;
        for(var i in stats){
            count.push(stats[i].count);
            product.push(stats[i].product_name);
            percentage.push(stats[i].percentage);

            string +='<tr>'
                        +'<td>'+stats[i].product_name+'</td>'
                        +'<td>'+stats[i].count+'</td>'
                        +'<td width="180">'
                            +'<div class="progress progress-sm" >'
                                +'<div class="progress-bar bg-primary" role="progressbar" style="width: '+stats[i].percentage+'%" aria-valuenow="'+stats[i].product_name+'" aria-valuemin="0" aria-valuemax="100"></div>'
                            +'</div>'
                        +'</td>'
                    +'<tr>';
        }
        $("#_products_by_quantity").html(string);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
