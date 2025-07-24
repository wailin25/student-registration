<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/db.php';
require 'includes/student_navbar.php';
require 'includes/header.php';
$studentData = null;
$examData = null;

// Check if form is submitted or serial number is entered
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['serial_no'])) {
    // Get serial number from form
    $serialNo = trim($_POST['serial_no']);
    
    // Debug output
    echo "<script>console.log('Searching for student with serial no:', '" . addslashes($serialNo) . "');</script>";
    
    // Fetch student data from database
    $stmt = $mysqli->prepare("SELECT * FROM students WHERE serial_no = ?");
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }
    
    $stmt->bind_param("i", $serialNo);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $studentData = $result->fetch_assoc();
        echo "<script>console.log('Student data found:', " . json_encode($studentData) . ");</script>";
        
        // Fetch exam data
        $examStmt = $mysqli->prepare("SELECT * FROM answered_exam WHERE serial_no = ?");
        $examStmt->bind_param("i", $studentData['serial_no']);
        if (!$examStmt->execute()) {
            die("Exam query failed: " . $examStmt->error);
        }
        $examResult = $examStmt->get_result();
        
        if ($examResult->num_rows > 0) {
            $examData = $examResult->fetch_assoc();
            echo "<script>console.log('Exam data found:', " . json_encode($examData) . ");</script>";
        }
    } else {
        echo "<script>alert('ကျေးဇူးပြု၍ မှန်ကန်သောခုံအမှတ်ထည့်ပါ');</script>";
    }
    
    $stmt->close();
}

$mysqli->close();

