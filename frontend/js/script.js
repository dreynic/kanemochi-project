function showSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.style.display = 'flex';
}

function hideSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function () {
    const orderBtn = document.getElementById("order-btn");
    const shipmentBtn = document.getElementById("shipment-btn");
    const paymentBtn = document.getElementById("payment-btn");
    const orderBtn2 = document.getElementById("order-side");
    const shipmentBtn2 = document.getElementById("shipment-side");
    const paymentBtn2 = document.getElementById("payment-side");

    let activeElement = null;
    let activeButton = null;

    const orderList = document.getElementById("order");
    const shipmentList = document.getElementById("shipment");
    const paymentList = document.getElementById("payment");

    orderBtn.addEventListener("click", () => {
        toggleList(orderList, orderBtn);
    });
    shipmentBtn.addEventListener("click", () => {
        toggleList(shipmentList, shipmentBtn);
    });
    paymentBtn.addEventListener("click", () => {
        toggleList(paymentList, paymentBtn);
    });
    orderBtn2.addEventListener("click", () => {
        toggleList(orderList, orderBtn2);
    });
    shipmentBtn2.addEventListener("click", () => {
        toggleList(shipmentList, shipmentBtn2);
    });
    paymentBtn2.addEventListener("click", () => {
        toggleList(paymentList, paymentBtn2);
    });

    function toggleList(list, button) {
        if (activeElement === list) {
            // If the same button is clicked, do nothing
            return;
        } else {
            if (activeElement) {
                activeElement.style.display = "none";
                activeButton.classList.remove("active");
            }
            list.style.display = "flex";
            activeElement = list;
            activeButton = button;
            button.classList.add("active");
        }
    }

    if (orderList && shipmentList && paymentList) {
        orderList.style.display = "flex";
        shipmentList.style.display = "none";
        paymentList.style.display = "none";
        activeElement = orderList;
        activeButton = orderBtn;
        orderBtn.classList.add("active");
    }
});

// ============================================================================================================
// BUAT NAMPILIN FORM ORDER
document.addEventListener('DOMContentLoaded', function() {
    const customerButton = document.getElementById('display_customer_form');
    const itemButton = document.getElementById('display_item_form');
    const customerForm = document.getElementById('customer_form');
    const itemForm = document.getElementById('item_form');

    function toggleForm(button, form) {
        const isActive = button.classList.contains('active');
        if (!isActive) {
            document.querySelectorAll('.input_form').forEach(f => f.style.display = 'none');
            document.querySelectorAll('.display_button button').forEach(b => b.classList.remove('active'));

            form.style.display = 'block';
            button.classList.add('active');
        }
    }

    customerForm.style.display = 'block';
    customerButton.classList.add('active');

    customerButton.addEventListener('click', function() {
        toggleForm(customerButton, customerForm);
    });

    itemButton.addEventListener('click', function() {
        toggleForm(itemButton, itemForm);
    });
});

// ============================================================================================================
// CUSTOMER FORM
function generateCustomerId(name, phone) {
    // Mengambil 3 karakter pertama dari nama
    const firstThreeFromName = name.substring(0, 3).toUpperCase();

    // Mengambil 3 karakter terakhir dari nomor HP
    const lastThreeFromPhone = phone.slice(-3);

    // Menggabungkan hasilnya untuk Customer ID
    return `${firstThreeFromName}${lastThreeFromPhone}`;
}

document.getElementById("cust_id_button").addEventListener("click", function() {
    const name = document.getElementById("name").value;
    const phone = document.getElementById("phone").value;

    if (name && phone) {
        const custId = generateCustomerId(name, phone);
        document.getElementById("cust_id").value = custId;
    } else {
        alert("Please enter both Name and Phone number to generate Customer ID.");
    }
});

// ============================================================================================================
// ITEM FORM
function generateOrderId(date, brand, type1) {
    // Format Order Date menjadi DDMMYY
    const orderDate = new Date(date);
    const day = ('0' + orderDate.getDate()).slice(-2);
    const month = ('0' + (orderDate.getMonth() + 1)).slice(-2);
    const year = orderDate.getFullYear().toString().slice(-2); // Ambil 2 digit terakhir dari tahun

    // Ambil 2 huruf pertama dari brand dan type1
    const brandPrefix = brand.substring(0, 2).toUpperCase();
    const type1Prefix = type1.substring(0, 2).toUpperCase();

    // Gabungkan semuanya untuk Order ID
    return `${type1Prefix}${day}${month}${year}${brandPrefix}`;
}

