<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Email Template</title>
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            background-color: #e9e9e9;
            font-family: "Lato", sans-serif;
        }

        .body-wrapper {
            background-color: #fff;
            margin: auto;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0px;
            width: 100%;
        }

        .invoice-icon {
            width: 300px;
            padding: 10px 30px;
        }

        .invoice-icon img {
            width: 100%;
        }

        .invoice-no {
            text-align: end;
            background-color: #006a9b;
            padding: 10px 30px;
        }

        .invoice-no h3 {
            font-size: 22px;
            color: #fff;
        }

        .invoice-no h5 {
            font-size: 18px;
            color: #fff;
        }

        .line {
            border: 1px solid #d3d3d3;
        }

        .ordered-client-information {
            display: flex;
            justify-content: space-between;
            align-items: start;
            padding: 20px 50px;
        }

        .ordered-to h6,
        .ordered-from h6 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .ordered-to h5,
        .ordered-from h5 {
            font-size: 22px;
            margin-bottom: 5px;
            color: #006a9b;
            font-weight: 600;
        }

        .ordered-to h4,
        .ordered-from h4 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .ordered-to h4 span,
        .ordered-from h4 span {
            font-size: 20px;
            color: #4b4b4b;
        }

        .ordered-from {
            text-align: left;
        }

        .invoice-table {
            padding: 20px 30px;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #b8b8b8;
        }

        .order-table thead {
            background-color: #006a9b;
            text-align: left;
        }

        .order-table thead th {
            border: none;
            color: #fff;
            padding: 12px 30px;
        }

        .order-table thead th:last-child {
            text-align: end;
        }

        .order-table tbody td {
            border: none;
            color: #000;
            padding: 12px 30px;
            border-bottom: 1px solid #b8b8b8;
            border-right: 1px solid #b8b8b8;
        }

        .order-table tbody td:last-child {
            text-align: end;
            border-right: none;
        }

        .orderproduct-name {
            font-size: 20px;
            color: #006a9b;
        }

        .orderproduct-details {
            font-size: 18px;
            color: #000;
            font-weight: 500;
            margin-bottom: 3px;
        }

        .orderproduct-comment {
            margin-top: 20px;
        }

        .orderproduct-price {
            font-size: 20px;
        }

        .order-table tbody tr {
            background-color: #e6e6e6;
        }

        .inovice-sub {
            display: flex;
            align-items: start;
            justify-content: space-between;
            width: 100%;
            padding: 10px 0px;
        }

        .invoice-note,
        .invoice-subtotal {
            width: 50%;
            padding: 0px 30px;
        }

        .invoice-subtotal {
            text-align: end;
        }

        .invoice-note p {
            font-style: italic;
            color: #646464;
            font-size: 16px;
        }

        .note {
            color: #006a9b;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .pay-unpay-image {
            text-align: center;
        }

        .pay-unpay-image img {
            width: 30%;
        }

        .subtotal,
        .maintotal {
            font-size: 18px;
            color: #006a9b;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .maintotal {
            font-size: 22px;
            margin-top: 5px;
        }

        .invoice-subtotal p {
            font-size: 18px;
            margin-bottom: 5px;
            color: #000;
            font-weight: 600;
        }

        .line-divider {
            border-top: 2px solid #006a9b;
            width: 300px;
            text-align: end;
            display: inline-block;
        }

        .footer-content {
            width: 100%;
            text-align: center;
            padding: 30px 0px;
        }

        .footer-content p {
            color: #2b2b2b;
            font-size: 18px;
            font-weight: 800;
        }

        .footer-content p a {
            color: #006a9b;
            text-transform: uppercase;
            font-size: 18px;
        }

        .tableitemdescription {
            width: 60%;
        }

        .tableunitprice {
            width: 15%;
        }

        .tablequantity {
            width: 10%;
        }

        .tabletotal {
            width: 15%;
        }

        /* Responsive Device*/

        /* Extra small devices (phones, 600px and down) */
        @media only screen and (max-width: 600px) {
            .invoice-header {
                display: block;
                width: 100%;
            }

            .invoice-icon {
                width: auto;
                padding: 10px 30px;
            }

            .ordered-client-information {
                padding: 20px 10px;
            }

            .ordered-to,
            .ordered-from {
                width: 50%;
            }

            .ordered-to h6,
            .ordered-from h6 {
                font-size: 14px;
            }

            .ordered-to h5,
            .ordered-from h5 {
                font-size: 16px;
            }

            .ordered-to h4,
            .ordered-from h4 {
                font-size: 14px;
                margin-bottom: 5px;
            }

            .ordered-to h4 span,
            .ordered-from h4 span {
                font-size: 14px;
                color: #4b4b4b;
            }

            .invoice-table {
                overflow: scroll;
            }

            .order-table tbody td {
                padding: 12px 10px;
            }

            .order-table thead th {
                padding: 12px 0px;
                padding-left: 15px;
                padding-right: 50px;
            }

            .order-table thead th:first-child {
                padding-left: 15px;
                padding-right: 100px;
            }

            .order-table thead th:last-child {
                padding-left: 50px;
                padding-right: 15px;
            }

            .invoice-table {
                padding: 15px 15px;
            }

            .invoice-note,
            .invoice-subtotal {
                padding: 0px 15px;
            }

            .inovice-sub {
                display: block;
                width: 100%;
                transform: rotate(180deg);
            }

            .invoice-note,
            .invoice-subtotal {
                width: auto;
                padding: 0px 15px;
                transform: rotate(180deg);
            }

            .invoice-note {
                padding-top: 10px;
            }

            .pay-unpay-image img {
                width: 50%;
            }

            .footer-content p {
                font-size: 16px;
            }
        }

        /* Small devices (portrait tablets and large phones, 600px and up) */
        @media only screen and (min-width: 600px) {
        }

        /* Medium devices (landscape tablets, 768px and up) */
        @media only screen and (min-width: 768px) {
            .pay-unpay-image img {
                width: 50%;
            }
        }

        /* Large devices (laptops/desktops, 992px and up) */
        @media only screen and (min-width: 992px) {
            .pay-unpay-image img {
                width: 30%;
            }

            .footer-content p {
                font-size: 18px;
            }
        }

        /* Extra large devices (large laptops and desktops, 1200px and up) */
        @media only screen and (min-width: 1200px) {
        }

    </style>
