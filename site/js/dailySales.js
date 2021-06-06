const baseUrl = "http://localhost/wms/api/";
const columnNames = [{
    key: 'productId',
    value: 'Product Id'
},{
    key: 'salesDate',
    value: 'Sales Date'
},{
    key: 'quantity',
    value: 'Quantity'
},{
    key: 'sales',
    value: 'Sales($)'
}];

let filters = { }; 
let resultDailySales = [];
const getDailySalesData = (page) => {
    let endpoint = baseUrl + 'Sales/dailySalesData.php?';
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
            data.data = data.data.map((row) => { 
                row.salesDate = row.salesDate.split('/')[1] + '-' + row.salesDate.split('/')[0] + '-' + row.salesDate.split('/')[2];
                return row;
            });
            $("#table-count").html(data.total);
            $("#current-page").html(page);
            $("#total-page").html(Math.ceil(data.total/15));
            $("#table-details").html(makeTable(columnNames, data.data));
            $("#table-div").removeClass('hide');
            resultDailySales = data.data;
        }
    });
};

$(document).ready(function(){
    getDailySalesData(1);
    $("#search-button").click(function(){
        filters = {};
        $('.filter-input-area').find('.filter-input').each((index, inputText) => {
            if(inputText.value){
                filters[inputText.name] = inputText.value;
                if(inputText.type == 'date') {
                    filters[inputText.name] = parseInt(inputText.value.split('-')[1]) + '/' + parseInt(inputText.value.split('-')[2]) + '/' + parseInt(inputText.value.split('-')[0]);
                }
            }
        });
        getDailySalesData(1);
    });
    $("#reset-button").click(function(){
        filters = {};
        getDailySalesData(1);
    });
    $("#clear-filter").click(function(){
        filters = {};
        getDailySalesData(1);
    });
    $("#previous-page-button").click(function(){
        let currentPage = parseInt($("#current-page").html());
        if(currentPage == 1) {
            return;
        }
        getDailySalesData(currentPage-1);
    });
    $("#next-page-button").click(function(){
        let currentPage = parseInt($("#current-page").html());
        let totalPage = parseInt($("#total-page").html());
        if(currentPage == totalPage) {
            return;
        }
        getDailySalesData(currentPage+1);
    });
    $("#export-button").click(function(){
        exportCsv(resultDailySales, 'dailySalesData');
    });
});