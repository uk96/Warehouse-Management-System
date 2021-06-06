const baseUrl = "http://localhost/wms/api/";
const columnNames = [{
    key: 'productId',
    value: 'Product Id'
},{
    key: 'productName',
    value: 'Product Name'
},{
    key: 'quantity',
    value: 'Quantity'
},{
    key: 'expiryDate',
    value: 'Expiry Date'
},{
    key: 'rackNumber',
    value: 'Rack Number'
}];

let filters = { }; 
let resultExpiredProduct = [];
const getExpiredProductData = (page) => {
    let endpoint = baseUrl + 'product/expiredProductList.php?';
    Object.keys(filters).forEach((key) => {
        endpoint += (key + '=' + filters[key] + '&');
    });
    $.ajax({
        url: endpoint,
    }).done(function(data) {
        console.log(data);
        if(data.message) {
            $("#table-count").html('0');
            $("#table-div").addClass('hide');
        } else {
            $("#table-count").html(data.total);
            $("#current-page").html(1);
            $("#total-page").html(1);
            $("#table-details").html(makeTable(columnNames, data.data));
            $("#table-div").removeClass('hide');
            resultExpiredProduct = data.data;
        }
    });
};

$(document).ready(function(){
    getExpiredProductData(1);
    $("#search-button").click(function(){
        $("#error-msg").addClass('hide');
        $("#error-msg-greater").addClass('hide');
        filters = {};
        $('.filter-input-area').find('.filter-input').each((index, inputText) => {
            if(inputText.value){
                filters[inputText.name] = inputText.value;
            }
        });
        if((filters['startDate'] && !filters['endDate']) || (!filters['startDate'] && filters['endDate'])) {
            filters = {};
            $("#error-msg").removeClass('hide');
        } else if(filters['startDate'] && filters['startDate'] && (filters['startDate'] > filters['endDate'])) {
            filters = {};
            $("#error-msg-greater").removeClass('hide');
        } else {
            getExpiredProductData(1);
        }
    });
    $("#reset-button").click(function(){
        console.log('mjsd;kcsd')
        $("#error-msg").addClass('hide');
        $("#error-msg-greater").addClass('hide');
        filters = {};
        getExpiredProductData(1);
    });
    $("#clear-filter").click(function(){
        filters = {};
        getExpiredProductData(1);
    });
    $("#export-button").click(function(){
        exportCsv(resultExpiredProduct, 'expiredProductData');
    });
    $("#email-button").click(function(){
        $.ajax({
            method: "POST",
            type:"POST",
            url: baseUrl + 'mail_demo.php',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify({
              address: $("#userEmail").html().trim(),  
              subject: "Expired Product List:-",  
              data: resultExpiredProduct  
            }),
            dataType: "json",
            success: (res) => {
                if(res.status === 400){
                    $(".failure").removeClass('hide');
                } else {
                    $(".success").removeClass('hide');
                }
            },
            failure: () => {$(".failure").removeClass('hide');}
        });
    });
});