// Function to convert numbers to Myanmar digits
function convertToMyanmarDigits($number) {
    $myanmarDigits = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
    $result = '';
    $digits = str_split((string)$number);
    foreach ($digits as $digit) {
        if (is_numeric($digit)) {
            $result .= $myanmarDigits[$digit];
        }
    }
    return $result;
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
    <title>UCS(MGY) Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
 <div class="container form-container">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form id="studentForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="form_submitted" value="1">
            
            <div class="form-header text-center mb-4">
                <img src="image/ucsmgy.png" alt="တက္ကသိုလ်လိုဂို" class="university-logo" style="height: 80px;">
                <h5>ကွန်ပျူတာတက္ကသိုလ် (မကွေး)</h5>
                <span>(</span>
                <input type="text" name="academic_year_start" class="year-input" maxlength="4" value="<?php echo isset($studentData['academic_year_start']) ? $studentData['academic_year_start'] : '၂၀၂၄'; ?>" oninput="allowOnlyMyanmarDigits(this)">
                <span>-</span>
                <input type="text" name="academic_year_end" class="year-input" maxlength="4" value="<?php echo isset($studentData['academic_year_end']) ? $studentData['academic_year_end'] : '၂၀၂၅'; ?>" oninput="allowOnlyMyanmarDigits(this)">
                <span>) ပညာသင်နှစ်</span>
                <h5>ကျောင်းသား/ကျောင်းသူများ ပညာသင်ခွင့်လျှောက်လွှာ</h5>
            </div>

            <!-- Progress indicator -->
            <div class="progress-container mb-4">
                <div class="progress mb-2">
                    <div class="progress-bar" role="progressbar" id="formProgress" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress-text text-center" id="progressText">စာမျက်နှာ 1/2</div>
            </div>

            <!-- Page 1: Student Information -->
            <div class="form-section active" id="page1">
                <table class="main-table">
                    <tr>
                        <td class="photo-cell" rowspan="5" style="width: 160px; vertical-align: top;">
                            <label for="fileupload" class="d-block">
                                <div class="image-preview-container mb-2">
                                    <?php if (isset($studentData['image']) && !empty($studentData['image'])): ?>
                                        <img id="preview" src="<?php echo $studentData['image']; ?>" class="image-preview" alt="Student Photo">
                                    <?php else: ?>
                                        <img id="preview" src="data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='180' viewBox='0 0 150 180'%3E%3Crect fill='%23ddd' width='150' height='180'/%3E%3Ctext fill='%23666' font-family='sans-serif' font-size='14' x='50%' y='50%' text-anchor='middle' dominant-baseline='middle'%3EStudent Photo%3C/text%3E%3C/svg%3E" class="image-preview" alt="Student Photo">
                                    <?php endif; ?>
                                </div>
                                <input class="form-control form-control-sm" type="file" id="fileupload" name="image" onchange="previewImage(this)">
                            </label>
                        </td>
                        <td>သင်တန်းနှစ်</td>
                        <td>
                            <select name="class" class="form-control" required>
                                <option value="">--ရွေးပါ--</option>
                                <option value="ပထမနှစ်" <?php echo (isset($studentData['class']) && $studentData['class'] == 'ပထမနှစ်') ? 'selected' : ''; ?>>ပထမနှစ်</option>
                                <option value="ဒုတိယနှစ်" <?php echo (isset($studentData['class']) && $studentData['class'] == 'ဒုတိယနှစ်') ? 'selected' : ''; ?>>ဒုတိယနှစ်</option>
                                <option value="တတိယနှစ်(Jr.)" <?php echo (isset($studentData['class']) && $studentData['class'] == 'တတိယနှစ်(Jr.)') ? 'selected' : ''; ?>>တတိယနှစ်(Jr.)</option>
                                <option value="တတိယနှစ်(Sr.)" <?php echo (isset($studentData['class']) && $studentData['class'] == 'တတိယနှစ်(Sr.)') ? 'selected' : ''; ?>>တတိယနှစ်(Sr.)</option>
                                <option value="စတုတ္ထနှစ်" <?php echo (isset($studentData['class']) && $studentData['class'] == 'စတုတ္ထနှစ်') ? 'selected' : ''; ?>>စတုတ္ထနှစ်</option>
                                <option value="ပဉ္စမနှစ်" <?php echo (isset($studentData['class']) && $studentData['class'] == 'ပဉ္စမနှစ်') ? 'selected' : ''; ?>>ပဉ္စမနှစ်</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>အထူးပြုဘာသာ</td>
                        <td>
                            <select name="specialization" class="form-control" required>
                                <option value="">--ရွေးပါ--</option>
                                <option value="CST" <?php echo (isset($studentData['specialization']) && $studentData['specialization'] == 'CST') ? 'selected' : ''; ?>>CST</option>
                                <option value="CS" <?php echo (isset($studentData['specialization']) && $studentData['specialization'] == 'CS') ? 'selected' : ''; ?>>CS</option>
                                <option value="CT" <?php echo (isset($studentData['specialization']) && $studentData['specialization'] == 'CT') ? 'selected' : ''; ?>>CT</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                    <td>ခုံအမှတ်</td>
                    <td style="display: flex; gap: 5px; align-items: center;">
                        <input type="text" name="serial_code" value="UCSMG-" readonly style="flex: 0 0 80px; background-color: #f1f1f1; border: 1px solid #ccc; text-align: center;">
                        <input type="text" name="serial_no" id="serial_no" pattern="\d{5}" maxlength="5" placeholder="e.g., 24001" 
                            value="<?php echo isset($studentData['serial_no']) ? $studentData['serial_no'] : ''; ?>" 
                            class="form-control" onchange="fetchStudentData(this.value)" <?php echo isset($_GET['serial_no']) ? 'readonly' : 'required'; ?>>
                    </td>
                </tr>
                    <tr>
                        <td>တက္ကသိုလ်ဝင်ရောက်သည့်ခုနှစ်</td>
                        <td>
                            <input type="text" name="entry_year" pattern="20\d{2}" maxlength="4" value="<?php echo isset($studentData['entry_year']) ? $studentData['entry_year'] : ''; ?>" placeholder="ဥပမာ - 2024" class="form-control" required>
                        </td>      
                    </tr>
                </table>
                
                <!-- Personal Information Table -->
                <table class="main-table">
                    <tr>
                        <td colspan="2"><label class="required">၁။ ပညာဆက်လက်သင်ခွင့်တောင်းသူ</label></td>
                        <td><label>ကျောင်းသား/ကျောင်းသူ</label></td>
                        <td style="width:190px;text-align:center;"><label>အဘ</label></td>
                        <td style="width:190px;text-align:center;"><label>အမိ</label></td>
                    </tr>
                    <tr>
                        <td rowspan="2"><label class="required">အမည်</label></td>
                        <td><label>မြန်မာစာဖြင့်</label></td>
                        <td><input type="text" name="student_name_my" value="<?php echo isset($studentData['student_name_my']) ? $studentData['student_name_my'] : ''; ?>" placeholder="မောင်ကျော်ကျော် / မလှလှ" class="form-control" required></td>
                        <td><input type="text" name="father_name_my" value="<?php echo isset($studentData['father_name_my']) ? $studentData['father_name_my'] : ''; ?>" placeholder="ဦးမောင်မောင်" class="form-control" required></td>
                        <td><input type="text" name="mother_name_my" value="<?php echo isset($studentData['mother_name_my']) ? $studentData['mother_name_my'] : ''; ?>" placeholder="ဒေါ်အေးအေး" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td><label>အင်္ဂလိပ်စာဖြင့်</label></td>
                        <td><input type="text" name="student_name_en" value="<?php echo isset($studentData['student_name_en']) ? $studentData['student_name_en'] : ''; ?>" placeholder="Mg Kyaw Kyaw / Ma Hla Hla" class="form-control" required></td>
                        <td><input type="text" name="father_name_en" value="<?php echo isset($studentData['father_name_en']) ? $studentData['father_name_en'] : ''; ?>" placeholder="U Maung Maung" class="form-control" required></td>
                        <td><input type="text" name="mother_name_en" value="<?php echo isset($studentData['mother_name_en']) ? $studentData['mother_name_en'] : ''; ?>" placeholder="Daw Aye Aye" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label class="required">လူမျိုး</label></td>
                        <td><input type="text" name="nationality" value="<?php echo isset($studentData['nationality']) ? $studentData['nationality'] : ''; ?>" class="form-control" required></td>
                        <td><input type="text" name="father_ethnicity" value="<?php echo isset($studentData['father_ethnicity']) ? $studentData['father_ethnicity'] : ''; ?>" class="form-control" required></td>
                        <td><input type="text" name="mother_ethnicity" value="<?php echo isset($studentData['mother_ethnicity']) ? $studentData['mother_ethnicity'] : ''; ?>" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label class="required">ကိုးကွယ်သည့်ဘာသာ</label></td>
                        <td><input type="text" name="religion" value="<?php echo isset($studentData['religion']) ? $studentData['religion'] : ''; ?>" class="form-control" required></td>
                        <td><input type="text" name="father_religion" value="<?php echo isset($studentData['father_religion']) ? $studentData['father_religion'] : ''; ?>" class="form-control" required></td>
                        <td><input type="text" name="mother_religion" value="<?php echo isset($studentData['mother_religion']) ? $studentData['mother_religion'] : ''; ?>" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label class="required">မွေးဖွားရာဇာတိ</label></td>
                        <td><input type="text" name="birth_place" value="<?php echo isset($studentData['birth_place']) ? $studentData['birth_place'] : ''; ?>" class="form-control" required></td>
                        <td><input type="text" name="father_birth_place" value="<?php echo isset($studentData['father_birth_place']) ? $studentData['father_birth_place'] : ''; ?>" class="form-control" required></td>
                        <td><input type="text" name="mother_birth_place" value="<?php echo isset($studentData['mother_birth_place']) ? $studentData['mother_birth_place'] : ''; ?>" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label class="required">မြို့နယ်/ပြည်နယ်/တိုင်း</label></td>
                        <td>
                            <input type="text" name="address_township" value="<?php echo isset($studentData['address_township']) ? $studentData['address_township'] : ''; ?>" class="form-control" placeholder="မြို့နယ်" required>
                            <input type="text" name="address_region" value="<?php echo isset($studentData['address_region']) ? $studentData['address_region'] : ''; ?>" class="form-control mt-1" placeholder="ပြည်နယ်/တိုင်း" required>
                        </td>
                        <td>
                            <input type="text" name="father_township" value="<?php echo isset($studentData['father_address_township']) ? $studentData['father_address_township'] : ''; ?>" class="form-control" placeholder="မြို့နယ်" required>
                            <input type="text" name="father_region" value="<?php echo isset($studentData['father_region']) ? $studentData['father_region'] : ''; ?>" class="form-control mt-1" placeholder="ပြည်နယ်/တိုင်း" required>
                        </td>
                        <td>
                            <input type="text" name="mother_township" value="<?php echo isset($studentData['mother_address_township']) ? $studentData['mother_address_township'] : ''; ?>" class="form-control" placeholder="မြို့နယ်" required>
                            <input type="text" name="mother_region" value="<?php echo isset($studentData['mother_region']) ? $studentData['mother_region'] : ''; ?>" class="form-control mt-1" placeholder="ပြည်နယ်/တိုင်း" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><label class="required">မှတ်ပုံတင်အမှတ်</label></td>
                        <td><input type="text" name="nrc" value="<?php echo isset($studentData['nrc']) ? $studentData['nrc'] : ''; ?>" class="form-control" required></td>
                        <td><input type="text" name="father_nrc" value="<?php echo isset($studentData['father_nrc']) ? $studentData['father_nrc'] : ''; ?>" class="form-control" required></td>
                        <td><input type="text" name="mother_nrc" value="<?php echo isset($studentData['mother_nrc']) ? $studentData['mother_nrc'] : ''; ?>" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label class="required">နိုင်ငံခြားသား</label></td>
                        <td>
                            <select name="citizen_status" class="form-select form-select-sm" required>
                                <option value="">တိုင်းရင်းသား/နိုင်ငံခြားသား</option>
                                <option value="1" <?php echo (isset($studentData['citizen_status']) && $studentData['citizen_status'] == '1') ? 'selected' : ''; ?>>တိုင်းရင်းသား</option>
                                <option value="0" <?php echo (isset($studentData['citizen_status']) && $studentData['citizen_status'] == '0') ? 'selected' : ''; ?>>နိုင်ငံခြားသား</option>
                            </select>
                        </td>
                        <td>
                            <select name="father_citizen_status" class="form-select form-select-sm" required>
                                <option value="">တိုင်းရင်းသား/နိုင်ငံခြားသား</option>
                                <option value="1" <?php echo (isset($studentData['father_citizen_status']) && $studentData['father_citizen_status'] == '1') ? 'selected' : ''; ?>>တိုင်းရင်းသား</option>
                                <option value="0" <?php echo (isset($studentData['father_citizen_status']) && $studentData['father_citizen_status'] == '0') ? 'selected' : ''; ?>>နိုင်ငံခြားသား</option>
                            </select>
                        </td>
                        <td>
                            <select name="mother_citizen_status" class="form-select form-select-sm" required>
                                <option value="">တိုင်းရင်းသား/နိုင်ငံခြားသား</option>
                                <option value="1" <?php echo (isset($studentData['mother_citizen_status']) && $studentData['mother_citizen_status'] == '1') ? 'selected' : ''; ?>>တိုင်းရင်းသား</option>
                                <option value="0" <?php echo (isset($studentData['mother_citizen_status']) && $studentData['mother_citizen_status'] == '0') ? 'selected' : ''; ?>>နိုင်ငံခြားသား</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><label class="required">မွေးသက္ကရာဇ်</label></td>
                        <td><input type="date" name="dob" value="<?php echo isset($studentData['dob']) ? $studentData['dob'] : ''; ?>" class="form-control" required></td>
                        <td colspan="2">အဘအုပ်ထိန်းသူ၏ အလုပ်အကိုင်၊ရာထူး၊ဌာန၊လိပ်စာအပြည့်အစုံ</td>
                    </tr>
                    <tr>
                        <td rowspan="3">တက္ကသိုလ်ဝင်တန်းစာမေးပွဲအောင်မြင်သည့်</td>
                        <td>ခုံအမှတ် - </td>
                        <td><input type="text" name="entrance_exam_seat_number" value="<?php echo isset($studentData['entrance_exam_seat_number']) ? $studentData['entrance_exam_seat_number'] : ''; ?>" class="form-control" required></td>
                        <td class="text-center" colspan="2" rowspan="3" style="padding: 8px;">
                            <div class="container-fluid">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="father_address_home" value="<?php echo isset($studentData['father_address_home']) ? $studentData['father_address_home'] : ''; ?>" placeholder="အိမ်">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="father_address_quarter" value="<?php echo isset($studentData['father_address_quarter']) ? $studentData['father_address_quarter'] : ''; ?>" placeholder="ရပ်ကွက်">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="father_address_street" value="<?php echo isset($studentData['father_address_street']) ? $studentData['father_address_street'] : ''; ?>" placeholder="လမ်းအမှတ်">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="father_address_village" value="<?php echo isset($studentData['father_address_village']) ? $studentData['father_address_village'] : ''; ?>" placeholder="ကျေးရွာ">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="father_address_township" value="<?php echo isset($studentData['father_address_township']) ? $studentData['father_address_township'] : ''; ?>" placeholder="မြို့နယ်" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="father_phone" value="<?php echo isset($studentData['father_phone']) ? $studentData['father_phone'] : ''; ?>" placeholder="09-xxxxxxxxx" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="father_job" value="<?php echo isset($studentData['father_job']) ? $studentData['father_job'] : ''; ?>" placeholder="အလုပ်အကိုင်" required>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>ခုနှစ် - </td>
                        <td><input type="text" name="entrance_exam_year" value="<?php echo isset($studentData['entrance_exam_year']) ? $studentData['entrance_exam_year'] : ''; ?>" class="form-control" maxlength="4" required></td>
                    </tr>
                    <tr>
                        <td>စာစစ်ဌာန - </td>
                        <td><input type="text" name="entrance_exam_center" value="<?php echo isset($studentData['entrance_exam_center']) ? $studentData['entrance_exam_center'] : ''; ?>" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="center"><label class="required">အမြဲတမ်းနေထိုင်သည့်လိပ်စာ(အပြည့်အစုံ)</label></td>
                        <td colspan="2"><label class="required">အမိအုပ်ထိန်းသူ၏ အလုပ်အကိုင်၊ရာထူး၊ဌာန၊လိပ်စာအပြည့်အစုံ</label></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 8px;">
                            <div class="container-fluid">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="address_house_no" value="<?php echo isset($studentData['address_house_no']) ? $studentData['address_house_no'] : ''; ?>" placeholder="အိမ်အမှတ်">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="address_street" value="<?php echo isset($studentData['address_street']) ? $studentData['address_street'] : ''; ?>" placeholder="လမ်း" >
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="address_quarter" value="<?php echo isset($studentData['address_quarter']) ? $studentData['address_quarter'] : ''; ?>" placeholder="ရပ်ကွက်" >
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="address_village" value="<?php echo isset($studentData['address_village']) ? $studentData['address_village'] : ''; ?>" placeholder="ကျေးရွာ">
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="address_township" value="<?php echo isset($studentData['address_township']) ? $studentData['address_township'] : ''; ?>" placeholder="မြို့နယ်" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="phone" value="<?php echo isset($studentData['phone']) ? $studentData['phone'] : ''; ?>" placeholder="ဖုန်းနံပါတ်" required>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td colspan="2" style="padding: 8px;">
                            <div class="container-fluid">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="mother_address_house_no" value="<?php echo isset($studentData['mother_address_house_no']) ? $studentData['mother_address_house_no'] : ''; ?>" placeholder="အိမ်">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="mother_address_quarter" value="<?php echo isset($studentData['mother_address_quarter']) ? $studentData['mother_address_quarter'] : ''; ?>" placeholder="ရပ်ကွက်">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" name="mother_address_street" value="<?php echo isset($studentData['mother_address_street']) ? $studentData['mother_address_street'] : ''; ?>" placeholder="လမ်းအမှတ်" >
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="mother_address_village" value="<?php echo isset($studentData['mother_address_village']) ? $studentData['mother_address_village'] : ''; ?>" placeholder="ကျေးရွာ" >
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="mother_address_township" value="<?php echo isset($studentData['mother_address_township']) ? $studentData['mother_address_township'] : ''; ?>" placeholder="မြို့နယ်" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="mother_phone" value="<?php echo isset($studentData['mother_phone']) ? $studentData['mother_phone'] : ''; ?>" placeholder="09-xxxxxxxxx" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="mother_job" value="<?php echo isset($studentData['mother_job']) ? $studentData['mother_job'] : ''; ?>" placeholder="အလုပ်အကိုင်" required>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <table class="exam-table">
                    <tr>
                        <th>ဖြေဆိုခဲ့သည့်စာမေးပွဲများ</th>
                        <th>အဓိကဘာသာ</th>
                        <th>ခုံအမှတ်</th>
                        <th>ခုနှစ်</th>
                        <th>အောင်/ရှုံး</th>
                    </tr>
                    <?php 
                    // Initialize exam results array if not set
                    if (!isset($examResults)) {
                        $examResults = array_fill(0, 5, []);
                    }
                    
                    for ($i = 1; $i <= 5; $i++): 
                        $result = isset($examResults[$i-1]) ? $examResults[$i-1] : [];
                    ?>
                    <tr>
                        <td>
                            <select name="pass_class<?php echo $i; ?>" class="form-select form-select-sm">
                                <option value="">ရွေးချယ်ပါ</option>
                                <option value="ပထမနှစ်" <?php echo (isset($result['pass_class']) && $result['pass_class'] == 'ပထမနှစ်') ? 'selected' : ''; ?>>ပထမနှစ်</option>
                                <option value="ဒုတိယနှစ်" <?php echo (isset($result['pass_class']) && $result['pass_class'] == 'ဒုတိယနှစ်') ? 'selected' : ''; ?>>ဒုတိယနှစ်</option>
                                <option value="တတိယနှစ်(Jr.)" <?php echo (isset($result['pass_class']) && $result['pass_class'] == 'တတိယနှစ်(Jr.)') ? 'selected' : ''; ?>>တတိယနှစ်(Jr.)</option>
                                <option value="တတိယနှစ်(Sr.)" <?php echo (isset($result['pass_class']) && $result['pass_class'] == 'တတိယနှစ်(Sr.)') ? 'selected' : ''; ?>>တတိယနှစ်(Sr.)</option>
                                <option value="စတုတ္ထနှစ်" <?php echo (isset($result['pass_class']) && $result['pass_class'] == 'စတုတ္ထနှစ်') ? 'selected' : ''; ?>>စတုတ္ထနှစ်</option>
                                <option value="ပဉ္စမနှစ်" <?php echo (isset($result['pass_class']) && $result['pass_class'] == 'ပဉ္စမနှစ်') ? 'selected' : ''; ?>>ပဉ္စမနှစ်</option>
                            </select>
                        </td>
                        <td>
                            <select name="pass_specialization<?php echo $i; ?>" class="form-select form-select-sm">
                                <option value="">ရွေးချယ်ပါ</option>
                                <option value="CST" <?php echo (isset($result['pass_specialization']) && $result['pass_specialization'] == 'CST') ? 'selected' : ''; ?>>CST</option>
                                <option value="CS" <?php echo (isset($result['pass_specialization']) && $result['pass_specialization'] == 'CS') ? 'selected' : ''; ?>>CS</option>
                                <option value="CT" <?php echo (isset($result['pass_specialization']) && $result['pass_specialization'] == 'CT') ? 'selected' : ''; ?>>CT</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="pass_serial_no<?php echo $i; ?>" value="<?php echo isset($result['pass_serial_no']) ? $result['pass_serial_no'] : ''; ?>" class="form-control form-control-sm" style="max-width: 200px;">
                        </td>
                        <td>
                            <input type="text" name="pass_year<?php echo $i; ?>" value="<?php echo isset($result['pass_year']) ? $result['pass_year'] : ''; ?>" maxlength="4" class="form-control form-control-sm" style="max-width: 200px;">
                        </td>
                        <td>
                            <select name="pass_fail_status<?php echo $i; ?>" class="form-select form-select-sm">
                                <option value="">ရွေးချယ်ပါ</option>
                                <option value="အောင်" <?php echo (isset($result['pass_fail_status']) && $result['pass_fail_status'] == 'အောင်') ? 'selected' : ''; ?>>အောင်</option>
                                <option value="ရှုံး" <?php echo (isset($result['pass_fail_status']) && $result['pass_fail_status'] == 'ရှုံး') ? 'selected' : ''; ?>>ရှုံး</option>
                                <option value="ရပ်နား" <?php echo (isset($result['pass_fail_status']) && $result['pass_fail_status'] == 'ရပ်နား') ? 'selected' : ''; ?>>ရပ်နား</option>
                            </select>
                        </td>
                    </tr>
                    <?php endfor; ?>
                </table>
                
                <div class="navigation">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='student_dashboard.php'">
                        <i class="fas fa-arrow-left"></i> နောက်သို့
                    </button>
                    <button type="button" class="btn btn-primary" onclick="nextPage(1, 2)">
                        ရှေ့သို့ <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Page 2: Supporter Information -->
            <div class="form-section" id="page2">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="form-section-title">၃။ ကျောင်းနေရန်အထောက်အပံ့ပြုမည့်ပုဂ္ဂိုလ်</h5>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <td>(က) အမည်</td>
                                <td><input type="text" name="supporter_name" value="<?php echo isset($studentData['supporter_name']) ? $studentData['supporter_name'] : ''; ?>" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>(ခ) ဆွေမျိုးတော်စပ်ပုံ</td>
                                <td><input type="text" name="supporter_relation" value="<?php echo isset($studentData['supporter_relation']) ? $studentData['supporter_relation'] : ''; ?>" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>(ဂ) အလုပ်အကိုင်</td>
                                <td><input type="text" name="supporter_job" value="<?php echo isset($studentData['supporter_job']) ? $studentData['supporter_job'] : ''; ?>" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td>(ဃ) ဆက်သွယ်ရန်လိပ်စာ</td>
                                <td><input type="text" name="supporter_address" value="<?php echo isset($studentData['supporter_address']) ? $studentData['supporter_address'] : ''; ?>" class="form-control" placeholder="ကျေးရွာ/ရပ်ကွက်/မြို့" required></td>
                            </tr>
                            <tr>
                                <td>နှင့်ဖုန်းနံပါတ်</td>
                                <td><input type="text" name="supporter_phone" value="<?php echo isset($studentData['supporter_phone']) ? $studentData['supporter_phone'] : ''; ?>" class="form-control" placeholder="09-xxxxxxxxx" required></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5 class="form-section-title">၄။ ပညာသင်ထောက်ပံ့ကြေးပေးရန် ပြု/မပြု</h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="grant_support" id="support_yes" value="ပြု" <?php echo (isset($studentData['grant_support']) && $studentData['grant_support'] == 'ပြု') ? 'checked' : ''; ?> required>
                            <label class="form-check-label" for="support_yes">ပြု</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="grant_support" id="support_no" value="မပြု" <?php echo (isset($studentData['grant_support']) && $studentData['grant_support'] == 'မပြု') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="support_no">မပြု</label>
                        </div>
                    </div>
                </div>

                <h5 class="form-section-title text-center mt-4">ကိုယ်တိုင်ဝန်ခံချက်</h5>
                <div class="declaration">
                    <div class="declaration-item">၁။ အထက်ဖော်ပြပါအချက်အားလုံးမှန်ကန်ပါသည်။</div>
                    <div class="declaration-item">၂။ ဤတက္ကသိုလ်၌ ဆက်လက်ပညာသင်ခွင့်တောင်းသည်ကို မိဘ(သို့မဟုတ်)အုပ်ထိန်းသူက သဘောတူပြီးဖြစ်ပါသည်။</div>
                    <div class="declaration-item">၃။ ကျောင်းလခများမှန်မှန်ပေးရန် မိဘ(သို့မဟုတ်)အုပ်ထိန်းသူက သဘောတူပြီးဖြစ်ပါသည်။</div>
                    <div class="declaration-item">၄။ တက္ကသိုလ်ကျောင်းသားကောင်းတစ်ယောက်ပီသစွာ တက္ကသိုလ်ကချမှတ်သည့်စည်းမျဉ်းစည်းကမ်းနှင့်အညီ လိုက်နာကျင့်သုံးနေထိုင်ပါမည်။</div>
                    <div class="declaration-item">၅။ ကျွန်တော်/ကျွန်မသည် မည်သည့်နိုင်ငံရေးပါတီတွင်မျှပါဝင်မည်မဟုတ်ပါ။ မည်သည့်နိုင်ငံရေးလှုပ်ရှားမှုမျှ ပါဝင်မည်မဟုတ်ကြောင်း ဝန်ခံကတိပြုပါသည်။</div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-6">
                      <div class="date-input-group">
                          <label class="form-label fw-bold">နေ့စွဲ၊၂၀</label>
                          <input type="text" name="day" 
                              value="<?php echo date('d'); ?>" 
                              class="form-control d-inline-block" 
                              style="width: 70px;" maxlength="2" disabled>
                          <span>ရက်၊</span>
                          <input type="text" name="month" 
                              value="<?php echo date('m'); ?>" 
                              class="form-control d-inline-block" 
                              style="width: 70px;" maxlength="2" disabled>
                          <span>လ၊</span>
                          <input type="text" name="year" 
                              value="<?php echo date('Y'); ?>" 
                              class="form-control d-inline-block" 
                              style="width: 70px;" maxlength="4" disabled>
                          <span>ခုနှစ်</span>
                      </div>
                  </div>
              </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">ယခုဆက်သွယ်ရန်လိပ်စာ</h6>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label>အိမ်အမှတ်</label>
                                        <input type="text" name="house_no" value="<?php echo isset($studentData['current_house_no']) ? $studentData['current_house_no'] : ''; ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>လမ်းအမှတ်</label>
                                        <input type="text" name="street_no" value="<?php echo isset($studentData['current_street_no']) ? $studentData['current_street_no'] : ''; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label>ရပ်ကွက်</label>
                                        <input type="text" name="quarter" value="<?php echo isset($studentData['current_quarter']) ? $studentData['current_quarter'] : ''; ?>" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>ကျေးရွာ</label>
                                        <input type="text" name="village" value="<?php echo isset($studentData['current_village']) ? $studentData['current_village'] : ''; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label>မြို့နယ်</label>
                                        <input type="text" name="current_township" value="<?php echo isset($studentData['current_township']) ? $studentData['current_township'] : ''; ?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>ဖုန်းနံပါတ်</label>
                                        <input type="text" name="current_phone" value="<?php echo isset($studentData['current_phone']) ? $studentData['current_phone'] : ''; ?>" class="form-control" required>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center mb-4">
                            <input type="text" name="signature_status" value="<?php echo isset($studentData['signature_status']) ? $studentData['signature_status'] : ''; ?>" class="form-control mb-2" style="width: 60%; margin: 0 auto;" placeholder="လက်မှတ်" required>
                            <div>ပညာသင်ခွင့်လျှောက်ထားသူလက်မှတ်</div>
                        </div>
                        <div class="text-center mt-5">
                            <div class="mb-2">---------------------</div>
                            <div>တက္ကသိုလ်ရုံးမှစစ်ဆေးပြီး</div>
                        </div>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <h5>(မကွေးကွန်ပျုတာ)တက္ကသိုလ်ရုံးအတွက်</h5>
                    <p>ဖော်ပြပါဘာသာရပ်များဖြင့်ပညာသင်ခွင့်ပြုသည်။</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="specialization" class="form-label">အဓိကသာမာန်ဘာသာတွဲများ</label>
                        <select name="specialization" class="form-control" required>
                            <option value="">--ရွေးချယ်ပါ--</option>
                            <option value="CST" <?php echo (isset($studentData['specialization']) && $studentData['specialization'] == 'CST') ? 'selected' : ''; ?>>CST</option>
                            <option value="CS" <?php echo (isset($studentData['specialization']) && $studentData['specialization'] == 'CS') ? 'selected' : ''; ?>>CS</option>
                            <option value="CT" <?php echo (isset($studentData['specialization']) && $studentData['specialization'] == 'CT') ? 'selected' : ''; ?>>CT</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <div class="mb-2">------------------</div>
                            <div>ပါမောက္ခချုပ်</div>
                            <div>ကွန်ပျုတာတက္ကသိုလ်(မကွေး)</div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5 class="form-section-title">ငွေလက်ခံသည့်ဌာန။</h5>
                        <p>ငွေသွင်းရန်လိုအပ်သည့် ငွေကြေးများကို လက်ခံရရှိပြီးဖြစ်ပါသည်။</p>

                        <div class="date-input-group">
                          <label class="form-label">နေ့စွဲ</label>
                          <input type="text" name="payment_day"
                              value="<?php echo date('d'); ?>"
                              class="form-control d-inline-block"
                              style="width: 70px;" maxlength="2" disabled>
                          <span>ရက်၊</span>
                          <input type="text" name="payment_month"
                              value="<?php echo date('m'); ?>"
                              class="form-control d-inline-block"
                              style="width: 70px;" maxlength="2" disabled>
                          <span>လ၊</span>
                          <input type="text" name="payment_year"
                              value="<?php echo date('Y'); ?>"
                              class="form-control d-inline-block"
                              style="width: 70px;" maxlength="4" disabled>
                          <span>ခုနှစ်</span>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center mt-4">
                            <div>-----------------</div>
                            <div>ငွေလက်ခံသူ</div>
                        </div>
                    </div>
                </div>

                <div class="navigation">
                    <button type="button" class="btn btn-secondary" onclick="prevPage(2, 1)">
                        <i class="fas fa-arrow-left"></i> နောက်သို့
                    </button>
                    <button type="submit" name="submit_form" class="btn btn-success">
                        <i class="fas fa-check"></i> ပေးပို့ရန်
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Photo Alert Modal -->
    <div class="modal fade" id="photoAlertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">သတိပေးချက်</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ကျေးဇူးပြု၍ ကျောင်းသား၏ဓာတ်ပုံကို တင်ပေးပါ
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">အိုကေ</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script language="javascript" type="text/javascript">
<script>
        // Debugging message
        console.log("Application form script loaded");

        // Photo upload preview
         // Photo upload preview
  document.getElementById("fileupload").addEventListener("change", function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById("preview").src = e.target.result;
      }
      reader.readAsDataURL(file);
    }
  });

  // Show modal if photo is required
  document.getElementById("fileupload").addEventListener("invalid", function() {
    var photoAlertModal = new bootstrap.Modal(document.getElementById('photoAlertModal'));
    photoAlertModal.show();
  });
        
        // Improved Myanmar digits validation
        function allowOnlyMyanmarDigits(input) {
            console.log("Validating input:", input.name);
            const myanmarDigits = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
            let value = input.value;
            let newValue = '';
            
            for (let i = 0; i < value.length; i++) {
                if (myanmarDigits.includes(value[i])) {
                    newValue += value[i];
                }
            }
            
            input.value = newValue;
            console.log("After validation:", newValue);
            
            // Auto-update end year when start year changes
            if (input.name === 'academic_year_start' && newValue.length === 4) {
                const startYear = convertMyanmarToNumber(newValue);
                if (!isNaN(startYear)) {
                    const endYearInput = document.querySelector('input[name="academic_year_end"]');
                    endYearInput.value = convertNumberToMyanmar(startYear + 1);
                    console.log("Auto-updated end year to:", endYearInput.value);
                }
            }
        }

        // Helper functions with error handling
        function convertMyanmarToNumber(myanmar) {
            try {
                const digitsMap = {'၀':0, '၁':1, '၂':2, '၃':3, '၄':4, '၅':5, '၆':6, '၇':7, '၈':8, '၉':9};
                return parseInt(myanmar.split('').map(d => digitsMap[d]).join(''));
            } catch (e) {
                console.error("Conversion error:", e);
                return NaN;
            }
        }

        function convertNumberToMyanmar(num) {
            try {
                const digitsMap = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
                return num.toString().split('').map(d => digitsMap[d]).join('');
            } catch (e) {
                console.error("Conversion error:", e);
                return "";
            }
        }

        // Initialize form validation
        document.addEventListener("DOMContentLoaded", function() {
            console.log("Document is fully loaded");
            // Add any additional initialization code here
        });
        function nextPage(currentPage, nextPage) {
            document.getElementById('page' + currentPage).style.display = 'none';
            document.getElementById('page' + nextPage).style.display = 'block';
        }
        function prevPage(currentPage, prevPage) {
            document.getElementById('page' + currentPage).style.display = 'none';
            document.getElementById('page' + prevPage).style.display = 'block';
        }
        // Show the first page initially
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('page1').style.display = 'block';
            document.getElementById('page2').style.display = 'none';
        }); 
        
        // Handle form submission
        document.getElementById('applicationForm').addEventListener('submit', function(event)
        {
            event.preventDefault(); // Prevent default form submission
            
            // Validate photo upload
            const fileInput = document.getElementById('fileupload');
            if (fileInput.files.length === 0) {
                var photoAlertModal = new bootstrap.Modal(document.getElementById('photoAlertModal'));
                photoAlertModal.show();
                return; // Stop form submission if no photo is uploaded
            }
            // If photo is uploaded, proceed with form submission
            this.submit(); // Submit the form
        });
        });
        // Debugging message
        console.log("Form script initialized successfully");
        // Show the first page initially
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('page1').style.display = 'block';
            document.getElementById('page2').style.display = 'none';
        });
        // Handle form submission
        document.getElementById('applicationForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            
            // Validate photo upload
            const fileInput = document.getElementById('fileupload');
            if (fileInput.files.length === 0) {
                var photoAlertModal = new bootstrap.Modal(document.getElementById('photoAlertModal'));
                photoAlertModal.show();
                return; // Stop form submission if no photo is uploaded
            }
            // If photo is uploaded, proceed with form submission
            this.submit(); // Submit the form
        });
    </script>
</body>
</html>