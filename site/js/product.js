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
},{
    key: 'leadTime',
    value: 'Lead Time'
}];

let filters = { }; 
let resultProduct = [];
const getProductData = (page) => {
    let endpoint = baseUrl + 'product/getProductList.php?';
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
        if(data.message == 'No Products Found') {
            $("#table-count").html('0');
            $("#table-div").addClass('hide');
        } else {
            $("#table-count").html(data.total);
            $("#current-page").html(page);
            $("#total-page").html(Math.ceil(data.total/10));
            $("#table-details").html(makeTable(columnNames, data.data, true));
            $("#table-div").removeClass('hide');
            $(".delete-product").click(deleteProduct);
            $(".edit-product").click(editProduct);
            resultProduct = data.data;
        }
    });
};

$(document).ready(function(){
    getProductData(1);
    $("#search-button").click(function(){
        filters = {};
        $('.filter-input-area').find('.filter-input').each((index, inputText) => {
            if(inputText.value){
                filters[inputText.name] = inputText.value;
            }
        });
        getProductData(1);
    });
    $("#reset-button").click(function(){
        filters = {};
        getProductData(1);
    });
    $("#clear-filter").click(function(){
        filters = {};
        getProductData(1);
    });
    $("#previous-page-button").click(function(){
        let currentPage = parseInt($("#current-page").html());
        if(currentPage == 1) {
            return;
        }
        getProductData(currentPage-1);
    });
    $("#next-page-button").click(function(){
        let currentPage = parseInt($("#current-page").html());
        let totalPage = parseInt($("#total-page").html());
        if(currentPage == totalPage) {
            return;
        }
        getProductData(currentPage+1);
    });
    $("#export-button").click(function(){
        exportCsv(resultProduct, 'productData');
    });
    $("#add-button").click(function(){
        $("#add-product-modal").removeClass('hide');
    });
    $('#add-product-form').submit(function(e) {
        e.preventDefault();
        let values = {};
        $.each($('#add-product-form').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });    
        values['productId'] = Math.floor(100000 + Math.random() * 900000);
        $.ajax({
            method: "POST",
            type:"POST",
            url: baseUrl + 'product/insertProduct.php',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(values),
            dataType: "json",
            success: (res) => {
                if(res.status === 400){
                    $(".failure").removeClass('hide');
                    return;
                }
                let currentPage = parseInt($("#current-page").html());
                getProductData(currentPage);
                $(".success1").find(".alert-message").text("Product Added.");
                $(".success1").removeClass('hide');
                $("#add-product-modal").addClass('hide');
            },
            failure: () => {$(".failure").removeClass('hide');}
        });
    });
    $('#update-product-form').submit(function(e) {
        e.preventDefault();
        let values = {};
        $.each($('#update-product-form').serializeArray(), function(i, field) {
            values[field.name] = field.value;
        });    
        values['productId'] = $(".product-id-update").text();
        $.ajax({
            method: "POST",
            type:"POST",
            url: baseUrl + 'product/updateProduct.php',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(values),
            dataType: "json",
            success: (res) => {
                if(res.status === 400){
                    $(".failure").removeClass('hide');
                    return;
                }
                let currentPage = parseInt($("#current-page").html());
                getProductData(currentPage);
                $(".success1").find(".alert-message").text("Product Updated.");
                $(".success1").removeClass('hide');
                $("#update-product-modal").addClass('hide');
            },
            failure: () => {$(".failure").removeClass('hide');}
        });
    });
});

const deleteProduct = (event) => {
    let productId = event.currentTarget.getAttribute('data-id');
    $.ajax({
        method: "POST",
        type:"POST",
        url: baseUrl + 'product/deleteProduct.php',
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify({
            "productId": productId
        }),
        dataType: "json",
        success: (res) => {
            if(res.status === 400){
                $(".failure").removeClass('hide');
                return;
            }
            let currentPage = parseInt($("#current-page").html());
            getProductData(currentPage);
            $(".success1").find(".alert-message").text("Product deleted.");
            $(".success1").removeClass('hide');
        },
        failure: () => {$(".failure").removeClass('hide');}
    });
};

const editProduct = (event) => {
    let productId = event.currentTarget.getAttribute('data-id');
    let data = resultProduct.filter((product) => productId === product.productId)[0];
    data['expiredDate'] = data['expiryDate'];
    $(".product-id-update").text(data['productId']);
    $('#update-product-form').find('input').each((index, ele)=> {
        if(ele.name.includes('Date')) {
            ele.value = data[ele.name].substr(0, 10);
        } else {
            ele.value = data[ele.name];
        }    
    });
    $("#update-product-modal").removeClass('hide');
};