</head>
<body>
<div class="body-wrapper">
    <div class="invoice-header">
        <div class="invoice-icon">
            <img src="https://medicinapharmacy.yumaapp.uk/assets/images/logo.png" alt=""/>
        </div>
        <div class="invoice-no">
            <h3>Order Confirmation</h3>
            <h5>Order No. <span>12345</span></h5>
        </div>
    </div>
    <div class="line"></div>
    <div class="ordered-client-information">
        <div class="ordered-to">
            <h6>To,</h6>
            <h5>Muntasir Hasan</h5>
            <h4>Phone: <span>0123 456 7890</span></h4>
        </div>
        <div class="ordered-from">
            <h6>From,</h6>
            <h5>Food</h5>
            <h4>Order Type: <span>Collection</span></h4>
            <h4>Placed at: <span>08-05-23 10:39</span></h4>
            <h4>Collection Time: <span>08-05-23 11:20</span></h4>
        </div>
    </div>
    <div class="line"></div>
    <div class="invoice-table">
        <table class="order-table">
            <thead>
            <tr>
                <th class="tableitemdescription">Item Description</th>
                <th class="tableunitprice">Unit Price</th>
                <th class="tablequantity">Quantity</th>
                <th class="tabletotal">Total</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <h4 class="orderproduct-name">1 x Dansak</h4>
                    <p class="orderproduct-details">Protain: <span>Chicken</span></p>
                    <p class="orderproduct-comment">Comment: <span>No Comment</span></p>
                </td>
                <td>
                    <h4 class="orderproduct-price">9.00</h4>
                </td>
                <td>
                    <h4 class="orderproduct-price quantity">1</h4>
                </td>
                <td>
                    <h4 class="orderproduct-price total">9.00</h4>
                </td>
            </tr>
            <tr>
                <td>
                    <h4 class="orderproduct-name">1 x Dansak</h4>
                    <p class="orderproduct-details">Protain: <span>Chicken</span></p>
                    <p class="orderproduct-comment">Comment: <span>No Comment</span></p>
                </td>
                <td>
                    <h4 class="orderproduct-price">3.00</h4>
                </td>
                <td>
                    <h4 class="orderproduct-price quantity">3</h4>
                </td>
                <td>
                    <h4 class="orderproduct-price total">9.00</h4>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="inovice-sub">
        <div class="invoice-note">
            <h4 class="note">Note:</h4>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s.</p>
            <div class="pay-unpay-image">
                <img src="../images/paid.png" alt="">
            </div>
        </div>
        <div class="invoice-subtotal">
            <h4 class="subtotal">Sub Total: <span>9.00</span></h4>
            <p>Delivery Charge: <span>0.00</span></p>
            <p>Discount: <span>0.00</span></p>
            <p>Vat (0%): <span>0.00</span></p>
            <div class="line-divider"></div>
            <h3 class="maintotal">Total: <span>9.00</span></h3>
        </div>
    </div>
    <div class="invoice-footer">
        <div class="footer-content">
            <p>This Transaction will appear as Payment Ref. <a href="#">Redmango</a></p>
        </div>
    </div>
</div>
</body>
</html>
