<?php
require 'includes/header.php';
require 'includes/student_navbar.php';
?>

<style>
     body {
            background-image:url('image/CU1.jpg');
            color: var(--dark);
            
        }
    .about-container {
        max-width: 800px;
        margin: 30px auto 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 30px;
        font-family: 'Padauk', 'Noto Sans Myanmar', sans-serif;
        color: #2c3e50;
    }

    .about-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .about-header h1 {
        font-size: 2rem;
        color: #34495e;
        margin-bottom: 10px;
    }

    .about-header p {
        font-size: 1rem;
        color: #666;
    }

    .section {
        margin-top: 30px;
    }

    .section h3 {
        font-size: 1.2rem;
        color: #2980b9;
        margin-bottom: 10px;
    }

    .section p {
        font-size: 0.95rem;
        line-height: 1.7;
        color: #444;
    }

    ul {
        padding-left: 20px;
        margin-top: 5px;
    }

    ul li {
        margin-bottom: 6px;
    }

    @media (max-width: 768px) {
        .about-container {
            margin: 80px 15px 30px;
            padding: 20px;
        }
    }
</style>

<div class="about-container">
    <div class="about-header">
        <h1><i class="fas fa-clipboard-list me-2"></i>UCSM Registration System</h1>
        <p>ကျောင်းအပ်ခြင်းစနစ်အကြောင်း (About the Student Registration System)</p>
    </div>

    <div class="section">
        <h3>📌 စနစ်အကျဉ်း | System Overview</h3>
        <p>
            UCSM (မကွေး) သည် ကျောင်းသားအချက်အလက်များကို စနစ်တကျ စုစည်းရန်အတွက် <strong>Online Registration System</strong> ကို အသုံးပြုပါသည်။
            ကျောင်းသားများအနေဖြင့် ကိုယ်ပိုင်အကောင့်ဖြင့် login ဝင်ပြီး တိုက်ရိုက်ဖောင်ဖြည့်သွင်းနိုင်ပါသည်။
        </p>
        <p>
            UCSM (Magway) uses an <strong>Online Registration System</strong> to collect student information in a systematic and digital way. Students can log in with their accounts and directly fill in the required application forms online.
        </p>
    </div>

    <div class="section">
        <h3>⚙️ အဓိကလုပ်ဆောင်ချက်များ | Key Features</h3>
        <ul>
            <li>တစ်ဦးချင်းလျှောက်လွှာဖြည့်သွင်းခြင်း။ (Individual form submission)</li>
            <li>Excel ဖိုင်မှတဆင့် အစုလိုက် Upload။ (Batch upload via Excel)</li>
            <li>ဓာတ်ပုံ၊ လက်မှတ်၊ NRC Upload။ (Upload of photo, signature, and NRC)</li>
            <li>ဖောင်ပြင်ဆင်ခြင်း၊ ပြန်လည်သုံးသပ်နိုင်ခြင်း။ (Edit and review form data)</li>
        </ul>
    </div>

    <div class="section">
        <h3>🎯 ရည်ရွယ်ချက် | Purpose</h3>
        <p>
            ကျောင်းသားအချက်အလက်များကို တိကျပြည့်စုံစွာ စုဆောင်းနိုင်ရန်နှင့် အပ်ခြင်းလုပ်ငန်းများကို အချိန်တိုအတွင်း ပြီးမြောက်စေဖို့ဖြစ်သည်။
        </p>
        <p>
            The system aims to accurately collect complete student data and streamline the registration process for efficient handling.
        </p>
    </div>
</div>

<?php include "includes/footer.php" ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
