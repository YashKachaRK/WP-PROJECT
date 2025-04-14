<?php

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;


include 'asset/db_connection.php'; // Database connection

if (isset($_GET['order_id'])) {
    echo "Order ID Received: " . htmlspecialchars($_GET['order_id']);
} else {
    echo "No Order ID Found!";
}


if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    echo "Order ID Received: " . $order_id . "<br>"; // Debugging line


    // Fetch order details from database
    $sql = "SELECT * FROM orders WHERE id = $order_id";
    $result = mysqli_query($conn, $sql);
    $order = mysqli_fetch_assoc($result);

    if ($order) {
        // Company details
        $company_name = "RentWear";
        $gst_number = "GSTIN: 22ABCDE1234F1Z5";
        $store_contact = "+91 98765 43210";
        $store_address = "Shop No. 12, Fashion Street, Mumbai, India";
        $shopkeeper_name = "Mr. Rajesh Sharma";

        // Enhanced HTML design
        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Invoice</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; padding: 0; background: #f9f9f9; }
                .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
                .header { text-align: center; margin-bottom: 20px; }
                .header h1 { font-size: 24px; margin: 0; color: #333; }
                .header p { margin: 5px 0; color: #555; }
                .divider { border-bottom: 2px solid #ddd; margin: 15px 0; }
                .section { margin-bottom: 20px; }
                .section h3 { font-size: 18px; border-bottom: 2px solid #ddd; padding-bottom: 5px; margin-bottom: 10px; color: #444; }
                .details p { margin: 5px 0; font-size: 14px; }
                .table-container { width: 100%; margin-top: 10px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; }
                th { background: #f4f4f4; color: #333; }
                .total { text-align: right; font-weight: bold; }
                .footer { text-align: center; margin-top: 20px; font-size: 14px; color: #777; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>'.$company_name.'</h1>
                    <p>'.$store_address.'</p>
                    <p>Contact: '.$store_contact.'</p>
                    <p>'.$gst_number.'</p>
                    <p>Shopkeeper: '.$shopkeeper_name.'</p>
                </div>

                <div class="divider"></div>

                <div class="section">
                    <h3>Order Invoice</h3>
                    <div class="details">
                        <p><strong>Customer Name:</strong> '.$order['customer_name'].'</p>
                        <p><strong>Email:</strong> '.$order['email'].'</p>
                        <p><strong>Phone:</strong> '.$order['phone'].'</p>
                        <p><strong>Order ID:</strong> '.$order['id'].'</p>
                        <p><strong>Order Date:</strong> '.$order['order_date'].'</p>
                        <p><strong>Return Date:</strong> '.$order['return_date'].'</p>
                    </div>
                </div>

                <div class="section">
                    <h3>Product Details</h3>
                    <table>
                        <tr>
                            <th>Product Name</th>
                            <th>Product ID</th>
                        </tr>
                        <tr>
                            <td>'.$order['product_name'].'</td>
                            <td>'.$order['product_id'].'</td>
                        </tr>
                    </table>
                </div>

                <div class="section">
                    <h3>Pricing Details</h3>
                    <table>
                        <tr>
                            <th>Description</th>
                            <th>Amount (INR)</th>
                        </tr>
                        <tr>
                            <td>Total Amount</td>
                            <td>₹'.number_format($order['total_amount'], 2).'</td>
                        </tr>
                        <tr>
                            <td>Deposit Paid</td>
                            <td>₹'.number_format($order['deposit_amount'], 2).'</td>
                        </tr>
                        <tr>
                            <td>Remaining Due</td>
                            <td>₹'.number_format($order['remaining_amount'], 2).'</td>
                        </tr>
                    </table>
                </div>

                <div class="footer">
                    <p>Thank you for choosing RentWear! Visit us again!</p>
                </div>
            </div>
        </body>
        </html>
        ';

        // Initialize DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Load HTML into DomPDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Stream PDF to Browser
        $file_name = 'invoice_' . preg_replace('/[^A-Za-z0-9]/', '_', $order['product_name']) . '_' . preg_replace('/[^A-Za-z0-9]/', '_', $order['customer_name']) . '.pdf';
        $dompdf->stream($file_name, ['Attachment' => 0]);
    } else {
        echo "Order not found!";
    }
} else {
    echo "Invalid request!";
}
?>