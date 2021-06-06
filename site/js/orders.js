const baseUrl = "http://localhost/wms/api/";
const columnNames = [{
    key: 'invoiceNumber',
    value: 'Invoice Number'
},{
    key: 'productId',
    value: 'Product Id'
},{
    key: 'productName',
    value: 'Product Name'
},{
    key: 'quantity',
    value: 'Quantity'
},{
    key: 'invoiceDate',
    value: 'Invoice Date'
},{
    key: 'unitPrice',
    value: 'Unit Price'
},{
    key: 'customerId',
    value: 'Customer Id'
},{
    key: 'country',
    value: 'Country'
}];

let filters = { }; 
let resultOrder = [];
const getOrdersData = (page) => {
    let endpoint = baseUrl + 'orders/getOrderList.php?';
    let params = {
        offset: (page-1) * 10,
        limit: 10  
    };
    Object.keys(params).forEach((key) => {
        endpoint += (key + '=' + params[key] + '&');
    });
    console.log(filters);
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
            $("#current-page").html(page);
            $("#total-page").html(Math.ceil(data.total/10));
            $("#table-details").html(makeTable(columnNames, data.data));
            $("#table-div").removeClass('hide');
            resultOrder = data.data;
        }
    });
};

$(document).ready(function(){
    getOrdersData(1);
    $("#search-button").click(function(){
        filters = {};
        $('.filter-input-area').find('.filter-input').each((index, inputText) => {
            if(inputText.value){
                filters[inputText.name] = inputText.value;
            }
        });
        getOrdersData(1);
    });
    $("#reset-button").click(function(){
        filters = {};
        getOrdersData(1);
    });
    $("#clear-filter").click(function(){
        filters = {};
        getOrdersData(1);
    });
    $("#previous-page-button").click(function(){
        let currentPage = parseInt($("#current-page").html());
        if(currentPage == 1) {
            return;
        }
        getOrdersData(currentPage-1);
    });
    $("#next-page-button").click(function(){
        let currentPage = parseInt($("#current-page").html());
        let totalPage = parseInt($("#total-page").html());
        if(currentPage == totalPage) {
            return;
        }
        getOrdersData(currentPage+1);
    });
    $("#export-button").click(function(){
        exportCsv(resultOrder, 'orderData');
    });
});