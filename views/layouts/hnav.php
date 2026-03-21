<?php
$cur     = strtolower(trim($_GET['url'] ?? '', '/'));
$isAdmin = Session::get('role') == 'QuanLy';

if ($cur===''||strpos($cur,'home')!==false)                                $activeGroup='home';
elseif(strpos($cur,'medicine')!==false||strpos($cur,'category')!==false)  $activeGroup='medicine';
elseif(strpos($cur,'warehouse')!==false)                                   $activeGroup='warehouse';
elseif(strpos($cur,'supplier')!==false)                                    $activeGroup='supplier';
elseif(strpos($cur,'employee')!==false)                                    $activeGroup='employee';
elseif(strpos($cur,'sale')!==false)                                        $activeGroup='sale';
elseif(strpos($cur,'customer')!==false)                                    $activeGroup='customer';
elseif(strpos($cur,'statistic')!==false)                                   $activeGroup='statistic';
else                                                                        $activeGroup='home';

// Màu cho từng tab theo thứ tự xuất hiện trong mỗi nhóm
$colors = [
    ['bg'=>'#15803d','hover'=>'#166534'],  // xanh lá
    ['bg'=>'#b45309','hover'=>'#92400e'],  // cam
    ['bg'=>'#7c3aed','hover'=>'#6d28d9'],  // tím
    ['bg'=>'#0e7490','hover'=>'#155e75'],  // xanh dương
    ['bg'=>'#be185d','hover'=>'#9d174d'],  // hồng
];
?>
<style>
.subnav-bar{
    background:transparent;
    border-bottom:none;
    position:relative;
    top:0;
    z-index:1;
}
.subnav-inner{display:flex;align-items:center;gap:8px;padding:8px 20px;overflow-x:auto;scrollbar-width:none;flex-wrap:nowrap;}
.subnav-inner::-webkit-scrollbar{display:none;}
.subnav-panel{display:none;align-items:center;gap:8px;animation:snFadeIn .15s ease;}
.subnav-panel.active{display:flex;}
@keyframes snFadeIn{from{opacity:0;transform:translateY(-3px)}to{opacity:1;transform:translateY(0)}}
.sn-tab{
    display:inline-flex;align-items:center;gap:8px;
    padding:8px 20px;border-radius:9px;
    font-size:13.5px;font-weight:700;
    text-decoration:none;white-space:nowrap;
    color:#fff;flex-shrink:0;
    transition:filter .15s,transform .1s;
    box-shadow:0 3px 8px rgba(0,0,0,.25);
}
.sn-tab:hover{filter:brightness(1.15);transform:translateY(-1px);color:#fff;}
.sn-tab.active{filter:brightness(1.2);box-shadow:0 4px 12px rgba(0,0,0,.35);transform:translateY(-1px);}
.sn-tab i{font-size:13px;}
</style>

<div class="subnav-bar" id="subnavBar">
    <div class="subnav-inner">

        <!-- Home -->
        <div class="subnav-panel <?php echo $activeGroup==='home'?'active':''; ?>" id="snp-home">
            <?php if($isAdmin): ?>
            <a href="<?php echo BASE_URL; ?>home/admin"
               class="sn-tab <?php echo strpos($cur,'home/admin')!==false||$cur===''?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <?php else: ?>
            <a href="<?php echo BASE_URL; ?>home/employee"
               class="sn-tab <?php echo strpos($cur,'home/employee')!==false||$cur===''?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <?php endif; ?>
        </div>

        <?php if($isAdmin): ?>

        <!-- Quản lý thuốc -->
        <div class="subnav-panel <?php echo $activeGroup==='medicine'?'active':''; ?>" id="snp-medicine">
            <a href="<?php echo BASE_URL; ?>medicine/index"
               class="sn-tab <?php echo strpos($cur,'medicine/index')!==false||strpos($cur,'medicine/search')!==false?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-list"></i> Danh s&#225;ch thu&#7889;c
            </a>
            <a href="<?php echo BASE_URL; ?>medicine/updatePrice"
               class="sn-tab <?php echo strpos($cur,'updateprice')!==false?'active':''; ?>"
               style="background:<?php echo $colors[1]['bg']; ?>;">
                <i class="fas fa-tag"></i> C&#7853;p nh&#7853;t gi&#225;
            </a>
            <a href="<?php echo BASE_URL; ?>medicine/updateUnit"
               class="sn-tab <?php echo strpos($cur,'updateunit')!==false?'active':''; ?>"
               style="background:<?php echo $colors[2]['bg']; ?>;">
                <i class="fas fa-cubes"></i> &#272;&#417;n v&#7883; l&#7867;
            </a>
            <a href="<?php echo BASE_URL; ?>category/index"
               class="sn-tab <?php echo strpos($cur,'category')!==false?'active':''; ?>"
               style="background:<?php echo $colors[3]['bg']; ?>;">
                <i class="fas fa-th-large"></i> Danh m&#7909;c
            </a>
        </div>

        <!-- Kho -->
        <div class="subnav-panel <?php echo $activeGroup==='warehouse'?'active':''; ?>" id="snp-warehouse">
            <a href="<?php echo BASE_URL; ?>warehouse/stock"
               class="sn-tab <?php echo strpos($cur,'warehouse/stock')!==false?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-boxes"></i> T&#7891;n kho
            </a>
            <?php if(strpos($cur,'warehouse/stock')!==false): ?>
            <a href="javascript:void(0)" onclick="document.getElementById('importModal').style.display='flex'"
               class="sn-tab"
               style="background:<?php echo $colors[1]['bg']; ?>;">
                <i class="fas fa-file-import"></i> Nh&#7853;p kho
            </a>
            <?php else: ?>
            <a href="<?php echo BASE_URL; ?>warehouse/stock"
               class="sn-tab <?php echo strpos($cur,'warehouse/import')!==false?'active':''; ?>"
               style="background:<?php echo $colors[1]['bg']; ?>;">
                <i class="fas fa-file-import"></i> Nh&#7853;p kho
            </a>
            <?php endif; ?>
            <a href="<?php echo BASE_URL; ?>warehouse/history"
               class="sn-tab <?php echo strpos($cur,'warehouse/history')!==false?'active':''; ?>"
               style="background:<?php echo $colors[3]['bg']; ?>;">
                <i class="fas fa-history"></i> L&#7883;ch s&#7917; nh&#7853;p xu&#7845;t
            </a>
            <a href="<?php echo BASE_URL; ?>warehouse/alert"
               class="sn-tab <?php echo strpos($cur,'warehouse/alert')!==false?'active':''; ?>"
               style="background:#dc2626;">
                <i class="fas fa-exclamation-triangle"></i> C&#7843;nh b&#225;o thu&#7889;c
            </a>
        </div>

        <!-- Nhà cung cấp -->
        <div class="subnav-panel <?php echo $activeGroup==='supplier'?'active':''; ?>" id="snp-supplier">
            <a href="<?php echo BASE_URL; ?>supplier/index"
               class="sn-tab <?php echo strpos($cur,'supplier/index')!==false?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-list"></i> Danh s&#225;ch NCC
            </a>
            <a href="<?php echo BASE_URL; ?>supplier/add"
               class="sn-tab <?php echo strpos($cur,'supplier/add')!==false?'active':''; ?>"
               style="background:<?php echo $colors[1]['bg']; ?>;">
                <i class="fas fa-plus-circle"></i> Th&#234;m NCC
            </a>
        </div>

        <!-- Nhân viên -->
        <div class="subnav-panel <?php echo $activeGroup==='employee'?'active':''; ?>" id="snp-employee">
            <a href="<?php echo BASE_URL; ?>employee/index"
               class="sn-tab <?php echo strpos($cur,'employee/index')!==false?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-id-badge"></i> Qu&#7843;n l&#253; t&#224;i kho&#7843;n
            </a>
            <a href="<?php echo BASE_URL; ?>employee/workshift"
               class="sn-tab <?php echo strpos($cur,'workshift')!==false?'active':''; ?>"
               style="background:<?php echo $colors[3]['bg']; ?>;">
                <i class="fas fa-calendar-alt"></i> L&#7883;ch l&#224;m vi&#7879;c
            </a>
        </div>

        <!-- Bán hàng -->
        <div class="subnav-panel <?php echo $activeGroup==='sale'?'active':''; ?>" id="snp-sale">
            <a href="<?php echo BASE_URL; ?>sale/create"
               class="sn-tab <?php echo strpos($cur,'sale/create')!==false?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-cash-register"></i> T&#7841;o h&#243;a &#273;&#417;n
            </a>
            <a href="<?php echo BASE_URL; ?>sale/history"
               class="sn-tab <?php echo strpos($cur,'sale/history')!==false?'active':''; ?>"
               style="background:<?php echo $colors[3]['bg']; ?>;">
                <i class="fas fa-receipt"></i> L&#7883;ch s&#7917; b&#225;n h&#224;ng
            </a>
        </div>

        <!-- Khách hàng -->
        <div class="subnav-panel <?php echo $activeGroup==='customer'?'active':''; ?>" id="snp-customer">
            <a href="<?php echo BASE_URL; ?>customer/index"
               class="sn-tab <?php echo strpos($cur,'customer/index')!==false?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-list"></i> Danh s&#225;ch kh&#225;ch h&#224;ng
            </a>
            <a href="<?php echo BASE_URL; ?>customer/add"
               class="sn-tab <?php echo strpos($cur,'customer/add')!==false?'active':''; ?>"
               style="background:<?php echo $colors[1]['bg']; ?>;">
                <i class="fas fa-user-plus"></i> Th&#234;m kh&#225;ch h&#224;ng
            </a>
        </div>

        <!-- Thống kê -->
        <div class="subnav-panel <?php echo $activeGroup==='statistic'?'active':''; ?>" id="snp-statistic">
            <a href="<?php echo BASE_URL; ?>statistic/revenue"
               class="sn-tab <?php echo strpos($cur,'statistic/revenue')!==false?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-chart-line"></i> Doanh thu
            </a>
            <a href="<?php echo BASE_URL; ?>statistic/bestSelling"
               class="sn-tab <?php echo strpos($cur,'bestselling')!==false?'active':''; ?>"
               style="background:<?php echo $colors[1]['bg']; ?>;">
                <i class="fas fa-fire"></i> Thu&#7889;c b&#225;n ch&#7841;y
            </a>
        </div>

        <?php else: ?>

        <div class="subnav-panel <?php echo $activeGroup==='sale'?'active':''; ?>" id="snp-sale">
            <a href="<?php echo BASE_URL; ?>sale/create"
               class="sn-tab <?php echo strpos($cur,'sale/create')!==false?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-cash-register"></i> T&#7841;o h&#243;a &#273;&#417;n
            </a>
            <a href="<?php echo BASE_URL; ?>sale/history"
               class="sn-tab <?php echo strpos($cur,'sale/history')!==false?'active':''; ?>"
               style="background:<?php echo $colors[3]['bg']; ?>;">
                <i class="fas fa-receipt"></i> L&#7883;ch s&#7917; b&#225;n h&#224;ng
            </a>
        </div>
        <div class="subnav-panel <?php echo $activeGroup==='medicine'?'active':''; ?>" id="snp-medicine">
            <a href="<?php echo BASE_URL; ?>medicine/index"
               class="sn-tab active" style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-pills"></i> Tra c&#7913;u thu&#7889;c
            </a>
        </div>
        <div class="subnav-panel <?php echo $activeGroup==='customer'?'active':''; ?>" id="snp-customer">
            <a href="<?php echo BASE_URL; ?>customer/index"
               class="sn-tab <?php echo strpos($cur,'customer/index')!==false?'active':''; ?>"
               style="background:<?php echo $colors[0]['bg']; ?>;">
                <i class="fas fa-list"></i> Danh s&#225;ch kh&#225;ch h&#224;ng
            </a>
        </div>

        <?php endif; ?>
    </div>
</div>

<script>
function switchSubnav(group) {
    document.querySelectorAll('.subnav-panel').forEach(function(p){ p.classList.remove('active'); });
    var panel = document.getElementById('snp-' + group);
    if (panel) panel.classList.add('active');
    document.querySelectorAll('.sb-menu li a').forEach(function(a){ a.classList.remove('active'); });
    var sa = document.querySelector('.sb-menu li a[data-group="' + group + '"]');
    if (sa) sa.classList.add('active');
}
</script>
