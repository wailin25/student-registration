<?php
// payment.php
require 'includes/db.php';
require 'includes/header.php';
require 'includes/student_navbar.php';

session_start();

// Check if student data exists in session


$studentData = $_SESSION['student_data'];
$error = '';
$success = '';

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $serial_no = $studentData['serial_no'];
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

        if (in_array($fileExt, $allowedExt)) {
            $newFileName = uniqid('slip_') . '.' . $fileExt;
            $targetPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmp, $targetPath)) {
                // Insert into payment table
                $stmt = $mysqli->prepare("INSERT INTO payment (serial_no, pay_method, amount, pay_date, pay_status, pay_slip_path) VALUES (?, ?, ?, ?, 'pending', ?)");
                $stmt->bind_param("ssdss", $serial_no, $pay_method, $amount, $pay_date, $targetPath);

                if ($stmt->execute()) {
                    // Insert into registration table
                    $regStmt = $mysqli->prepare("INSERT INTO registration (serial_no, reg_date, status) VALUES (?, CURDATE(), 'pending')");
                    $regStmt->bind_param("s", $serial_no);
                    $regStmt->execute();
                    $regStmt->close();

                    // Insert student data
                    $studentStmt = $mysqli->prepare("INSERT INTO students (
                        serial_no, academic_year_start, academic_year_end, class, specialization, 
                        entry_year, student_name_mm, student_name_en, gender, dob, birth_place, 
                        entrance_exam_seat_number, entrance_exam_year, entrance_exam_center, 
                        nrc, citizen_status, nationality, religion, address_house_no, address_street, 
                        address_quarter, address_village, address_township, address_region, 
                        father_name_mm, father_name_en, father_nationality, father_religion, 
                        father_nrc, father_birth_place, father_citizen_status, father_phone, 
                        father_job, father_address_house_no, father_address_street, 
                        father_address_quarter, father_address_village, father_address_township, 
                        father_address_region, mother_name_mm, mother_name_en, mother_nationality, 
                        mother_religion, mother_nrc, mother_birth_place, mother_citizen_status, 
                        mother_phone, mother_job, mother_address_house_no, mother_address_street, 
                        mother_address_quarter, mother_address_village, mother_address_township, 
                        mother_address_region, phone, supporter_name, supporter_relation, 
                        supporter_job, supporter_address, supporter_phone, grant_support, 
                        signature_status, current_home_no, current_street, current_quarter, 
                        current_village, current_township, current_phone, current_year, 
                        current_month, current_day, image_path
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                    // Bind all parameters
                    $studentStmt->bind_param(
                        "isssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
                        $studentData['serial_no'],
                        $studentData['academic_year_start'],
                        $studentData['academic_year_end'],
                        $studentData['class'],
                        $studentData['specialization'],
                        $studentData['entry_year'],
                        $studentData['student_name_mm'],
                        $studentData['student_name_en'],
                        $studentData['gender'],
                        $studentData['dob'],
                        $studentData['birth_place'],
                        $studentData['entrance_exam_seat_number'],
                        $studentData['entrance_exam_year'],
                        $studentData['entrance_exam_center'],
                        $studentData['nrc'],
                        $studentData['citizen_status'],
                        $studentData['nationality'],
                        $studentData['religion'],
                        $studentData['address_house_no'],
                        $studentData['address_street'],
                        $studentData['address_quarter'],
                        $studentData['address_village'],
                        $studentData['address_township'],
                        $studentData['address_region'],
                        $studentData['father_name_mm'],
                        $studentData['father_name_en'],
                        $studentData['father_nationality'],
                        $studentData['father_religion'],
                        $studentData['father_nrc'],
                        $studentData['father_birth_place'],
                        $studentData['father_citizen_status'],
                        $studentData['father_phone'],
                        $studentData['father_job'],
                        $studentData['father_address_house_no'],
                        $studentData['father_address_street'],
                        $studentData['father_address_quarter'],
                        $studentData['father_address_village'],
                        $studentData['father_address_township'],
                        $studentData['father_address_region'],
                        $studentData['mother_name_mm'],
                        $studentData['mother_name_en'],
                        $studentData['mother_nationality'],
                        $studentData['mother_religion'],
                        $studentData['mother_nrc'],
                        $studentData['mother_birth_place'],
                        $studentData['mother_citizen_status'],
                        $studentData['mother_phone'],
                        $studentData['mother_job'],
                        $studentData['mother_address_house_no'],
                        $studentData['mother_address_street'],
                        $studentData['mother_address_quarter'],
                        $studentData['mother_address_village'],
                        $studentData['mother_address_township'],
                        $studentData['mother_address_region'],
                        $studentData['phone'],
                        $studentData['supporter_name'],
                        $studentData['supporter_relation'],
                        $studentData['supporter_job'],
                        $studentData['supporter_address'],
                        $studentData['supporter_phone'],
                        $studentData['grant_support'],
                        $studentData['signature_status'],
                        $studentData['current_home_no'],
                        $studentData['current_street'],
                        $studentData['current_quarter'],
                        $studentData['current_village'],
                        $studentData['current_township'],
                        $studentData['current_phone'],
                        $studentData['current_year'],
                        $studentData['current_month'],
                        $studentData['current_day'],
                        $studentData['image_path'] ?? null
                    );

                    if ($studentStmt->execute()) {
                        // Insert exam results
                        foreach ($_SESSION['exam_results'] as $exam) {
                            $examStmt = $mysqli->prepare("INSERT INTO answered_exam (exam_id, serial_no, pass_class, pass_specialization, pass_serial_no, pass_fail_status, pass_year) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
                            $examStmt->bind_param("ssssss", $serial_no, $exam['pass_class'], $exam['pass_specialization'], $exam['pass_serial_no'], $exam['pass_fail_status'], $exam['pass_year']);
                            $examStmt->execute();
                            $examStmt->close();
                        }

                        $success = "✅ Registration and payment submitted successfully! Your registration will be processed after payment verification.";
                        unset($_SESSION['student_data']);
                        unset($_SESSION['exam_results']);
                    } else {
                        $error = "❌ Error saving student data: " . $mysqli->error;
                    }
                    $studentStmt->close();
                } else {
                    $error = "❌ Error saving payment: " . $mysqli->error;
                }
                $stmt->close();
            } else {
                $error = "❌ Failed to move uploaded file.";
            }
        } else {
            $error = "❌ Invalid file type. Only JPG, PNG, and PDF are allowed.";
        }
    } else {
        $error = "❌ Please upload a valid payment slip.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Submission</title>
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
        
        .student-info {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .student-info h5 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
            width: 150px;
        }
        
        .info-value {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><?= $success ?></div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="student_dashboard.php" class="btn btn-primary">Return to Dashboard</a>
                    </div>
                <?php else: ?>
                    <div class="student-info">
                        <h5><i class="bi bi-person-badge me-2"></i>Student Information</h5>
                        <div class="info-row">
                            <div class="info-label">Serial No:</div>
                            <div class="info-value"><?= htmlspecialchars($studentData['serial_no']) ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Name:</div>
                            <div class="info-value"><?= htmlspecialchars($studentData['student_name_en']) ?> (<?= htmlspecialchars($studentData['student_name_mm']) ?>)</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Class:</div>
                            <div class="info-value"><?= htmlspecialchars($studentData['class']) ?> - <?= htmlspecialchars($studentData['specialization']) ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Academic Year:</div>
                            <div class="info-value"><?= htmlspecialchars($studentData['academic_year_start']) ?>-<?= htmlspecialchars($studentData['academic_year_end']) ?></div>
                        </div>
                    </div>
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?= $error ?></div>
                        </div>
                    <?php endif; ?>

                    <div class="payment-card">
                        <div class="card-header text-white text-center">
                            <h3 class="mb-0"><i class="bi bi-credit-card-2-front-fill me-2"></i>Payment Submission</h3>
                            <p class="mb-0 opacity-75">Complete your registration by making payment</p>
                        </div>
                        <div class="card-body p-4" style="background-color: #fff;">
                            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <div class="mb-4 input-icon">
                                    <label for="pay_method" class="form-label"><i class="bi bi-wallet2 me-2"></i>Payment Method</label>
                                    <i class="bi bi-credit-card"></i>
                                    <select id="pay_method" name="pay_method" class="form-select" required>
                                        <option value="" selected disabled>Select method</option>
                                        <option value="KBZPay">KBZPay</option>
                                        <option value="QuickPay">QuickPay</option>
                                        <option value="WavePay">WavePay</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Cash">Cash</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a payment method.
                                    </div>
                                </div>

                                <div class="row g-3 mb-4">
                                    <div class="col-md-6 input-icon">
                                        <label for="amount" class="form-label"><i class="bi bi-currency-exchange me-2"></i>Amount (MMK)</label>
                                        <i class="bi bi-cash-stack"></i>
                                        <input type="number" id="amount" name="amount" class="form-control" placeholder="e.g. 50000" required>
                                        <div class="invalid-feedback">
                                            Please enter the payment amount.
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="pay_date" class="form-label"><i class="bi bi-calendar-date me-2"></i>Payment Date</label>
                                        <input type="date" id="pay_date" name="pay_date" class="form-control" required>
                                        <div class="invalid-feedback">
                                            Please select the payment date.
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
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

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-submit">
                                        <i class="bi bi-send-check-fill me-2"></i>Submit Payment & Complete Registration
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <p class="text-muted">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Your registration will be complete after payment verification (24-48 hours).
                        </p>
                    </div>
                <?php endif; ?>
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