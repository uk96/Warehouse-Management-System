const baseUrl = "http://localhost/wms/api/";
const columnNames = [{
    key: 'productId',
    value: 'Product Id'
},{
    key: 'productName',
    value: 'ProductName'
},{
    key: 'safetyStock',
    value: 'Safety Stock'
},{
    key: 'leadTime',
    value: 'Lead Time'
},{
    key: 'leadTimeDemand',
    value: 'Lead Time Demand'
},{
    key: 'reorderPoint',
    value: 'Reorder Point'
},{
    key: 'productQuantity',
    value: 'Quantity Available'
},{
    key: 'rackNumber',
    value: 'Rack Number'
}];

let filters = { }; 
let resultReorderProduct = [];
const getReorderProductData = (page) => {
    let endpoint = baseUrl + 'product/getReOrderProduct.php?';
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
            resultReorderProduct = data.data;
        }
    });
};

$(document).ready(function(){
    getReorderProductData(1);
    $("#search-button").click(function(){
        filters = {};
        $('.filter-input-area').find('.filter-input').each((index, inputText) => {
            if(inputText.value){
                filters[inputText.name] = inputText.value;
            }
        });
        getReorderProductData(1);
    });
    $("#reset-button").click(function(){
        filters = {};
        getReorderProductData(1);
    });
    $("#clear-filter").click(function(){
        filters = {};
        getReorderProductData(1);
    });
    $("#export-button").click(function(){
        exportCsv(resultReorderProduct, 'reorderProductData');
    });
    $("#email-button").click(function(){
        $.ajax({
            method: "POST",
            type:"POST",
            url: baseUrl + 'mail_demo.php',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify({
              address: $("#userEmail").html().trim(),  
              subject: "Threshold Product List:-",  
              data: resultReorderProduct  
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
    $("#subscribe-button").click(function(){
        $.ajax({
            method: "POST",
            type:"POST",
            url: baseUrl + 'addMailChain.php',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify({
              userEmail: $("#userEmail").html().trim(),    
            }),
            dataType: "json",
            success: (res) => {
                if(res.status === 400){
                    $(".failure").removeClass('hide');
                    return;
                } else {
                    $(".success1").find(".alert-message").text(res.message);
                    $(".success1").removeClass('hide');
                }
            },
            failure: () => {$(".failure").removeClass('hide');}
        });
    });
});