function updateOrderId() {
    const date = document.getElementById('order_date').value;
    const brand = document.getElementById('brand').value;
    const type1 = document.getElementById('type1').value;

    // Pastikan semua input sudah diisi
    if (date && brand && type1) {
        const orderId = generateOrderId(date, brand, type1);
        document.getElementById('order_id').value = orderId; // Update readonly input field
    } else {
        document.getElementById('order_id').value = 'Invalid Input'; // Update readonly input field with error message
    }
}

function handleFormSubmit(event) {
    event.preventDefault(); // Mencegah form dikirim

    // Pastikan Order ID sudah di-generate sebelum pengiriman form
    const orderId = document.getElementById('order_id').value;
    if (!orderId || orderId === 'Invalid Input') {
        updateOrderId();
    }

    const form = document.getElementById('item_form');
    form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('order_id_button').addEventListener('click', updateOrderId);
    document.getElementById('item_form').addEventListener('submit', handleFormSubmit);
});

// ============================================================================================================
// SHIPMENT PAGE

// CHECK ORDER ID UDH ADA BLM
// document.querySelector('.check_btn').addEventListener('click', checkOrderId);

// function checkOrderId(event) {
//     event.preventDefault(); // Prevent the default form submission
//     const orderId = document.getElementById('check_order_id').value;
//     const validationDiv = document.getElementById('order_id_validation');

//     if (orderId.trim() === '') {
//         alert('Please input Order ID.');
//         return;
//     }

//     const xhr = new XMLHttpRequest();
//     xhr.open('POST', 'backend/php/check_order_id.php', true);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             const response = JSON.parse(xhr.responseText);
//             if (response.exists) {
//                 validationDiv.textContent = 'Order ID valid.';
//                 validationDiv.style.color = 'black';
//                 disableInput();
//             } else {
//                 validationDiv.textContent = 'Order ID invalid.';
//                 validationDiv.style.color = 'red';
//             }
//         }
//     };

//     xhr.send('order_id=' + encodeURIComponent(orderId));
// }

// function disableInput() {
//     document.getElementById('check_order_id').disabled = true;
//     document.querySelector('.check_btn').disabled = true;
// }

document.querySelector('.check_btn').addEventListener('click', function(event) {
    checkOrderId(event);
});

function checkOrderId(event) {
    event.preventDefault(); // Mencegah pengiriman form secara default
    const orderId = document.getElementById('check_order_id').value;
    const validationDiv = document.getElementById('order_id_validation');

    if (orderId.trim() === '') {
        alert('Please input Order ID.');
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'backend/php/check_order_id.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.exists) {
                validationDiv.textContent = 'Order ID valid.';
                validationDiv.style.color = 'black';

                document.getElementById('order_id_1').value = orderId;
                document.getElementById('order_id_2').value = orderId;
                document.getElementById('order_id_3').value = orderId;
                document.getElementById('order_id_4').value = orderId;
                document.getElementById('order_id_5').value = orderId;
            } else {
                validationDiv.textContent = 'Order ID invalid.';
                validationDiv.style.color = 'red';
            }
        }
    };

    xhr.send('order_id=' + encodeURIComponent(orderId));
}


