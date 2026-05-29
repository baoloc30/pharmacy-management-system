<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PharMaCare – Hệ Thống Quản Lý Nhà Thuốc</title>
<meta name="description" content="Hệ thống quản lý nhà thuốc hiện đại, thông minh, toàn diện.">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
html{scroll-behavior:smooth;}
body{font-family:'Inter',sans-serif;color:#fff;overflow-x:hidden;position:relative;}

/* ── BACKGROUND ── */
body::before {
    content: '';
    position: fixed;
    inset: 0;
    background-image: url('<?php echo BASE_URL; ?>assets/images/nhathuoc.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    z-index: -2;
}
body::after {
    content: '';
    position: fixed;
    inset: 0;
    background: linear-gradient(135deg, rgba(5,30,80,.8) 0%, rgba(10,60,120,.7) 60%, rgba(2,20,60,.85) 100%);
    z-index: -1;
}

/* ── NAVBAR ── */
.navbar{position:fixed;top:0;left:0;right:0;z-index:1000;padding:0 5%;height:70px;display:flex;align-items:center;justify-content:space-between;background:rgba(5, 30, 80, 0.6);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-bottom:1px solid rgba(255,255,255,.07);transition:all .3s;}
.nav-brand{display:flex;align-items:center;gap:10px;text-decoration:none;}
.nav-icon{width:38px;height:38px;background:linear-gradient(135deg,#0ea5e9,#38bdf8);border-radius:10px;display:flex;align-items:center;justify-content:center;}
.nav-icon i{color:#fff;font-size:16px;}
.nav-name{font-size:18px;font-weight:900;color:#fff;letter-spacing:.5px;}
.nav-name span{color:#38bdf8;}
.nav-links{display:flex;align-items:center;gap:32px;}
.nav-links a{color:rgba(255,255,255,.8);text-decoration:none;font-size:14px;font-weight:500;transition:color .2s;}
.nav-links a:hover{color:#fff;}
.nav-cta{padding:9px 22px;background:linear-gradient(135deg,#0ea5e9,#2563eb);border-radius:10px;color:#fff;font-size:14px;font-weight:700;text-decoration:none;transition:all .2s;box-shadow:0 4px 14px rgba(14,165,233,.4);}
.nav-cta:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(14,165,233,.55);}

/* ── HERO ── */
.hero{min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:120px 5% 80px;position:relative;overflow:hidden;}
.hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:60px 60px;}
.hero-content{position:relative;z-index:1;max-width:820px;margin:0 auto;}
.hero-badge{display:inline-flex;align-items:center;gap:8px;padding:6px 16px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:50px;font-size:13px;font-weight:600;color:#e0f2fe;margin-bottom:28px;backdrop-filter:blur(4px);}
.hero-badge i{font-size:11px;color:#7dd3fc;}
.hero h1{font-size:clamp(38px,6vw,72px);font-weight:900;line-height:1.1;margin-bottom:24px;letter-spacing:-1px;}
.hero h1 .gradient{background:linear-gradient(135deg,#7dd3fc,#38bdf8,#818cf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;}
.hero p{font-size:clamp(15px,2vw,18px);color:rgba(255,255,255,.8);max-width:600px;margin:0 auto 40px;line-height:1.7;}
.hero-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;}
.btn-primary{padding:14px 32px;background:linear-gradient(135deg,#0ea5e9,#2563eb);border-radius:12px;color:#fff;font-size:15px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 6px 24px rgba(14,165,233,.45);transition:all .25s;}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 10px 32px rgba(14,165,233,.6);background:linear-gradient(135deg,#38bdf8,#3b82f6);}
.btn-outline{padding:14px 32px;border:1.5px solid rgba(255,255,255,.3);border-radius:12px;color:rgba(255,255,255,.9);font-size:15px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:all .25s;background:rgba(255,255,255,.05);backdrop-filter:blur(8px);}
.btn-outline:hover{border-color:rgba(255,255,255,.6);background:rgba(255,255,255,.15);transform:translateY(-2px);}

/* ── STATS ── */
.stats{padding:60px 5%;display:flex;gap:2px;justify-content:center;flex-wrap:wrap;}
.stat-card{flex:1;min-width:180px;max-width:260px;padding:32px 24px;text-align:center;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:16px;margin:4px;transition:all .3s;backdrop-filter:blur(8px);}
.stat-card:hover{background:rgba(255,255,255,.12);border-color:rgba(56,189,248,.4);transform:translateY(-4px);}
.stat-num{font-size:42px;font-weight:900;background:linear-gradient(135deg,#bae6fd,#7dd3fc);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;}
.stat-label{font-size:13px;color:rgba(255,255,255,.7);margin-top:8px;font-weight:500;}

/* ── FEATURES ── */
.features{padding:80px 5%;max-width:1200px;margin:0 auto;}
.section-label{text-align:center;margin-bottom:56px;}
.section-label h2{font-size:clamp(28px,4vw,42px);font-weight:900;margin-bottom:12px;}
.section-label p{color:rgba(255,255,255,.7);font-size:15px;max-width:500px;margin:0 auto;}
.features-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:20px;}
.feat-card{padding:32px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:18px;transition:all .3s;position:relative;overflow:hidden;backdrop-filter:blur(8px);}
.feat-card::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(56,189,248,.1),transparent);opacity:0;transition:opacity .3s;}
.feat-card:hover{border-color:rgba(56,189,248,.4);transform:translateY(-5px);box-shadow:0 15px 40px rgba(0,0,0,.2);}
.feat-card:hover::before{opacity:1;}
.feat-icon{width:52px;height:52px;border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;font-size:22px;}
.feat-title{font-size:17px;font-weight:700;margin-bottom:10px;color:#fff;}
.feat-desc{font-size:13px;color:rgba(255,255,255,.7);line-height:1.7;}

/* ── HOW IT WORKS ── */
.how{padding:80px 5%;background:rgba(255,255,255,.03);border-top:1px solid rgba(255,255,255,.08);border-bottom:1px solid rgba(255,255,255,.08);backdrop-filter:blur(4px);}
.how-inner{max-width:900px;margin:0 auto;}
.steps{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:32px;margin-top:48px;}
.step{text-align:center;}
.step-num{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#0ea5e9,#38bdf8);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:900;color:#fff;margin:0 auto 18px;box-shadow:0 8px 24px rgba(14,165,233,.4);}
.step h3{font-size:15px;font-weight:700;margin-bottom:8px;}
.step p{font-size:13px;color:rgba(255,255,255,.7);line-height:1.6;}

/* ── CTA BANNER ── */
.cta-section{padding:80px 5%;text-align:center;}
.cta-box{max-width:700px;margin:0 auto;padding:56px 40px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.2);border-radius:24px;position:relative;overflow:hidden;backdrop-filter:blur(12px);}
.cta-box::before{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:radial-gradient(ellipse at center,rgba(14,165,233,.2),transparent 60%);animation:rotateBg 8s linear infinite;}
@keyframes rotateBg{to{transform:rotate(360deg);}}
.cta-box h2{font-size:clamp(24px,4vw,36px);font-weight:900;margin-bottom:14px;position:relative;}
.cta-box p{color:rgba(255,255,255,.8);font-size:15px;margin-bottom:32px;position:relative;}
.cta-box .btn-primary{position:relative;font-size:16px;padding:15px 36px;}

/* ── FOOTER ── */
footer{padding:40px 5%;border-top:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;background:rgba(5, 30, 80, 0.4);}
footer .foot-brand{display:flex;align-items:center;gap:8px;text-decoration:none;}
footer .foot-brand span{font-size:15px;font-weight:700;color:rgba(255,255,255,.8);}
footer p{font-size:12px;color:rgba(255,255,255,.5);}

/* ── ANIMATIONS ── */
.fade-up{opacity:0;transform:translateY(30px);transition:opacity .6s ease,transform .6s ease;}
.fade-up.visible{opacity:1;transform:translateY(0);}

/* ── RESPONSIVE ── */
@media(max-width:640px){
  .navbar{padding:0 4%;}
  .nav-links{display:none;}
  .steps{grid-template-columns:1fr;}
  footer{flex-direction:column;text-align:center;}
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a class="nav-brand" href="<?php echo BASE_URL; ?>">
    <div class="nav-icon"><i class="fas fa-clinic-medical"></i></div>
    <div class="nav-name">Pharma<span>Care</span></div>
  </a>
  <div class="nav-links">
    <a href="#features">Tính năng</a>
    <a href="#how">Cách dùng</a>
    <a href="#about">Giới thiệu</a>
  </div>
  <a class="nav-cta" href="<?php echo BASE_URL; ?>auth/login">
    <i class="fas fa-sign-in-alt" style="margin-right:6px;"></i>Đăng nhập
  </a>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-grid"></div>
  <div class="hero-content">
    <div class="hero-badge fade-up">
      <i class="fas fa-circle" style="color:#22d3ee;font-size:8px;"></i>
      Hệ thống quản lý nhà thuốc thế hệ mới
    </div>
    <h1 class="fade-up">
      Quản lý nhà thuốc<br>
      <span class="gradient">thông minh & hiệu quả</span>
    </h1>
    <p class="fade-up">
      Nền tảng toàn diện giúp bạn quản lý thuốc, kho hàng, nhân viên,
      doanh thu và khách hàng — tất cả trong một giao diện duy nhất.
    </p>
    <div class="hero-btns fade-up">
      <a class="btn-primary" href="<?php echo BASE_URL; ?>auth/login">
        <i class="fas fa-rocket"></i> Bắt đầu ngay
      </a>
      <a class="btn-outline" href="#features">
        <i class="fas fa-play-circle"></i> Khám phá tính năng
      </a>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="stats">
  <div class="stat-card fade-up">
    <div class="stat-num">500+</div>
    <div class="stat-label">Loại thuốc quản lý</div>
  </div>
  <div class="stat-card fade-up">
    <div class="stat-num">99%</div>
    <div class="stat-label">Độ chính xác kho hàng</div>
  </div>
  <div class="stat-card fade-up">
    <div class="stat-num">24/7</div>
    <div class="stat-label">Theo dõi thời gian thực</div>
  </div>
  <div class="stat-card fade-up">
    <div class="stat-num">100%</div>
    <div class="stat-label">Bảo mật dữ liệu</div>
  </div>
</section>

<!-- FEATURES -->
<section class="features" id="features">
  <div class="section-label fade-up">
    <h2>Đầy đủ tính năng <span class="gradient" style="background:linear-gradient(135deg,#38bdf8,#818cf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">cho nhà thuốc</span></h2>
    <p>Mọi thứ bạn cần để vận hành nhà thuốc một cách chuyên nghiệp</p>
  </div>
  <div class="features-grid">

    <div class="feat-card fade-up">
      <div class="feat-icon" style="background:rgba(37,99,235,.15);color:#60a5fa;"><i class="fas fa-pills"></i></div>
      <div class="feat-title">Quản lý thuốc</div>
      <div class="feat-desc">Tra cứu, thêm mới, cập nhật thông tin thuốc, phân loại theo danh mục, theo dõi hạn sử dụng chặt chẽ.</div>
    </div>

    <div class="feat-card fade-up">
      <div class="feat-icon" style="background:rgba(16,185,129,.15);color:#34d399;"><i class="fas fa-warehouse"></i></div>
      <div class="feat-title">Quản lý kho hàng</div>
      <div class="feat-desc">Nhập hàng, kiểm kê tồn kho, cảnh báo sắp hết hàng và thuốc gần hết hạn theo thời gian thực.</div>
    </div>

    <div class="feat-card fade-up">
      <div class="feat-icon" style="background:rgba(245,158,11,.15);color:#fbbf24;"><i class="fas fa-cash-register"></i></div>
      <div class="feat-title">Bán hàng & Hóa đơn</div>
      <div class="feat-desc">Tạo đơn bán hàng nhanh chóng, in hóa đơn, tích điểm khách hàng và quản lý chiết khấu dễ dàng.</div>
    </div>

    <div class="feat-card fade-up">
      <div class="feat-icon" style="background:rgba(139,92,246,.15);color:#a78bfa;"><i class="fas fa-users"></i></div>
      <div class="feat-title">Quản lý nhân viên</div>
      <div class="feat-desc">Phân công ca làm việc, cấp quyền truy cập theo vai trò, theo dõi lịch làm việc từng nhân viên.</div>
    </div>

    <div class="feat-card fade-up">
      <div class="feat-icon" style="background:rgba(236,72,153,.15);color:#f472b6;"><i class="fas fa-user-friends"></i></div>
      <div class="feat-title">Quản lý khách hàng</div>
      <div class="feat-desc">Lưu hồ sơ khách hàng, lịch sử mua hàng, chương trình tích điểm và chăm sóc khách hàng trung thành.</div>
    </div>

    <div class="feat-card fade-up">
      <div class="feat-icon" style="background:rgba(14,165,233,.15);color:#38bdf8;"><i class="fas fa-chart-line"></i></div>
      <div class="feat-title">Thống kê & Báo cáo</div>
      <div class="feat-desc">Biểu đồ doanh thu theo ngày/tháng/năm, báo cáo tồn kho, phân tích hiệu quả kinh doanh trực quan.</div>
    </div>

  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how" id="how">
  <div class="how-inner">
    <div class="section-label fade-up">
      <h2>Bắt đầu <span class="gradient" style="background:linear-gradient(135deg,#38bdf8,#2563eb);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">chỉ 3 bước</span></h2>
      <p>Đơn giản, nhanh chóng, không cần cài đặt phức tạp</p>
    </div>
    <div class="steps">
      <div class="step fade-up">
        <div class="step-num">1</div>
        <h3>Đăng nhập hệ thống</h3>
        <p>Sử dụng tài khoản được cấp bởi quản lý để đăng nhập vào hệ thống.</p>
      </div>
      <div class="step fade-up">
        <div class="step-num">2</div>
        <h3>Khám phá Dashboard</h3>
        <p>Xem tổng quan hoạt động nhà thuốc, doanh thu, tồn kho và thông báo quan trọng.</p>
      </div>
      <div class="step fade-up">
        <div class="step-num">3</div>
        <h3>Quản lý toàn diện</h3>
        <p>Sử dụng các module để quản lý thuốc, bán hàng, nhân viên và theo dõi báo cáo.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" id="about">
  <div class="cta-box fade-up">
    <h2>Sẵn sàng nâng cấp nhà thuốc của bạn?</h2>
    <p>Đăng nhập ngay để trải nghiệm hệ thống quản lý nhà thuốc hiện đại nhất.</p>
    <a class="btn-primary" href="<?php echo BASE_URL; ?>auth/login">
      <i class="fas fa-sign-in-alt"></i> Đăng nhập ngay
    </a>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <a class="foot-brand" href="#">
    <div class="nav-icon" style="width:30px;height:30px;"><i class="fas fa-clinic-medical" style="font-size:13px;"></i></div>
    <span>PharmaCare &copy; <?php echo date('Y'); ?></span>
  </a>
  <p>Hệ thống quản lý nhà thuốc — Bảo mật &amp; Tin cậy</p>
</footer>

<script>
// Scroll animation
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            setTimeout(() => entry.target.classList.add('visible'), i * 80);
        }
    });
}, { threshold: 0.1 });
document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const nb = document.querySelector('.navbar');
    nb.style.background = window.scrollY > 60
        ? 'rgba(10,15,30,.97)'
        : 'rgba(10,15,30,.85)';
});
</script>
</body>
</html>
