<?php
require 'asset/db_connection.php';
require __DIR__ . '/../libs/fpdf.php'; // if using fpdf
require __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../libs/PHPMailer/src/SMTP.php';
require __DIR__ . '/../libs/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$order_id = $_GET['order_id'] ?? null;
if (!$order_id) {
    die("Order ID is missing.");
}

// Fetch order details
$orderQuery = "SELECT * FROM orders WHERE id = $order_id";
$orderResult = mysqli_query($conn, $orderQuery);
$order = mysqli_fetch_assoc($orderResult);

if (!$order) {
    die("Order not found.");
}

// PDF generation
// PDF generation
$pdf = new FPDF();
$pdf->AddPage();

// --- Shop Details ---
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Wedding Clothes Rental Shop', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 6, 'Shop Address: 123 Main Road, Rajkot, Gujarat', 0, 1, 'C');
$pdf->Cell(0, 6, 'Phone: +91 98765 43210 | Email: yashkacha213@gmail.com', 0, 1, 'C');
$pdf->Ln(10);

// --- Title ---
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Rental Order Bill', 0, 1, 'C');
$pdf->Ln(5);

// --- Order & Customer Details ---
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(0, 10, 'Customer & Order Details', 1, 1, 'L', true);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(60, 10, 'Order ID:', 1);
$pdf->Cell(130, 10, $order['id'], 1, 1);

$pdf->Cell(60, 10, 'Customer Name:', 1);
$pdf->Cell(130, 10, $order['customer_name'], 1, 1);

$pdf->Cell(60, 10, 'Email:', 1);
$pdf->Cell(130, 10, $order['email'], 1, 1);

$pdf->Ln(5);

// --- Product Details ---
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Product Details', 1, 1, 'L', true);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(60, 10, 'Product Name:', 1);
$pdf->Cell(130, 10, $order['product_name'], 1, 1);

$pdf->Ln(5);

// --- Billing Breakdown ---
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Billing Breakdown', 1, 1, 'L', true);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(60, 10, 'Total Amount:', 1);
$pdf->Cell(130, 10, '₹' . number_format($order['total_amount'], 2), 1, 1);

$pdf->Cell(60, 10, 'Advance / Deposit Paid:', 1);
$pdf->Cell(130, 10, '₹' . number_format($order['deposit_amount'], 2), 1, 1);

$pdf->Cell(60, 10, 'Remaining Amount:', 1);
$pdf->Cell(130, 10, '₹' . number_format($order['remaining_amount'], 2), 1, 1);

$pdf->Ln(10);

// --- Footer ---
$pdf->SetFont('Arial', 'I', 11);
$pdf->Cell(0, 8, 'Thank you for renting with us!', 0, 1, 'C');
$pdf->Cell(0, 8, 'Please clear the remaining payment before pickup.', 0, 1, 'C');
$pdf->Cell(0, 8, 'For any issues, contact us anytime.', 0, 1, 'C');

$pdfFilePath = "bills/order_bill_" . $order['id'] . ".pdf";
$pdf->Output('F', $pdfFilePath);


// Send email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'yashkacha213@gmail.com'; // your email
    $mail->Password = 'qcws jlko jgjn rvid';     // your App password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('yashkacha213@gmail.com', 'Wedding Rentals');
    $mail->addAddress($order['email'], $order['customer_name']);
    $mail->Subject = 'Your Wedding Rental Order Bill';
    $mail->Body = "Hi " . $order['customer_name'] . ",\n\nPlease find attached your rental order bill.\n\nThank you!";
    $mail->addAttachment($pdfFilePath);

    $mail->send();
} catch (Exception $e) {
    error_log("Email could not be sent. Error: {$mail->ErrorInfo}");
    // Still proceed to download
}

// Force download after sending email
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($pdfFilePath) . '"');
readfile($pdfFilePath);
exit;
?>