// NAVIGATION DI SHIPMENT PAGE BUAT PINDAH STATE
document.addEventListener('DOMContentLoaded', function() {
    const orderedButton = document.getElementById('ordered_state');
    const arrivedJPButton = document.getElementById('arrived_jp_state');
    const shippedIDNButton = document.getElementById('shipped_idn_state');
    const arrivedIDNButton = document.getElementById('arrived_idn_state');
    const sentButton = document.getElementById('sent_state');

    const orderedForm = document.getElementById('ordered_form');
    const arrivedJPForm = document.getElementById('arrived_jp_form');
    const shippedIDNForm = document.getElementById('shipped_idn_form');
    const arrivedIDNForm = document.getElementById('arrived_idn_form');
    const sentForm = document.getElementById('sent_form');

    function toggleForm(button, form) {
        const isActive = button.classList.contains('active');
        if (!isActive) {
            // Sembunyikan semua form dan hapus kelas 'active' dari semua tombol
            document.querySelectorAll('.input_form').forEach(f => f.style.display = 'none');
            document.querySelectorAll('.display_button button').forEach(b => b.classList.remove('active'));
            
            // Tampilkan form yang diinginkan dan tambahkan kelas 'active' ke tombol yang dipilih
            form.style.display = 'block';
            button.classList.add('active');
        }
    }

    // Tampilkan form "Ordered" dan aktifkan tombolnya secara default
    orderedForm.style.display = 'block';
    orderedButton.classList.add('active');

    orderedButton.addEventListener('click', function() {
        toggleForm(orderedButton, orderedForm);
    });

    arrivedJPButton.addEventListener('click', function() {
        toggleForm(arrivedJPButton, arrivedJPForm);
    });

    shippedIDNButton.addEventListener('click', function() {
        toggleForm(shippedIDNButton, shippedIDNForm);
    });

    arrivedIDNButton.addEventListener('click', function() {
        toggleForm(arrivedIDNButton, arrivedIDNForm);
    });

    sentButton.addEventListener('click', function() {
        toggleForm(sentButton, sentForm);
    });
});
// ============================================================================================================
// TIMESTAMP ORDERED
function timestampOrdered() {
    const t1Input = document.getElementById('timestamp-1');
    const currentTime1 = new Date().toLocaleString(); // Format the current time as a string
    t1Input.value = currentTime1;

    // Optionally, submit the form here if desired
    // document.getElementById('myForm').submit();
}
// ============================================================================================================
// INPUT GAMBAR DI ARRIVED IN JP
document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
// TIMESTAMP ARRIVED IN JP
function timestampArvJP() {
    const t2Input = document.getElementById('timestamp-2');
    const currentTime2 = new Date().toLocaleString(); // Format the current time as a string
    t2Input.value = currentTime2;

    // Optionally, submit the form here if desired
    // document.getElementById('myForm').submit();
}

// ============================================================================================================
// TIMESTAMP SHIP ID
const generatedIds = {};

document.getElementById('shipment_id_button').addEventListener('click', function() {
    const method = document.getElementById('shipment_method').value;
    const date = new Date(document.getElementById('shipment_date').value);
    if (method === 'shipment_method' || isNaN(date.getTime())) {
        alert('Please select a shipment method and date.');
        return;
    }

    const formattedDate = `${(date.getDate()).toString().padStart(2, '0')}${(date.getMonth() + 1).toString().padStart(2, '0')}${date.getFullYear().toString().slice(-2)}`;
    const baseId = `${method.toUpperCase()}${formattedDate}`;
            
    if (!generatedIds[baseId]) {
        generatedIds[baseId] = 1;
    } else {
        generatedIds[baseId] += 1;
    }

    const shipmentId = `${baseId}-${generatedIds[baseId].toString().padStart(2, '0')}`;
    document.getElementById('shipment_id').value = shipmentId;
});

function timestampShipID() {
    const t3Input = document.getElementById('timestamp-3');
    const currentTime3 = new Date().toLocaleString(); // Format the current time as a string
    t3Input.value = currentTime3;

    // Optionally, submit the form here if desired
    // document.getElementById('myForm').submit();
}


// ============================================================================================================
// TIMESTAMP ARRV ID
function timestampArvID() {
    const t4Input = document.getElementById('timestamp-4');
    const currentTime4 = new Date().toLocaleString(); // Format the current time as a string
    t4Input.value = currentTime4;

    // Optionally, submit the form here if desired
    // document.getElementById('myForm').submit();
}


// ============================================================================================================
// TIMESTAMP SENT
function timestampSent() {
    const t5Input = document.getElementById('timestamp-5');
    const currentTime5 = new Date().toLocaleString(); // Format the current time as a string
    t5Input.value = currentTime5;

    // Optionally, submit the form here if desired
    // document.getElementById('myForm').submit();
}

// ============================================================================================================
// BUAT NAMPILIN PAYMENT PAGE
document.addEventListener('DOMContentLoaded', function() {
    const orderButton = document.getElementById('display_order_payment');
    const shipmentButton = document.getElementById('display_shipment_payment');
    const othersButton = document.getElementById('display_payment_others');

    const orderForm = document.getElementById('payment_order_form');
    const shipmentForm = document.getElementById('payment_shipment_form');
    const othersForm = document.getElementById('payment_others_form');

    function toggleForm(button, form) {
        const isActive = button.classList.contains('active');
        if (!isActive) {
            document.querySelectorAll('.input_form').forEach(f => f.style.display = 'none');
            document.querySelectorAll('.display_button button').forEach(b => b.classList.remove('active'));
            form.style.display = 'block';
            button.classList.add('active');
        }
    }

    orderForm.style.display = 'block';
    orderButton.classList.add('active');

    orderButton.addEventListener('click', function() {
        toggleForm(orderButton, orderForm);
    });

    shipmentButton.addEventListener('click', function() {
        toggleForm(shipmentButton, shipmentForm);
    });

    othersButton.addEventListener('click', function() {
        toggleForm(othersButton, othersForm);
    });
});

