<div class="content-wrapper">

<?php if (Session::get('login_success')): ?>
    <style>
        .glass-toast-home {
            position: fixed;
            top: 64px; 
            right: 24px;
            width: max-content;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12), 0 5px 15px rgba(0, 0, 0, 0.06);
            padding: 18px 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            z-index: 9999999;
            font-family: 'Inter', sans-serif;
            transform: translateX(120%);
            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
        }

        .glass-toast-home.show {
            transform: translateX(0);
        }

        .toast-icon-wrapper-home {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #38bdf8, #0ea5e9);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35);
        }

        .toast-icon-wrapper-home i {
            color: #ffffff;
            font-size: 18px;
        }

        .toast-text-content-home {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-top: -1px;
        }

        .toast-text-title-home {
            font-size: 15px;
            font-weight: 800;
            color: #1f2937;
            letter-spacing: 0.2px;
        }

        .toast-text-msg-home {
            font-size: 13.5px;
            color: #4b5563;
            line-height: 1.5;
        }

        .toast-progress-home {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, #38bdf8, #0ea5e9);
            width: 100%;
            transform-origin: left;
            animation: progressShrinkHome 4s linear forwards;
        }

        @keyframes progressShrinkHome {
            0% { transform: scaleX(1); }
            100% { transform: scaleX(0); }
        }
    </style>

    <div id="loginToast" class="glass-toast-home">
        <div class="toast-icon-wrapper-home">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="toast-text-content-home">
            <div class="toast-text-title-home">Chào mừng trở lại!</div>
            <div class="toast-text-msg-home"><?php echo Session::get('login_success'); ?></div>
        </div>
        <div class="toast-progress-home"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('loginToast');
            if (toast) {
                setTimeout(() => toast.classList.add('show'), 150);
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => toast.remove(), 600);
                }, 4000);
            }
        });
    </script>
    <?php Session::set('login_success', null); ?>
<?php endif; ?>

<!-- Header -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;margin-bottom:16px;">
  <div style="padding:16px 22px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;">
    <div style="width:40px;height:40px;background:rgba(255,255,255,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
      <i class="fas fa-tachometer-alt" style="color:#fff;font-size:18px;"></i>
    </div>
    <div>
      <div style="font-size:18px;font-weight:900;color:#fff;text-transform:uppercase;letter-spacing:.6px;">Dashboard Dược Sĩ</div>
      <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px;">
        <i class="fas fa-calendar me-1"></i><?php echo date('d/m/Y H:i'); ?> &nbsp;·&nbsp;
        <i class="fas fa-user me-1"></i><?php echo htmlspecialchars(Session::get('nhan_vien_name')); ?>
      </div>
    </div>
  </div>
</div>

<!-- Stat cards -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px;margin-bottom:16px;">
  <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
    <div style="padding:16px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;justify-content:space-between;">
      <div>
        <div style="font-size:11px;font-weight:700;color:rgba(255,255,255,.8);text-transform:uppercase;letter-spacing:.5px;">Hóa đơn hôm nay</div>
        <div id="todayInvoices" style="font-size:28px;font-weight:900;color:#fff;margin-top:4px;">--</div>
      </div>
      <div style="width:44px;height:44px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-receipt" style="color:#fff;font-size:20px;"></i>
      </div>
    </div>
    <div style="padding:8px 20px;background:#f0f7ff;border-top:1px solid #dbeafe;">
      <a href="<?php echo BASE_URL; ?>sale/history" style="font-size:12px;color:#1d4ed8;text-decoration:none;font-weight:600;">Xem lịch sử →</a>
    </div>
  </div>

  <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
    <div style="padding:16px 20px;background:linear-gradient(135deg,#15803d,#16a34a);display:flex;align-items:center;justify-content:space-between;">
      <div>
        <div style="font-size:11px;font-weight:700;color:rgba(255,255,255,.8);text-transform:uppercase;letter-spacing:.5px;">Doanh thu hôm nay</div>
        <div id="todayRevenue" style="font-size:22px;font-weight:900;color:#fff;margin-top:4px;">--</div>
      </div>
      <div style="width:44px;height:44px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-chart-line" style="color:#fff;font-size:20px;"></i>
      </div>
    </div>
    <div style="padding:8px 20px;background:#f0fdf4;border-top:1px solid #bbf7d0;">
      <span style="font-size:12px;color:#15803d;font-weight:600;">Ca làm việc hôm nay</span>
    </div>
  </div>

  <div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
    <div style="padding:16px 20px;background:linear-gradient(135deg,#b45309,#d97706);display:flex;align-items:center;justify-content:space-between;">
      <div>
        <div style="font-size:11px;font-weight:700;color:rgba(255,255,255,.8);text-transform:uppercase;letter-spacing:.5px;">Thuốc sắp hết</div>
        <div id="lowStock" style="font-size:28px;font-weight:900;color:#fff;margin-top:4px;">--</div>
      </div>
      <div style="width:44px;height:44px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
        <i class="fas fa-exclamation-triangle" style="color:#fff;font-size:20px;"></i>
      </div>
    </div>
    <div style="padding:8px 20px;background:#fffbeb;border-top:1px solid #fde68a;">
      <span style="font-size:12px;color:#b45309;font-weight:600;">Cần chú ý</span>
    </div>
  </div>
</div>

<!-- Quick access -->
<div style="background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.07);overflow:hidden;">
  <div style="padding:14px 20px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:10px;">
    <i class="fas fa-bolt" style="color:#fff;font-size:15px;"></i>
    <span style="font-size:14px;font-weight:700;color:#fff;">Truy cập nhanh</span>
  </div>
  <div style="padding:18px 20px;display:flex;flex-wrap:wrap;gap:10px;">
    <a href="<?php echo BASE_URL; ?>sale/create" style="padding:9px 18px;border-radius:9px;border:none;background:linear-gradient(135deg,#15803d,#16a34a);color:#fff;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:7px;box-shadow:0 4px 10px rgba(21,128,61,.3);">
      <i class="fas fa-cash-register"></i> Bán hàng
    </a>
    <a href="<?php echo BASE_URL; ?>sale/history" style="padding:9px 18px;border-radius:9px;border:1.5px solid #bfdbfe;background:#eff6ff;color:#1d4ed8;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:7px;">
      <i class="fas fa-receipt"></i> Lịch sử hóa đơn
    </a>
    <a href="<?php echo BASE_URL; ?>medicine/index" style="padding:9px 18px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#374151;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:7px;">
      <i class="fas fa-pills"></i> Tra cứu thuốc
    </a>
    <a href="<?php echo BASE_URL; ?>customer/index" style="padding:9px 18px;border-radius:9px;border:1.5px solid #e2e8f0;background:#f8fafc;color:#374151;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:7px;">
      <i class="fas fa-user-friends"></i> Khách hàng
    </a>
  </div>
</div>

</div>

<script>
$.get('<?php echo BASE_URL; ?>home/stats', function(d) {
    if (!d) return;
    if (d.todayInvoices !== undefined) $('#todayInvoices').text(d.todayInvoices);
    if (d.todayRevenue !== undefined) $('#todayRevenue').text(new Intl.NumberFormat('vi-VN').format(d.todayRevenue) + 'đ');
    if (d.lowStock !== undefined) $('#lowStock').text(d.lowStock);
}, 'json');
</script>
