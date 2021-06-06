const baseUrl = "http://localhost/wms/api/";

let filters = { }; 
let resultOrder = [];
const placeOrder = (values) => {
    let endpoint = baseUrl + 'orders/placeOrder.php?';
    $.ajax({
        method: "POST",
        type:"POST",
        url: endpoint,
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(values),
        dataType: "json",
        success: (data) => {
            console.log(data);
            if(data.status == 200) {
                $("#place-order-status").html("Order place successfully with Invoice Number: " + values["invoiceNumber"])
            } else {
                $("#place-order-status").html(data.message);
            }
        }
    });
};

$(document).ready(function(){
    $("#place-order-button").click(function(){
        filters = {};
        $('.filter-input-area').find('.filter-input').each((index, inputText) => {
            if(inputText.value){
                filters[inputText.name] = inputText.value;
            }
        });
        filters['invoiceNumber'] = Math.floor(100000 + Math.random() * 900000);
        placeOrder(filters);
    });
});