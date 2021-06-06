const baseUrl = "http://localhost/wms/api/";
const columnNames = [{
    key: 'productId',
    value: 'Product Id'
},{
    key: 'numberOfDays',
    value: 'Sale Days Count'
},{
    key: 'quantity',
    value: 'Quantity'
},{
    key: 'averageQuantity',
    value: 'Average Quantity'
},{
    key: 'averageSales',
    value: 'Average Sales($)'
}];

let filters = { }; 
let resultYearlySales = [];
const getYearlySalesData = (page) => {
    let endpoint = baseUrl + 'Sales/yearlySalesData.php?';
    let params = {
        offset: (page-1) * 15,
        limit: 15  
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
            $("#total-page").html(Math.ceil(data.total/15));
            $("#table-details").html(makeTable(columnNames, data.data));
            $("#table-div").removeClass('hide');
            resultYearlySales = data.data;
        }
    });
};

$(document).ready(function(){
    getYearlySalesData(1);
    $("#search-button").click(function(){
        filters = {};
        $('.filter-input-area').find('.filter-input').each((index, inputText) => {
            if(inputText.value){
                filters[inputText.name] = inputText.value;
            }
        });
        getYearlySalesData(1);
    });
    $("#reset-button").click(function(){
        filters = {};
        getYearlySalesData(1);
    });
    $("#clear-filter").click(function(){
        filters = {};
        getYearlySalesData(1);
    });
    $("#previous-page-button").click(function(){
        let currentPage = parseInt($("#current-page").html());
        if(currentPage == 1) {
            return;
        }
        getYearlySalesData(currentPage-1);
    });
    $("#next-page-button").click(function(){
        let currentPage = parseInt($("#current-page").html());
        let totalPage = parseInt($("#total-page").html());
        if(currentPage == totalPage) {
            return;
        }
        getYearlySalesData(currentPage+1);
    });
    $("#export-button").click(function(){
        exportCsv(resultYearlySales, 'yearlySalesData');
    });
});