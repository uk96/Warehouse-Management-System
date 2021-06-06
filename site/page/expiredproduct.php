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
        <script src="../js/starter.js"></script>
        <script src="../js/filter.js"></script>
        <script src="../js/expiredproduct.js"></script>
        <script src="../js/helper.js"></script>
        <script src="../js/exportCsv.js"></script>
        <title>
            Warehouse Management System
        </title>        
    </head>
    <body>
        <div class="alert failure hide">
            <span class="closebtn" onclick="this.parentElement.classList.add('hide');">&times;</span>
            <span class="alert-message" >Error occurred while sending mail.</span>
        </div>
        <div class="alert success hide">
            <span class="closebtn" onclick="this.parentElement.classList.add('hide');">&times;</span>
            <span class="alert-message" >Mail sent successfully..</span>
        </div>
        <div class="content-wrap">
            <div class="header">
                <div class="navigation-bar-line"> 
                    <div class="navigation-bar-division"> 
                        <div class="left-division">
                            <div class="logo-div"><img class="logo-image" src="../assets/images/wms-logo.jpg" alt="company logo"/></div>
                            <div class="line-divider"></div>
                            <div class="header-text-title bold">Dashboard</div>
                        </div>
                        <?php  
                            if($userName != "") {
                                echo'
                                <div class="right-division">
                                    <div class="user-details">  
                                        <div class="small-font-text bold">'.$userName.'</div>
                                        <div id="userEmail" class="small-font-text normal">'.$userEmail.'</div>
                                        <div id="logout-card" class="logout-card hide">
                                            <div class="arrow"></div>
                                            <a href="../../api/logout.php" class="button">Logout</a>
                                        </div>
                                    </div>
                                    <button id="user-icon" class="user-icon button">'. strtoupper(substr($userName,0,1)) .'</button>
                                </div>';
                            } else {
                                header("Location:../page/home.php");
                            }
                        ?>
                    </div>
                </div>
                <div class="navigation-bar-line navigation-low-height"> 
                    <div class="navigation-bar-division"> 
                        <div class="left-division navigation-low-height">
                            <div class="header-text-title normal">Warehouse Management System</div>
                        </div>
                        <div class="right-division navigation-low-height">
                            <div class="navigation-tab <?php if($userName == "") { echo'hide';}?>">
                                <a href="../page/product.php" class="navigation-tab-item-active">Products</a>
                                <a href="../page/orders.php" class="navigation-tab-item">Orders</a>
                                <a href="../page/dailysales.php" class="navigation-tab-item">Daily Sales</a>
                                <a href="../page/yearlysales.php" class="navigation-tab-item">Yearly Sales</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-space">

            </div>
            <div class="body">
                <div class="container">
                    <div class="navigation-bar-division lower-navigation-bar">
                        <div class="left-division page-name bold">Expired Product Data</div>
                        <div class="right-division">
                                <div class="navigation-tab <?php if($userName == "") { echo'hide';}?>">
                                    <a href="../page/product.php" class="navigation-tab-item">Product List</a>
                                    <a href="../page/expiredproduct.php" class="navigation-tab-item-active">Expired Product List</a>
                                    <a href="../page/reorderproduct.php" class="navigation-tab-item">Threshold Product List</a>
                                </div>
                        </div>
                    </div>
                    <div class="divider-line"></div>
                    <div class="filter-div">
                        <div class="filter-div-tab">
                            <i class="fa fa-filter small-font-icon" aria-hidden="true"></i>
                            <span class="small-font-text bold">FILTERS</span>
                            <span id="clear-filter" class="small-font-text bold dark-blue-color small-margin-left button">[ CLEAR ]</span></div>
                        <div class="filter-div-tab">
                            <div class="small-font-text bold">Set Filters &amp; Search</div>
                        </div>
                        <div class="filter-div-tab">
                            <div id="minimize-search" class="minimize-search button">
                                <i id="minimize-search-icon" class="fa fa-minus small-font-icon" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div id="filter-area" class="filter-area">
                        <div class="filter-input-area">
                            <div class="filter-input-line">
                                <div class="input-box-filter small-margin-left">
                                    <input type="date" class="filter-input text-input text-font-family" placeholder=" " id="startDate"  name="startDate" value="">
                                    <label for="startDate" class="text-input-label">Start Range Date</label>
                                </div>
                                <div class="input-box-filter small-margin-left">
                                    <input type="date" class="filter-input text-input text-font-family" placeholder=" " id="endDate"  name="endDate" value="">
                                    <label for="endDate" class="text-input-label">End Range Date</label>
                                </div>
                            </div>
                            <div class="filter-input-line">
                                <div id="error-msg" class="error-msg hide"><i class="fas fa-exclamation-circle"></i> Both Start Date and End date are required.</div>
                                <div id="error-msg-greater" class="error-msg hide"><i class="fas fa-exclamation-circle"></i> Start Date should be before End Date.</div>
                            </div>
                        </div>
                        <div class="filter-button-div">
                            <div class="filter-button">
                                <div id="reset-button" class="filter-btn button reset-btn">Reset</div>
                                <div id="search-button" class="filter-btn button search-btn">Search</div>
                            </div>
                        </div>
                    </div>
                    </br>
                    <div class="table-page-header">
                        <div class="page-total-header">
                            <div class="page-name total-count bold">Total Count:</div>
                            <div id="table-count" class="page-name bold dark-blue-color">0</div>
                        </div>
                        <div class="export-csv">
                            <div id="export-button" class="export-btn button small-margin-left">Export</div>
                            <div id="email-button" class="export-btn button">Email</div>
                        </div>
                    </div>
                    <div id="table-div" class="table-div hide">
                        <table id="table-details" class="details-table expired-product-table-data">
                            
                        </table>   
                        <div class="pagination-slider">
                            <div class="pagination-slider-part black-color"></div>
                            <div class="pagination-slider-part pagination-text-slider">Page&nbsp;<span id="current-page">1</span>&nbsp;of&nbsp;<span id="total-page">7</span></div>
                            <div class="pagination-slider-part black-color"></div>
                        </div>
                    </div>               
                </div>
            </div>
        </div>
        <footer class="footer">
            <span>© Copyright Warehouse Management Systems India 2021</span>
        </footer>
    </body>
</html>