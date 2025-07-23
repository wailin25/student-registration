<?php
require 'includes/db.php';
require 'includes/header.php';
require 'includes/student_navbar.php';

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serial_no = $_POST['serial_no'];
    $pay_method = $_POST['pay_method'];
    $amount = $_POST['amount'];
    $pay_date = $_POST['pay_date'];

    if (isset($_FILES['pay_slip']) && $_FILES['pay_slip']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/payments/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmp = $_FILES['pay_slip']['tmp_name'];
        $fileName = basename($_FILES['pay_slip']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'pdf'];

        if (!in_array($fileExt, $allowedExt)) {
            $error = "Invalid file type. Only JPG, PNG, and PDF are allowed.";
        } else {
            $newFileName = uniqid('slip_') . '.' . $fileExt;
            $targetPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $targetPath)) {
                $stmt = $mysqli->prepare("INSERT INTO payment (serial_no, pay_method, amount, pay_date, pay_status, pay_slip_path) VALUES (?, ?, ?, ?, 'pending', ?)");
                $stmt->bind_param("ssdss", $serial_no, $pay_method, $amount, $pay_date, $targetPath);

                if ($stmt->execute()) {
                    $success = "✅ Payment submitted successfully. Please wait for admin approval.";
                } else {
                    $error = "❌ Database error: " . $mysqli->error;
                }
            } else {
                $error = "❌ Failed to move uploaded file.";
            }
        }
    } else {
        $error = "❌ Please upload a valid payment slip.";
    }
}
?>
<style>/* student_navbar.php ထဲ style များ (သို့) main CSS file ထဲ */
nav.navbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background-color: #fff; /* လိုအပ်လျှင် ပြောင်းနိုင် */
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Payment Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --light-bg: #f8f9fa;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .payment-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .payment-card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 1.5rem;
            border-bottom: none;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }
        
        .input-icon input, .input-icon select {
            padding-left: 40px;
        }
        
        .file-upload {
            position: relative;
            overflow: hidden;
        }
        
        .file-upload input[type="file"] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
        
        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 15px;
            background-color: #fff;
            border: 1px dashed #ccc;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-label:hover {
            border-color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .file-name {
            margin-left: 10px;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="payment-card">
                    <div class="card-header text-white text-center">
                        <h3 class="mb-0"><i class="bi bi-credit-card-2-front-fill me-2"></i>Payment Submission</h3>
                        <p class="mb-0 opacity-75">Upload your payment details and receipt</p>
                    </div>
                    <div class="card-body p-4" style="background-color: #fff;">
                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div><?= $success ?></div>
                            </div>
                        <?php elseif (!empty($error)): ?>
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div><?= $error ?></div>
                            </div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <div class="mb-4 input-icon">
                                <label for="serial_no" class="form-label"><i class="bi bi-person-vcard me-2"></i>Student Serial Number</label>
                                <i class="bi bi-123"></i>
                                <input type="text" id="serial_no" name="serial_no" class="form-control" placeholder="e.g. STU-2023-001" required>
                                <div class="invalid-feedback">
                                    Please provide your serial number.
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6 input-icon">
                                    <label for="pay_method" class="form-label"><i class="bi bi-wallet2 me-2"></i>Payment Method</label>
                                    <i class="bi bi-credit-card"></i>
                                    <select id="pay_method" name="pay_method" class="form-select" required>
                                        <option value="" selected disabled>Select method</option>
                                        <option value="KBZPay">KBZPay</option>
                                        <option value="QuickPay">QuickPay</option>
                                        <option value="WavePay">WavePay</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a payment method.
                                    </div>
                                </div>
                                <div class="col-md-6 input-icon">
                                    <label for="amount" class="form-label"><i class="bi bi-currency-exchange me-2"></i>Amount (MMK)</label>
                                    <i class="bi bi-cash-stack"></i>
                                    <input type="number" id="amount" name="amount" class="form-control" placeholder="e.g. 50000" required>
                                    <div class="invalid-feedback">
                                        Please enter the payment amount.
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="pay_date" class="form-label"><i class="bi bi-calendar-date me-2"></i>Payment Date</label>
                                    <input type="date" id="pay_date" name="pay_date" class="form-control" required>
                                    <div class="invalid-feedback">
                                        Please select the payment date.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="pay_slip" class="form-label"><i class="bi bi-file-earmark-arrow-up me-2"></i>Payment Receipt</label>
                                    <div class="file-upload">
                                        <label class="file-upload-label" for="pay_slip">
                                            <span class="file-name">Choose file (JPG, PNG, PDF)</span>
                                            <i class="bi bi-cloud-arrow-up"></i>
                                        </label>
                                        <input type="file" id="pay_slip" name="pay_slip" class="form-control d-none" accept=".jpg,.jpeg,.png,.pdf" required>
                                    </div>
                                    <small class="text-muted">Max file size: 5MB</small>
                                    <div class="invalid-feedback">
                                        Please upload your payment receipt.
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-submit">
                                    <i class="bi bi-send-check-fill me-2"></i>Submit Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="mt-4 text-center">
                    <p class="text-muted">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Your payment will be verified within 24-48 hours. You'll receive a notification once approved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // File upload name display
        document.getElementById('pay_slip').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file (JPG, PNG, PDF)';
            document.querySelector('.file-name').textContent = fileName;
        });
        
        // Form validation
        (function () {
            'use strict'
            
            var forms = document.querySelectorAll('.needs-validation')
            
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>

<?php require 'includes/footer.php'; ?>