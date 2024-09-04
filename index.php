<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanemochi Samurai</title>
    <link rel="stylesheet" href="frontend/css/index.css">
    <link rel="icon" type="image/png" href="assets/Logo.png">
</head>
<body>
    <div class="container">
        <header>
            <!-- <nav>
                <ul>
                    <li>Kanemochi Samurai</li>
                    <div class="option_container">
                        <li><button class="option" id="order-btn" type="button">Order</button></li>
                        <li><button class="option" id="shipment-btn" type="button">Shipment</button></li>
                        <li><button class="option" id="payment-btn" type="button">Payment</button></li> 
                    </div>
                    <li class="user-greeting">Hi, </li>
                </ul>
            </nav> -->

            <nav>
                <ul class="sidebar">
                    <li class="close_menu_button" onclick="hideSidebar()">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 -960 960 960" width="26" fill="#e8eaed">
                                <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                            </svg>
                        </a>
                    </li>
                    <li class="user-greeting-side">Hi, <?php echo htmlspecialchars($username); ?></li>
                    <div class="option_container2">
                        <li><button class="option2" id="order-side" type="button">Order</button></li>
                        <li><button class="option2" id="shipment-side" type="button">Shipment</button></li>
                        <li><button class="option2" id="payment-side" type="button">Payment</button></li>
                    </div>
                </ul>
                <ul>
                    <li class="logo">Kanemochi Samurai</li>
                    <div class="option_container">
                        <li class="hideOnMobile"><button class="option" id="order-btn" type="button">Order</button></li>
                        <li class="hideOnMobile"><button class="option" id="shipment-btn" type="button">Shipment</button></li>
                        <li class="hideOnMobile"><button class="option" id="payment-btn" type="button">Payment</button></li>    
                    </div>
                    <li class="hideOnMobile user-greeting">Hi, <?php echo htmlspecialchars($username); ?></li>
                    <li class="menu_button" onclick="showSidebar()">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" height="26" viewBox="0 -960 960 960" width="26" fill="#e8eaed">
                                <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>

        </header>

        <div class="content_container">
    
            <div class="right_container">
                <div id="order">
                    <div class="content_section">
                        <h1>Order Page</h1>
                        <div class="display_button">
                           <div class="customer">
                                <button id="display_customer_form">Customer</button>
                            </div>

                            <div class="item">
                                <button id="display_item_form">Item</button>
                            </div> 
                        </div>
                        
                        <form action="backend/php/cust_order.php" method="post" class="input_form" id="customer_form">
                            <h2>Input Customer Order</h2>
                            <input type="text" id="name" name="name" placeholder="Nama" required>
                            <br>
                            <input type="text" id="phone" name="phone" placeholder="No. HP" required>
                            <br>
                            <button type="button" id="cust_id_button">Generate Customer ID</button>
                            <br>
                            <input type="text" id="cust_id" name="cust_id" placeholder="Customer ID" readonly>
                            <br>
                            <button class="submit_btn" type="submit">Submit Customer</button>
                        </form>

                        <form action="backend/php/item_order.php" method="post" class="input_form" id="item_form">
                            <h2>Item Information</h2>
                            <label for="order_date">Order Date: </label>
                            <br>
                            <input type="date" id="order_date" name="order_date" required>
                            <br>
                            <input type="text" id="brand" name="brand" placeholder="Brand" required>
                            <br>
                            <select id="type1" name="type1" required>
                                <option value="" disabled selected>Type 1</option>
                                <option value="bag">Bag & Wallet</option>
                                <option value="apparel">Apparel (Baju, Topi, Sarung tangan, dll)</option>
                                <option value="sports">Sports & Hobby</option>
                                <option value="health">Healthcare & Cosmetic</option>
                                <option value="food">Food & Beverages</option>
                                <option value="baby">Baby Stuff</option>
                                <option value="goods">Character Goods</option>
                            </select>
                            <br>
                            <input type="text" id="type2" name="type2" placeholder="Type 2" required>
                            <br>
                            <input type="text" id="details" name="details" placeholder="Details" required>
                            <br>
                            <button type="button" id="order_id_button" class="generate_id">Generate Order ID</button>
                            <br>
                            <input type="text" id="order_id" name="order_id" readonly placeholder="Order ID" required>
                            <br>
                            <label for="customer_id_order">Ordered by: </label>
                            <br>
                            <input type="text" id="customer_id" name="customer_id" placeholder="Input the Customer ID" required>
                            <br>
                            <button class="submit_btn" type="submit">Submit Order</button>
                        </form>
                    </div>
                </div>

                <div id="shipment">
                    <div class="content_section">
                        <h1>Shipment Page</h1>

                        <form onsubmit="return false;" id="order_id_input">
                            <label for="check_order_id">Input Order ID: </label>
                            <input type="text" id="check_order_id" class="check_order_id" placeholder="Order ID">
                            <button class="check_btn" type="button" onclick="checkOrderId(event)">Check Order ID</button>
                            <div id="order_id_validation" style="display: inline-block; margin-top: 10px;"></div>
                        </form>

                        <div class="display_button shipment_option_button">
                            <div class="ordered_ship">
                                 <button id="ordered_state">Ordered</button>
                            </div>
 
                            <div class="arrived_jp_ship">
                                 <button id="arrived_jp_state">Arrived in JP</button>
                            </div>

                            <div class="shipped_idn_ship">
                                <button id="shipped_idn_state">Shipped to IDN</button>
                            </div>

                            <div class="arrived_idn_ship">
                                <button id="arrived_idn_state">Arrived in IDN</button>
                            </div>

                            <div class="sent_ship">
                                <button id="sent_state">Sent to Cust</button>
                            </div> 
                        </div>

                        <form action="backend/php/shipment_1.php" method="post" class="input_form" id="ordered_form">
                            <h2>Ordered</h2>
                            <input type="text" id="order_id_1" name="order_id" class="order_id_1" placeholder="Order ID" required>
                            <br>
                            <input type="text" id="merchant" name="merchant" class="merchant" placeholder="Merchant" required>
                            <br>
                            <input type="text" id="ordered_payment" name="ordered_payment" class="ordered_payment" placeholder="Payment" required>
                            <br>
                            <input type="text" id="ordered_price" name="ordered_price" class="ordered_price" placeholder="Price" required>
                            <br>
                            <button class="submit_btn" name="submit" type="submit">Submit Data</button>
                        </form>
                        <form action="backend/php/shipment_2.php" method="post" class="input_form" id="arrived_jp_form" enctype="multipart/form-data">
                            <h2>Arrived in JP</h2>
                            <input type="text" id="order_id_2" name="order_id" class="order_id_2" placeholder="Order ID" required>
                            <br>
                            <label for="upload_img">Upload Image:</label>
                            <br>
                            <div class="file-input-container">
                                <label for="imageInput">Choose a file</label>
                                <input type="file" id="imageInput" name="imageInput" accept="image/*" required />
                            </div>
                            <br>
                            <img id="preview" src="" alt="Preview Gambar" style="display:none; width: 300px; height: auto;" />
                            <br>
                            <button class="submit_btn" type="submit">Submit Data</button>  
                        </form>
                        <form action="backend/php/shipment_3.php" method="post" class="input_form" id="shipped_idn_form">
                            <h2>Shipped to IDN</h2>
                            <input type="text" id="order_id_3" name="order_id" class="order_id_3" placeholder="Order ID" required>
                            <br>
                            <label for="shipment_date">Shipment Date: </label>
                            <br>
                            <input type="date" id="shipment_date" name="shipment_date" required>
                            <br>
                            <select id="shipment_method" name="shipment_method" required>
                                <option value="shipment_method" disabled selected>Shipment Method</option>
                                <option value="ems">EMS</option>
                                <option value="handcarry">Handcarry</option>
                                <option value="seafreight">Sea Freight</option>
                                <option value="others">Others</option>
                            </select>
                            <br>
                            <input type="text" id="provider" name="provider" class="provider" placeholder="Provider" required>
                            <br>
                            <button type="button" id="shipment_id_button" class="generate_id">Generate Shipment ID</button>
                            <br>
                            <input type="text" id="shipment_id" name="shipment_id" readonly placeholder="Shipment ID">
                            <br>
                            <button class="submit_btn" name="submit" type="submit">Submit Data</button>  
                        </form>
                        <form action="backend/php/shipment_4.php" method="post" class="input_form" id="arrived_idn_form">
                            <h2>Arrived in IDN</h2>
                            <input type="text" id="order_id_4" name="order_id" class="order_id_4" placeholder="Order ID" required>
                            <br>
                            <label for="arrived_date">Arrived Date: </label>
                            <br>
                            <input type="date" id="arrived_date" name="arrived_date" required>
                            <br>
                            <input type="text" id="received_by" name="received_by" class="received_by" placeholder="Received by" required>
                            <br>
                            <button class="submit_btn" name="submit" type="submit">Submit Data</button>
                        </form>
                        <form action="backend/php/shipment_5.php" method="post" class="input_form" id="sent_form">
                            <h2>Sent to Cust</h2>
                            <input type="text" id="order_id_5" name="order_id" class="order_id_5" placeholder="Order ID" required>
                            <br>
                            <label for="sent_date">Sent Date: </label>
                            <br>
                            <input type="date" id="sent_date" name="sent_date" required>
                            <br>
                            <input type="text" id="sent_by" name="sent_by" class="sent_by" placeholder="Sent by" required>
                            <br>
                            <button class="submit_btn" name="submit" type="submit">Submit Data</button>
                        </form>
                    </div>
                </div>
                <div id="payment">
                    <div class="content_section">
                        <h1>Payment Page</h1>

                        <div class="display_button">
                            <div class="payment_for_order">
                                 <button id="display_order_payment">Order</button>
                             </div>
 
                             <div class="payment_for_shipment">
                                 <button id="display_shipment_payment">Shipment</button>
                             </div>

                             <div class="payment_for_others">
                                <button id="display_payment_others">Other Payment</button>
                            </div> 
                        </div>

                        <form action="backend/php/payment_order.php" method="post" class="input_form" id="payment_order_form">
                            <h2>Payment for Order</h2>
                            <label for="order_payment_date">Payment Date: </label> <br>
                            <input type="date" id="order_payment_date" name="order_payment_date" required>
                            <br>
                            <input type="text" id="order_id_input" name="order_id_input" placeholder="Order ID" required>
                            <select id="order_payment_in" name="order_payment_in" required>
                                <option value="order_payment_in" disabled selected>Select Currency</option>
                                <option value="jpy">JPY</option>
                                <option value="idr">IDR</option>
                            </select>
                            <br>
                            <input type="number" id="amount" name="amount" placeholder="Amount" required>
                            <br>
                            <button type="button" id="trx_order_id_button" class="generate_id">Generate Trx ID</button>
                            <br>
                            <input type="text" id="trx_order_id" name="trx_order_id" readonly placeholder="Trx ID">
                            <br>
                            <button class="submit_btn" type="submit">Submit Transaction</button>
                        </form>

                        <form action="backend/php/payment_shipment.php" method="post" class="input_form" id="payment_shipment_form">
                            <h2>Payment for Shipment</h2>
                            <label for="shipment_payment_date">Payment Date: </label> <br>
                            <input type="date" id="shipment_payment_date" name="shipment_payment_date" required>
                            <br>
                            <input type="text" id="shipment_id_input" name="shipment_id_input" placeholder="Shipment ID" required>
                            <br>
                            <select id="shipment_payment_in" name="shipment_payment_in" required>
                                <option value="shipment_payment_in" disabled selected>Select Currency</option>
                                <option value="jpy">JPY</option>
                                <option value="idr">IDR</option>
                            </select>
                            <br>
                            <input type="number" id="amount" name="amount" placeholder="Amount" required>
                            <br>
                            <button type="button" id="trx_shipment_id_button" class="generate_id">Generate Trx ID</button>
                            <br>
                            <input type="text" id="trx_shipment_id" name="trx_shipment_id" readonly placeholder="Trx ID">
                            <br>
                            <button class="submit_btn" type="submit">Submit Transaction</button>
                        </form>

                        <form action="backend/php/payment_others.php" method="post" class="input_form" id="payment_others_form">
                            <h2>Other Payment</h2>
                            <label for="others_payment_date">Payment Date: </label> <br>
                            <input type="date" id="others_payment_date" name="others_payment_date" required>
                            <br>
                            <select id="payment_type" name="payment_type" required>
                                <option value="payment_type" disabled selected>Payment Type</option>
                                <option value="cc">Payment CC</option>
                                <option value="pajak">Pajak</option>
                                <option value="switch">Switch</option>
                            </select>
                            <br>
                            <select id="others_payment_in" name="others_payment_in" required>
                                <option value="others_payment_in" disabled selected>Select Currency</option>
                                <option value="jpy">JPY</option>
                                <option value="idr">IDR</option>
                            </select>
                            <br>
                            <input type="number" id="amount" name="amount" placeholder="Amount" required>
                            <br>
                            <button type="button" id="trx_others_id_button" class="generate_id">Generate Trx ID</button>
                            <br>
                            <input type="text" id="trx_others_id" name="trx_others_id" readonly placeholder="Trx ID">
                            <br>
                            <button class="submit_btn" type="submit">Submit Transaction</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="frontend/js/script.js"></script>
</body>
</html>