// ============================================================================================================
// LOGIC TRX ID

// 1. Payment for Order
const order_payment = {};  // To keep track of transaction counts for each date

document.getElementById('trx_order_id_button').addEventListener('click', function() {
    const orderPaymentDate = document.getElementById('order_payment_date').value;
    const orderPaymentCurrency = document.getElementById('order_payment_in').value.toUpperCase();

    if (!orderPaymentDate || !orderPaymentCurrency) {
        alert('Please select a payment date and currency.');
        return;
    }

    // Format date as DDMMYY
    const OrderDateParts = orderPaymentDate.split('-');
    const formattedDate1 = `${OrderDateParts[2]}${OrderDateParts[1]}${OrderDateParts[0].slice(-2)}`;

    // Generate sequence number
    const dateKey1 = `${orderPaymentCurrency}${formattedDate1}`;
    if (!order_payment[dateKey1]) {
        order_payment[dateKey1] = 0;
    }
    order_payment[dateKey1] += 1;
    const sequenceNumber1 = String(order_payment[dateKey1]).padStart(2, '0');

    // Generate Trx ID
    const orderTrxId = `${orderPaymentCurrency}${formattedDate1}ORD-${sequenceNumber1}`;
    document.getElementById('trx_order_id').value = orderTrxId;
});


// 2. Payment for Shipment
const shipment_payment = {};  // To keep track of transaction counts for each date

document.getElementById('trx_shipment_id_button').addEventListener('click', function() {
    const shipmentPaymentDate = document.getElementById('shipment_payment_date').value;
    const shipmentPaymentCurrency = document.getElementById('shipment_payment_in').value.toUpperCase();

    if (!shipmentPaymentDate || !shipmentPaymentCurrency) {
        alert('Please select a payment date and currency.');
        return;
    }

    // Format date as DDMMYY
    const ShipmentDateParts = shipmentPaymentDate.split('-');
    const formattedDate2 = `${ShipmentDateParts[2]}${ShipmentDateParts[1]}${ShipmentDateParts[0].slice(-2)}`;

    // Generate sequence number
    const dateKey2 = `${shipmentPaymentCurrency}${formattedDate2}`;
    if (!shipment_payment[dateKey2]) {
        shipment_payment[dateKey2] = 0;
    }
    shipment_payment[dateKey2] += 1;
    const sequenceNumber2 = String(shipment_payment[dateKey2]).padStart(2, '0');

    // Generate Trx ID
    const shipmentTrxId = `${shipmentPaymentCurrency}${formattedDate2}SHP-${sequenceNumber2}`;
    document.getElementById('trx_shipment_id').value = shipmentTrxId;
});

// 3. Payment for Others
const others_payment = {};  // To keep track of transaction counts for each date

document.getElementById('trx_others_id_button').addEventListener('click', function() {
    const othersPaymentDate = document.getElementById('others_payment_date').value;
    const othersPaymentCurrency = document.getElementById('others_payment_in').value.toUpperCase();
    const othersPaymentType = document.getElementById('payment_type').value.toUpperCase();

    if (!othersPaymentDate || !othersPaymentCurrency) {
        alert('Please select a payment date and currency.');
        return;
    }

    // Format date as DDMMYY
    const othersDateParts = othersPaymentDate.split('-');
    const formattedDate3 = `${othersDateParts[2]}${othersDateParts[1]}${othersDateParts[0].slice(-2)}`;

    // Generate sequence number
    const dateKey3 = `${othersPaymentCurrency}${formattedDate3}`;
    if (!others_payment[dateKey3]) {
        others_payment[dateKey3] = 0;
    }
    others_payment[dateKey3] += 1;
    const sequenceNumber3 = String(others_payment[dateKey3]).padStart(2, '0');

    // Generate Trx ID
    const othersTrxId = `${othersPaymentCurrency}${formattedDate3}${othersPaymentType}-${sequenceNumber3}`;
    document.getElementById('trx_others_id').value = othersTrxId;
});

// ============================================================================================================
