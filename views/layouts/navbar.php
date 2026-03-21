<style>
.top-navbar{background:linear-gradient(135deg,#0f4c75 0%,#1565c0 55%,#0ea5e9 100%);padding:0 24px;height:60px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:1030;box-shadow:0 3px 20px rgba(0,0,0,.25);}
.nb-brand{display:flex;align-items:center;gap:12px;text-decoration:none;flex-shrink:0;}
.nb-brand-icon{width:40px;height:40px;background:rgba(255,255,255,.18);border-radius:11px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,.25);}
.nb-brand-icon i{color:#fff;font-size:19px;}
.nb-brand-name{display:flex;flex-direction:column;line-height:1.2;}
.nb-brand-sub{font-size:10px;font-weight:600;color:rgba(255,255,255,.7);letter-spacing:1px;text-transform:uppercase;}
.nb-brand-main{font-size:17px;font-weight:900;color:#fff;letter-spacing:.8px;text-shadow:0 1px 6px rgba(0,0,0,.25);}
.nb-right{display:flex;align-items:center;gap:12px;flex-shrink:0;}
.nb-clock{display:flex;align-items:center;gap:6px;padding:5px 12px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:20px;}
.nb-clock i{color:rgba(255,255,255,.8);font-size:12px;}
.nb-clock span{font-size:12px;font-weight:600;color:rgba(255,255,255,.9);}
.nb-user-btn{display:flex;align-items:center;gap:10px;padding:6px 12px 6px 6px;border-radius:12px;background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.28);cursor:pointer;transition:all .2s;user-select:none;}
.nb-user-btn:hover{background:rgba(255,255,255,.25);border-color:rgba(255,255,255,.45);}
.nb-avatar{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#38bdf8,#2563eb);display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:800;color:#fff;flex-shrink:0;text-transform:uppercase;box-shadow:0 2px 8px rgba(37,99,235,.4);}
.nb-user-info{display:flex;flex-direction:column;line-height:1.25;}
.nb-user-name{font-size:13px;font-weight:700;color:#fff;white-space:nowrap;}
.nb-user-role{font-size:10px;color:rgba(255,255,255,.72);font-weight:500;}
.nb-chevron{font-size:10px;color:rgba(255,255,255,.65);margin-left:2px;transition:transform .2s;}
.nb-chevron.rotated{transform:rotate(180deg);}
.nb-dropdown{position:relative;}
.nb-dropdown-menu{display:none;position:absolute;right:0;top:calc(100% + 8px);background:#fff;border-radius:14px;box-shadow:0 16px 48px rgba(0,0,0,.2);min-width:240px;overflow:hidden;z-index:9999;border:1px solid #e2e8f0;}
.nb-dropdown-menu.open{display:block;animation:nbDropIn .15s ease;}
@keyframes nbDropIn{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
.nb-menu-header{padding:16px;background:linear-gradient(135deg,#1e40af,#2563eb);display:flex;align-items:center;gap:12px;}
.nb-menu-avatar{width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.22);display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:800;color:#fff;flex-shrink:0;text-transform:uppercase;border:2px solid rgba(255,255,255,.3);}
.nb-menu-name{font-size:14px;font-weight:700;color:#fff;line-height:1.3;}
.nb-menu-role{font-size:11px;color:rgba(255,255,255,.78);margin-top:2px;}
.nb-menu-item{display:flex;align-items:center;gap:12px;padding:11px 16px;font-size:13px;color:#374151;text-decoration:none;transition:background .15s;border:none;background:none;width:100%;cursor:pointer;text-align:left;}
.nb-menu-item:hover{background:#f0f7ff;color:#1d4ed8;}
.nb-item-icon{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;}
.nb-menu-item.danger{color:#dc2626;}
.nb-menu-item.danger:hover{background:#fef2f2;}
.nb-divider{height:1px;background:#f1f5f9;margin:4px 0;}
</style>

<?php
$userName     = Session::get('nhan_vien_name') ?? '';
$userRole     = Session::get('role') == 'QuanLy' ? 'Quản lý' : 'Dược sĩ';
$avatarLetter = mb_strtoupper(mb_substr($userName, 0, 1, 'UTF-8'), 'UTF-8');
?>

<div class="top-navbar">
    <a class="nb-brand" href="<?php echo BASE_URL; ?>">
        <div class="nb-brand-icon"><i class="fas fa-clinic-medical"></i></div>
        <div class="nb-brand-name">
            <span class="nb-brand-sub">Hệ thống nhà thuốc</span>
            <span class="nb-brand-main">PHARMACARE</span>
        </div>
    </a>

    <div class="nb-right">
        <div class="nb-clock">
            <i class="fas fa-clock"></i>
            <span id="nb-time">--:--:--</span>
        </div>

        <div class="nb-dropdown">
            <div class="nb-user-btn" id="nbUserBtn">
                <div class="nb-avatar"><?php echo $avatarLetter; ?></div>
                <div class="nb-user-info">
                    <span class="nb-user-name"><?php echo htmlspecialchars($userName); ?></span>
                    <span class="nb-user-role"><?php echo $userRole; ?></span>
                </div>
                <i class="fas fa-chevron-down nb-chevron" id="nbChevron"></i>
            </div>

            <div class="nb-dropdown-menu" id="nbDropMenu">
                <div class="nb-menu-header">
                    <div class="nb-menu-avatar"><?php echo $avatarLetter; ?></div>
                    <div>
                        <div class="nb-menu-name"><?php echo htmlspecialchars($userName); ?></div>
                        <div class="nb-menu-role"><?php echo $userRole; ?></div>
                    </div>
                </div>
                <div style="padding:6px 0;">
                    <a href="<?php echo BASE_URL; ?>auth/profile" class="nb-menu-item">
                        <div class="nb-item-icon" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-id-card"></i></div>
                        <div>
                            <div style="font-weight:600;">Thông tin cá nhân</div>
                            <div style="font-size:11px;color:#94a3b8;margin-top:1px;">Xem và cập nhật hồ sơ</div>
                        </div>
                    </a>
                    <a href="<?php echo BASE_URL; ?>auth/changePassword" class="nb-menu-item">
                        <div class="nb-item-icon" style="background:#f0fdf4;color:#15803d;"><i class="fas fa-key"></i></div>
                        <div>
                            <div style="font-weight:600;">Đổi mật khẩu</div>
                            <div style="font-size:11px;color:#94a3b8;margin-top:1px;">Cập nhật mật khẩu đăng nhập</div>
                        </div>
                    </a>
                    <div class="nb-divider"></div>
                    <button onclick="confirmLogout()" class="nb-menu-item danger">
                        <div class="nb-item-icon" style="background:#fef2f2;color:#dc2626;"><i class="fas fa-sign-out-alt"></i></div>
                        <div>
                            <div style="font-weight:600;">Đăng xuất</div>
                            <div style="font-size:11px;color:#fca5a5;margin-top:1px;">Thoát khỏi hệ thống</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout overlay -->
<div id="logoutOverlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);z-index:10000;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:18px;width:100%;max-width:360px;margin:0 16px;overflow:hidden;box-shadow:0 24px 64px rgba(0,0,0,.3);">
        <div style="padding:28px 24px 20px;text-align:center;border-bottom:1px solid #f1f5f9;">
            <div style="width:60px;height:60px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                <i class="fas fa-sign-out-alt" style="font-size:24px;color:#dc2626;"></i>
            </div>
            <div style="font-size:17px;font-weight:800;color:#1e293b;margin-bottom:8px;">Đăng xuất?</div>
            <div style="font-size:13px;color:#64748b;line-height:1.5;">Bạn có chắc chắn muốn thoát khỏi hệ thống không?</div>
        </div>
        <div style="padding:16px 24px;display:flex;gap:10px;">
            <button onclick="document.getElementById('logoutOverlay').style.display='none'"
                style="flex:1;padding:11px;border-radius:10px;font-size:13px;font-weight:600;background:#f1f5f9;color:#64748b;border:1.5px solid #e2e8f0;cursor:pointer;"
                onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                <i class="fas fa-arrow-left" style="margin-right:5px;"></i>Ở lại
            </button>
            <a href="<?php echo BASE_URL; ?>auth/logout"
                style="flex:1;padding:11px;border-radius:10px;font-size:13px;font-weight:700;background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:7px;box-shadow:0 4px 14px rgba(220,38,38,.35);">
                <i class="fas fa-sign-out-alt"></i> Đăng xuất
            </a>
        </div>
    </div>
</div>

<script>
(function(){
    var btn  = document.getElementById('nbUserBtn');
    var menu = document.getElementById('nbDropMenu');
    var chev = document.getElementById('nbChevron');
    btn.addEventListener('click', function(e){
        e.stopPropagation();
        var isOpen = menu.classList.toggle('open');
        chev.classList.toggle('rotated', isOpen);
    });
    document.addEventListener('click', function(e){
        if(!menu.contains(e.target) && !btn.contains(e.target)){
            menu.classList.remove('open');
            chev.classList.remove('rotated');
        }
    });
    function tick(){
        var now = new Date();
        document.getElementById('nb-time').textContent =
            String(now.getHours()).padStart(2,'0')+':'+
            String(now.getMinutes()).padStart(2,'0')+':'+
            String(now.getSeconds()).padStart(2,'0');
    }
    tick(); setInterval(tick,1000);
})();
function confirmLogout(){
    document.getElementById('nbDropMenu').classList.remove('open');
    document.getElementById('nbChevron').classList.remove('rotated');
    document.getElementById('logoutOverlay').style.display='flex';
}
document.getElementById('logoutOverlay').addEventListener('click',function(e){
    if(e.target===this) this.style.display='none';
});
</script>
