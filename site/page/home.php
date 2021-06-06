<?php 
    include_once '../helper/start_session.php';
    if($userName != "") {
        header("Location:../page/product.php");
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
        <title>
            Warehouse Management System
        </title>        
    </head>
    <body>
        <div class="content-wrap-home">
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
                                header("Location:../page/product.php");
                            } else {
                                echo'
                                <div class="right-division">
                                    <div class="login-button">  
                                        <div id="register-button" class="filter-btn button search-btn">Sign Up</div>
                                        <div id="login-button" class="filter-btn button search-btn hide">Sign In</div>
                                    </div>
                                </div>';
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
                                <a href="../page/home.php" class="navigation-tab-item-active ">Home</a>
                                <a href="../page/product.php" class="navigation-tab-item">Products</a>
                                <a href="../page/orders.php" class="navigation-tab-item">Orders</a>
                                <a href="../page/dailysales.php" class="navigation-tab-item">Daily Sales</a>
                                <a href="../page/yearlysales.php" class="navigation-tab-item">Yearly Sales</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-space-home">

            </div>
            <div class="logo-home-image">
                <img src="../assets/images/wms-home-logo.jpg" alt="company logo"/>
                <div id="login-card" class="login-card" >
                    <div class="header-text-title bold">Sign In</div>
                    <form method="post" action="../../api/authenticate.php">
                        <div class="input-box-filter login-input">
                            <input type="text" class="text-input text-font-family userEmail" placeholder=" " id="userEmail"  name="userEmail">
                            <label for="userEmail" class="text-input-label">User Email</label>
                        </div>
                        <div id="useremail-error-msg" class="error-msg-home hide"><i class="fas fa-exclamation-circle"></i> Email should be in proper format.</div>
                        <div class="input-box-filter login-input">
                            <input type="password" class="text-input text-font-family password" placeholder=" " id="password" name="password">
                            <label for="password" class="text-input-label">Password</label>
                        </div>
                        <div id="password-error-msg" class="error-msg-home hide"><i class="fas fa-exclamation-circle"></i> Password should not be blank.</div>
                        <div class="login-submit-div">
                            <button type="submit" class="login-submit button">Sign In</button>
                        </div>
                    </form>
                </div>
                <div id="register-card" class="login-card register-card hide" >
                    <div class="header-text-title bold">Sign Up</div>
                    <form method="post" action="../../api/registerUser.php">
                        <div class="input-box-filter login-input">
                            <input type="text" class="text-input text-font-family" placeholder=" " id="fullName"  name="fullName">
                            <label for="fullName" class="text-input-label">Full Name</label>
                        </div>
                        <div id="fullname-error-msg" class="error-msg-home hide"><i class="fas fa-exclamation-circle"></i> Username should not be blank.</div>
                        <div class="input-box-filter login-input">
                            <input type="text" class="text-input text-font-family userEmail" placeholder=" " id="userEmail"  name="userEmail">
                            <label for="userEmail" class="text-input-label">Email</label>
                        </div>
                        <div id="useremail-error-msg" class="error-msg-home hide"><i class="fas fa-exclamation-circle"></i> Email should be in proper format.</div>
                        <div class="input-box-filter login-input">
                            <input type="password" class="text-input text-font-family password" placeholder=" " id="password" name="password">
                            <label for="password" class="text-input-label">Password</label>
                        </div>
                        <div id="password-error-msg" class="error-msg-home hide"><i class="fas fa-exclamation-circle"></i> Password should not be blank.</div>
                        <div class="input-box-filter login-input">
                            <input type="password" class="text-input text-font-family" placeholder=" " id="confirmPassword" name="confirmPassword">
                            <label for="confirmPassword" class="text-input-label">Confirm Password</label>
                        </div>
                        <div id="cpassword-error-msg" class="error-msg-home hide"><i class="fas fa-exclamation-circle"></i> Value doesn't match with password.</div>
                        <div class="login-submit-div">
                            <button type="submit" class="login-submit button">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer class="footer">
            <span>About Us</span><br>
            <span>© Copyright Warehouse Management Systems KJSCE 2021</span><br>
            <span>1612066 Tejal Kadu</span><br>
            <span>1822028 Shraddha Waghmare</span><br>
            <span>1822029 Mansi Kurhade</span>
        </footer>
    </body>
</html>