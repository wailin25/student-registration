<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ကျောင်းသားလျှောက်လွှာ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: 'Myanmar3', 'Padauk', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            padding-top: 60px;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            width: 210mm;
            min-height: 297mm;
            position: relative;
        }
        .university-logo {
            height: 80px;
            margin-bottom: 15px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
        }
        .form-header h4 {
            color: #0d6efd;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .year-input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 2px 5px;
            font-size: 14px;
        }
        .main-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            font-size: 14px;
        }
        .main-table td, .main-table th {
            border: 1px solid #999;
            color: #111 !important;
            font-weight: 500;
            padding: 8px;
            vertical-align: middle;
        }
        .main-table label {
            margin-bottom: 0;
            font-weight: bold;
        }
        .required::after {
            content: " *";
            color: red;
        }
        .photo-cell {
            width: 120px;
            text-align: center;
            vertical-align: middle;
        }
        .image-preview-container {
            width: 100px;
            height: 125px;
            margin: 0 auto;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f9f9f9;
        }
        .image-preview {
            width: 100px;
            height: 125px;
            object-fit: cover;
        }
        .exam-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            font-size: 14px;
        }
        .exam-table th {
            background-color: #f8f9fa;
            color: #333;
            text-align: center;
            padding: 8px;
        }
        .exam-table td {
            border: 1px solid #999 !important;
            padding: 8px;
        }
        .form-control, .form-select {
            border: 1px solid #999 !important;
            color: #000 !important;
            font-weight: 500;
            background-color: #fff !important;
            font-size: 14px;
            padding: 6px;
        }
        .form-control-sm {
            font-size: 13px;
            padding: 4px 6px;
        }
        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
        }
        .navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding: 20px 0;
            border-top: 1px solid #eee;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            font-size: 14px;
            padding: 8px 20px;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            font-size: 14px;
            padding: 8px 20px;
        }
        .center {
            text-align: center;
        }
        .declaration {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #dee2e6;
        }
        .declaration-item {
            margin-bottom: 12px;
            padding-left: 22px;
            position: relative;
            line-height: 1.6;
        }
        .declaration-item:before {
            content: "";
            position: absolute;
            left: 8px;
            top: 10px;
            width: 8px;
            height: 8px;
            background-color: #0d6efd;
            border-radius: 50%;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 80%;
            margin: 0 auto 10px;
            padding-top: 8px;
            text-align: center;
        }
        .progress-container {
            margin: 20px auto;
            max-width: 500px;
        }
        @media print {
            body {
                background: none;
                padding: 0;
            }
            .form-container {
                box-shadow: none;
                border-radius: 0;
                padding: 10px;
                width: 100%;
            }
            .navigation {
                display: none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">ကွန်ပျူတာတက္ကသိုလ် (မကွေး)</a>
            <div class="ms-auto">
                <span class="navbar-text">
                    ကျောင်းသားလျှောက်လွှာ
                </span>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="form-container">
            <form id="studentForm" method="POST" enctype="multipart/form-data">
                <div class="form-header">
                    <img src="https://via.placeholder.com/80" alt="တက္ကသိုလ်လိုဂို" class="university-logo">
                    <h5>ကွန်ပျူတာတက္ကသိုလ် (မကွေး)</h5>
                    <span>(</span>
                    <input type="text" name="academic_yr_start" class="year-input" maxlength="4" value="၂၀၂၄" oninput="allowOnlyMyanmarDigits(this)">
                    <span>-</span>
                    <input type="text" name="academic_yr_end" class="year-input" maxlength="4" value="၂၀၂၅" oninput="allowOnlyMyanmarDigits(this)">
                    <span>) ပညာသင်နှစ်</span>
                    <h5>ကျောင်းသား/ကျောင်းသူများ ပညာသင်ခွင့်လျှောက်လွှာ</h5>
                </div>

                <!-- Progress indicator -->
                <div class="progress-container">
                    <div class="progress mb-2">
                        <div class="progress-bar" role="progressbar" id="formProgress" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="progress-text text-center" id="progressText">စာမျက်နှာ 1/2</div>
                </div>

                <!-- Page 1: Student Information -->
                <div class="form-section active" id="page1">
                    <table class="main-table">
                        <tr>
                            <td class="photo-cell" rowspan="5">
                                <label for="fileupload" class="d-block">
                                    <div class="image-preview-container mb-2">
                                        <img id="preview" src="data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='150' height='180' viewBox='0 0 150 180'%3E%3Crect fill='%23ddd' width='150' height='180'/%3E%3Ctext fill='%23666' font-family='sans-serif' font-size='14' x='50%' y='50%' text-anchor='middle' dominant-baseline='middle'%3EStudent Photo%3C/text%3E%3C/svg%3E" class="image-preview" alt="Student Photo">
                                    </div>
                                    <input class="form-control form-control-sm" type="file" id="fileupload" name="image" >
                                </label>
                            </td>
                            <td>သင်တန်းနှစ်</td>
                            <td>
                                <select name="class" class="form-control" >
                                    <option value="">--ရွေးပါ--</option>
                                    <option value="ပထမနှစ်">ပထမနှစ်</option>
                                    <option value="ဒုတိယနှစ်">ဒုတိယနှစ်</option>
                                    <option value="တတိယနှစ်(Jr.)">တတိယနှစ်(Jr.)</option>
                                    <option value="တတိယနှစ်(Sr.)">တတိယနှစ်(Sr.)</option>
                                    <option value="စတုတ္ထနှစ်">စတုတ္ထနှစ်</option>
                                    <option value="ပဉ္စမနှစ်">ပဉ္စမနှစ်</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>အထူးပြုဘာသာ</td>
                            <td>
                                <select name="specialization" class="form-control">
                                    <option value="">--ရွေးပါ--</option>
                                    <option value="CST">CST</option>
                                    <option value="CS">CS</option>
                                    <option value="CT">CT</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>ခုံအမှတ်</td>
                            <td style="display: flex; gap: 5px; align-items: center;">
                                <input type="text" name="serial_code" value="UCSMG-" readonly style="flex: 0 0 80px; background-color: #f1f1f1; border: 1px solid #ccc; text-align: center;" >
                                <input type="text" name="serial_no" pattern="\d{5}" maxlength="5"  placeholder="e.g., 24001" style="flex: 1;" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>တက္ကသိုလ်ဝင်ရောက်သည့်ခုနှစ်</td>
                            <td>
                                <input type="text" name="entry_yr" pattern="20\d{2}" maxlength="4"  placeholder="ဥပမာ - 2024" class="form-control">
                            </td>      
                        </tr>
                    </table>
                    
                    <!-- Personal Information Table -->
                    <table class="main-table">
                        <tr>
                            <td colspan="2"><label class="">၁။ ပညာဆက်လက်သင်ခွင့်တောင်းသူ</label></td>
                            <td><label>ကျောင်းသား/ကျောင်းသူ</label></td>
                            <td style="width:190px;text-align:center;"><label>အဘ</label></td>
                            <td style="width:190px;text-align:center;"><label>အမိ</label></td>
                        </tr>
                        <tr>
                            <td rowspan="2"><label class="">အမည်</label></td>
                            <td><label>မြန်မာစာဖြင့်</label></td>
                            <td><input type="text" name="SMyanName" placeholder="မောင်ကျော်ကျော် / မလှလှ" class="form-control"></td>
                            <td><input type="text" name="father_name_my"  placeholder="ဦးမောင်မောင်" class="form-control"></td>
                            <td><input type="text" name="mother_name_my"  placeholder="ဒေါ်အေးအေး" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label>အင်္ဂလိပ်စာဖြင့်</label></td>
                            <td><input type="text" name="SEngName"  placeholder="Mg Kyaw Kyaw / Ma Hla Hla" class="form-control"></td>
                            <td><input type="text" name="father_name_en"  placeholder="U Maung Maung" class="form-control"></td>
                            <td><input type="text" name="mother_name_en"  placeholder="Daw Aye Aye" class="form-control"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><label class="">လူမျိုး</label></td>
                            <td><input type="text" name="Nationality" class="form-control" ></td>
                            <td><input type="text" name="father_ethnicity" class="form-control" ></td>
                            <td><input type="text" name="mother_ethnicity" class="form-control" ></td>
                        </tr>
                        <tr>
                            <td colspan="2"><label class="required">ကိုးကွယ်သည့်ဘာသာ</label></td>
                            <td><input type="text" name="Religious" class="form-control" ></td>
                            <td><input type="text" name="father_religion" class="form-control" ></td>
                            <td><input type="text" name="mother_religion" class="form-control" ></td>
                        </tr>
                        <tr>
                            <td colspan="2"><label class="required">မွေးဖွားရာဇာတိ</label></td>
                            <td><input type="text" name="NativeTown" class="form-control" d></td>
                            <td><input type="text" name="father_birth_place" class="form-control" ></td>
                            <td><input type="text" name="mother_birth_place" class="form-control"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><label class="required">မြို့နယ်/ပြည်နယ်/တိုင်း</label></td>
                            <td>
                                <input type="text" name="Township" class="form-control" >
                                <input type="text" name="region" class="form-control">
                                <input type="text" name="state" class="form-control">
                            </td>
                            <td>
                                <input type="text" name="father_township" class="form-control" >
                                <input type="text" name="F_region" class="form-control">
                                <input type="text" name="F_state" class="form-control">
                            </td>
                            <td>
                                <input type="text" name="mother_township" class="form-control" >
                                <input type="text" name="M_region" class="form-control">
                                <input type="text" name="M_state" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><label class="required">မှတ်ပုံတင်အမှတ်</label></td>
                            <td><input type="text" name="SNRC" class="form-control" ></td>
                            <td><input type="text" name="F_NRC" class="form-control" ></td>
                            <td><input type="text" name="M_NRC" class="form-control" ></td>
                        </tr>
                        <tr>
                            <td colspan="2"><label class="required">နိုင်ငံခြားသား</label></td>
                            <td>
                                <select name="Citizen_status" class="form-select form-select-sm">
                                    <option value="empty">တိုင်းရင်းသား/နိုင်ငံခြားသား</option>
                                    <option value="1">တိုင်းရင်းသား</option>
                                    <option value="0">နိုင်ငံခြားသား</option>
                                </select>
                            </td>
                            <td>
                                <select name="F_Citizen_status" class="form-select form-select-sm">
                                    <option value="empty">တိုင်းရင်းသား/နိုင်ငံခြားသား</option>
                                    <option value="1">တိုင်းရင်းသား</option>
                                    <option value="0">နိုင်ငံခြားသား</option>
                                </select>
                            </td>
                            <td>
                                <select name="M_Citizen_status" class="form-select form-select-sm">
                                    <option value="empty">တိုင်းရင်းသား/နိုင်ငံခြားသား</option>
                                    <option value="1">တိုင်းရင်းသား</option>
                                    <option value="0">နိုင်ငံခြားသား</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><label class="required">မွေးသက္ကရာဇ်</label></td>
                            <td><input type="date" name="Birth_date" class="form-control" ></td>
                            <td colspan="2">အဘအုပ်ထိန်းသူ၏ အလုပ်အကိုင်၊ရာထူး၊ဌာန၊လိပ်စာအပြည့်အစုံ</td>
                        </tr>
                        <tr>
                            <td rowspan="3">တက္ကသိုလ်ဝင်တန်းစာမေးပွဲအောင်မြင်သည့်</td>
                            <td>ခုံအမှတ် - </td>
                            <td><input type="text" name="Matri_num" class="form-control" ></td>
                            <td class="text-center" colspan="2" rowspan="3" style="padding: 8px;">
                                <div class="container-fluid">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="F_home" placeholder="အိမ်">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="F_quarter" placeholder="ရပ်ကွက်">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="F_street" placeholder="လမ်းအမှတ်">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="F_nativeTown" placeholder="ကျေးရွာ">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="F-city" placeholder="မြို့">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="F_township" placeholder="မြို့နယ်" d>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="F_phone" placeholder="09-xxxxxxxxx">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="F_job" placeholder="အလုပ်အကိုင်" >
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>ခုနှစ် - </td>
                            <td><input type="text" name="passed_year" class="form-control" maxlength="4"></td>
                        </tr>
                        <tr>
                            <td>စာစစ်ဌာန - </td>
                            <td><input type="text" name="Exam_dept" class="form-control" ></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="center"><label class="">အမြဲတမ်းနေထိုင်သည့်လိပ်စာ(အပြည့်အစုံ)</label></td>
                            <td colspan="2"><label class="">အမိအုပ်ထိန်းသူ၏ အလုပ်အကိုင်၊ရာထူး၊ဌာန၊လိပ်စာအပြည့်အစုံ</label></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding: 8px;">
                                <div class="container-fluid">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="SCurrent_home_no" placeholder="အိမ်အမှတ်" >
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="SCurrent_street" placeholder="လမ်း" d>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="SCurrent_quarter" placeholder="ရပ်ကွက်" >
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="NativeTown" placeholder="ကျေးရွာ" >
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="SCurrent_city" placeholder="မြို့" >
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="Township" placeholder="မြို့နယ်" >
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="SCurrent_phone" placeholder="ဖုန်းနံပါတ်" >
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td colspan="2" style="padding: 8px;">
                                <div class="container-fluid">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="M_home" placeholder="အိမ်">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="M_quarter" placeholder="ရပ်ကွက်">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="M_street" placeholder="လမ်းအမှတ်">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="M_nativeTown" placeholder="ကျေးရွာ">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="M_city" placeholder="မြို့">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="M_township" placeholder="မြို့နယ်" >
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="M_phone" placeholder="09-xxxxxxxxx">
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form-control" type="text" name="M_job" placeholder="အလုပ်အကိုင်" >
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
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <tr>
                            <td>
                                <select name="exam_subject_<?php echo $i; ?>" class="form-select form-select-sm">
                                    <option value="">ရွေးချယ်ပါ</option>
                                    <option value="ပထမနှစ်">ပထမနှစ်</option>
                                    <option value="ဒုတိယနှစ်">ဒုတိယနှစ်</option>
                                    <option value="တတိယနှစ်(Jr.)">တတိယနှစ်(Jr.)</option>
                                    <option value="တတိယနှစ်(Sr.)">တတိယနှစ်(Sr.)</option>
                                    <option value="စတုတ္ထနှစ်">စတုတ္ထနှစ်</option>
                                    <option value="ပဉ္စမနှစ်">ပဉ္စမနှစ်</option>
                                </select>
                            </td>
                            <td>
                                <select name="exam_major_<?php echo $i; ?>" class="form-select form-select-sm">
                                    <option value="">ရွေးချယ်ပါ</option>
                                    <option value="CST">CST</option>
                                    <option value="CS">CS</option>
                                    <option value="CT">CT</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="no_serial<?php echo $i; ?>" class="form-control form-control-sm" style="max-width: 200px;">
                            </td>
                            <td>
                                <input type="text" name="entr_year<?php echo $i; ?>" maxlength="4" class="form-control form-control-sm" style="max-width: 200px;">
                            </td>
                            <td>
                                <select name="exam_result_<?php echo $i; ?>" class="form-select form-select-sm">
                                    <option value="">ရွေးချယ်ပါ</option>
                                    <option value="အောင်">အောင်</option>
                                    <option value="ရှုံး">ရှုံး</option>
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
                                    <td><input type="text" name="supporter_name" class="form-control" required></td>
                                </tr>
                                <tr>
                                    <td>(ခ) ဆွေမျိုးတော်စပ်ပုံ</td>
                                    <td><input type="text" name="relationship" class="form-control" required></td>
                                </tr>
                                <tr>
                                    <td>(ဂ) အလုပ်အကိုင်</td>
                                    <td><input type="text" name="supporter_job" class="form-control" required></td>
                                </tr>
                                <tr>
                                    <td>(ဃ) ဆက်သွယ်ရန်လိပ်စာ</td>
                                    <td><input type="text" name="supporter_address" class="form-control" placeholder="ကျေးရွာ/ရပ်ကွက်/မြို့" required></td>
                                </tr>
                                <tr>
                                    <td>နှင့်ဖုန်းနံပါတ်</td>
                                    <td><input type="text" name="supporter_phone" class="form-control" placeholder="09-xxxxxxxxx" required></td>
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
                                <input class="form-check-input" type="radio" name="grant_support" id="support_yes" value="ပြု" required>
                                <label class="form-check-label" for="support_yes">ပြု</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="grant_support" id="support_no" value="မပြု">
                                <label class="form-check-label" for="support_no">မပြု</label>
                            </div>
                        </div>
                    </div>

                    <div class="navigation">
                        <button type="button" class="btn btn-secondary" onclick="prevPage(2, 1)">
                            <i class="fas fa-arrow-left"></i> နောက်သို့
                        </button>
                        <button type="button" class="btn btn-primary" onclick="nextPage(2, 3)">
                            ရှေ့သို့ <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    <h5 class="form-section-title text-center">ကိုယ်တိုင်ဝန်ခံချက်</h5>
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
                                <input type="text" name="date_year" class="form-control d-inline-block" style="width: 80px;" maxlength="4" placeholder="နှစ်" required>
                                <span>ခုနှစ်၊</span>
                                <input type="text" name="date_month" class="form-control d-inline-block" style="width: 60px;" maxlength="2" placeholder="လ" required>
                                <span>လ၊</span>
                                <input type="text" name="date_day" class="form-control d-inline-block" style="width: 60px;" maxlength="2" placeholder="ရက်" required>
                                <span>ရက်။</span>
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
                                            <input type="text" name="house_no" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>လမ်းအမှတ်</label>
                                            <input type="text" name="street_no" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label>ရပ်ကွက်</label>
                                            <input type="text" name="quarter" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>ကျေးရွာ/မြို့</label>
                                            <input type="text" name="village_or_city" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label>ဖုန်းနံပါတ်</label>
                                            <input type="text" name="phone" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>အဆောင်</label>
                                            <input type="text" name="hostel" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <input type="text" name="student_signature" class="form-control mb-2" style="width: 60%; margin: 0 auto;" placeholder="လက်မှတ်" required>
                                <div>ပညာသင်ခွင့်လျှောက်ထားသူလက်မှတ်</div>
                            </div>
                            <div class="text-center">
                                <div class="mb-2">---------------------</div>
                                <div>တက္ကသိုလ်ရုံးမှစစ်ဆေးပြီး</div>
                            </div>
                        </div>
                    </div>

                    <div class="navigation">
                        <button type="button" class="btn btn-secondary" onclick="prevPage(3, 2)">
                            <i class="fas fa-arrow-left"></i> နောက်သို့
                        </button>
                        <button type="button" class="btn btn-primary" onclick="nextPage(3, 4)">
                            ရှေ့သို့ <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    <div class="text-center mb-4">
                        <h5>(မကွေးကွန်ပျုတာ)တက္ကသိုလ်ရုံးအတွက်</h5>
                        <p>ဖော်ပြပါဘာသာရပ်များဖြင့်ပညာသင်ခွင့်ပြုသည်။</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="specialization" class="form-label">အဓိကသာမာန်ဘာသာတွဲများ</label>
                            <select name="specialization" id="specialization" class="form-control" required>
                                <option value="" selected disabled>-- ရွေးပါ --</option>
                                <option value="CST">CST</option>
                                <option value="CS">CS</option>
                                <option value="CT">CT</option>
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
                                <input type="text" name="payment_day" class="form-control d-inline-block" style="width: 70px;" maxlength="2" placeholder="ရက်" required>
                                <span>ရက်၊</span>
                                <input type="text" name="payment_month" class="form-control d-inline-block" style="width: 70px;" maxlength="2" placeholder="လ" required>
                                <span>လ၊</span>
                                <input type="text" name="payment_year" class="form-control d-inline-block" style="width: 70px;" maxlength="4" placeholder="နှစ်" required>
                                <span>ခုနှစ်</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center mt-4">
                                <input type="text" name="receiver_signature" class="form-control mb-2" style="width: 60%; margin: 0 auto;" placeholder="လက်မှတ်" required>
                                <div>-----------------</div>
                                <div>ငွေလက်ခံသူ</div>
                            </div>
                        </div>
                    </div>

                    <div class="navigation">
                        <button type="button" class="btn btn-secondary" onclick="prevPage(4, 3)">
                            <i class="fas fa-arrow-left"></i> နောက်သို့
                        </button>
                        <button type="submit" name="submit_form" class="btn btn-success">
                            <i class="fas fa-check"></i> ပြီးပါပြီ
                        </button>
                    </div>
                </div>
            </form>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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
        
        // Myanmar digits validation
        function allowOnlyMyanmarDigits(input) {
            const myanmarDigits = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
            let value = input.value;
            let newValue = '';
            
            for (let i = 0; i < value.length; i++) {
                if (myanmarDigits.includes(value[i])) {
                    newValue += value[i];
                }
            }
            
            input.value = newValue;
            
            // Auto-update end year when start year changes
            if (input.name === 'academic_yr_start' && newValue.length === 4) {
                const startYear = convertMyanmarToNumber(newValue);
                if (!isNaN(startYear)) {
                    const endYearInput = document.querySelector('input[name="academic_yr_end"]');
                    endYearInput.value = convertNumberToMyanmar(startYear + 1);
                }
            }
        }

        // Helper functions
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

        // Page navigation functions
        function nextPage(current, next) {
            // Validate current page before proceeding
            if (validatePage(current)) {
                document.getElementById('page' + current).classList.remove('active');
                document.getElementById('page' + next).classList.add('active');
                updateProgress(next);
            }
        }

        function prevPage(current, prev) {
            document.getElementById('page' + current).classList.remove('active');
            document.getElementById('page' + prev).classList.add('active');
            updateProgress(prev);
        }

        function updateProgress(currentPage) {
            const progress = (currentPage / 4) * 100;
            document.getElementById('formProgress').style.width = progress + '%';
            document.getElementById('formProgress').setAttribute('aria-valuenow', progress);
            document.getElementById('progressText').textContent = 'စာမျက်နှာ ' + currentPage + '/4';
        }

        // Page validation
        function validatePage(pageNum) {
            let isValid = true;
            const page = document.getElementById('page' + pageNum);
            
            // Check all required fields in this page
            const requiredFields = page.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                    
                    // Add error message if not exists
                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'ဤအချက်ကိုဖြည့်ရန်လိုအပ်ပါသည်';
                        field.parentNode.appendChild(errorDiv);
                    }
                } else {
                    field.classList.remove('is-invalid');
                    const errorMsg = field.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                        field.parentNode.removeChild(errorMsg);
                    }
                }
            });

            // Special validation for page 1 photo
            if (pageNum === 1) {
                const photoInput = document.getElementById('fileupload');
                if (!photoInput.files || photoInput.files.length === 0) {
                    photoInput.classList.add('is-invalid');
                    isValid = false;
                    
                    if (!photoInput.nextElementSibling || !photoInput.nextElementSibling.classList.contains('invalid-feedback')) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'ကျေးဇူးပြု၍ ကျောင်းသား၏ဓာတ်ပုံကို တင်ပေးပါ';
                        photoInput.parentNode.appendChild(errorDiv);
                    }
                } else {
                    photoInput.classList.remove('is-invalid');
                    const errorMsg = photoInput.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                        photoInput.parentNode.removeChild(errorMsg);
                    }
                }
            }

            // Special validation for dates
            if (pageNum === 3 || pageNum === 4) {
                const day = page.querySelector('[name="date_day"]') || page.querySelector('[name="payment_day"]');
                const month = page.querySelector('[name="date_month"]') || page.querySelector('[name="payment_month"]');
                const year = page.querySelector('[name="date_year"]') || page.querySelector('[name="payment_year"]');
                
                if (!day.value || !month.value || !year.value || day.value < 1 || day.value > 31 || 
                    month.value < 1 || month.value > 12 || year.value.length !== 4) {
                    alert('ကျေးဇူးပြု၍ မှန်ကန်သောနေ့စွဲကိုထည့်ပါ');
                    isValid = false;
                }
            }

            // Scroll to first error if any
            if (!isValid) {
                const firstError = page.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }

            return isValid;
        }

        // Form submission
        document.getElementById('studentForm').addEventListener('submit', function(e) {
            if (!validatePage(4)) {
                e.preventDefault();
            } else {
                alert('လျှောက်လွှာတင်ပြီးပါပြီ!');
                // Here you would typically submit the form via AJAX or let it submit normally
            }
        });

        // Initialize form validation on input
        document.querySelectorAll('input, select').forEach(element => {
            element.addEventListener('input', function() {
                if (this.hasAttribute('required') && this.value.trim()) {
                    this.classList.remove('is-invalid');
                    const errorMsg = this.nextElementSibling;
                    if (errorMsg && errorMsg.classList.contains('invalid-feedback')) {
                        this.parentNode.removeChild(errorMsg);
                    }
                }
            });
        });
    </script>
</body>
</html>