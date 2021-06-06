<?php 
    include_once '../helper/start_session.php';
    if($userName == "") {
        header("Location:../page/home.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="../../site/css/main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="../js/placeorder.js"></script>
        <title>
            Warehouse Management System
        </title>        
    </head>
    <body>
        <div id="filter-area" class="filter-area">
            <div class="filter-input-area">
                <div class="filter-input-line">
                    <div class="input-box-filter">
                        <input type="text" class="filter-input text-input text-font-family" placeholder=" " id="productId"  name="productId" value="">
                        <label for="productId" class="text-input-label">ProductId</label>
                    </div>
                    <div class="input-box-filter small-margin-left">
                        <input type="text" class="filter-input text-input text-font-family" placeholder=" " id="quantity"  name="quantity" value="">
                        <label for="quantity" class="text-input-label">Quantity</label>
                    </div>
                </div>
                <div class="filter-input-line">
                    <div class="input-box-filter">
                        <input type="text" class="filter-input text-input text-font-family" placeholder=" " id="customerId"  name="customerId" value="">
                        <label for="customerId" class="text-input-label">Customer Id</label>
                    </div>
                </div>
            </div>
            <div class="filter-button-div">
                <div class="filter-button">
                    <div id="place-order-button" class="filter-btn button search-btn">Place Order</div>
                </div>
            </div>
        </div>   
        <div id="place-order-status" class="header-text-title bold"></div>   
    </body>
</html>