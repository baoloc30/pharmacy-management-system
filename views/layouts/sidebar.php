<?php
$cur     = strtolower(trim($_GET['url'] ?? '', '/'));
$isAdmin = Session::get('role') == 'QuanLy';

if ($cur===''||strpos($cur,'home')!==false)                                $ag='home';
elseif(strpos($cur,'medicine')!==false||strpos($cur,'category')!==false)  $ag='medicine';
elseif(strpos($cur,'warehouse')!==false)                                   $ag='warehouse';
elseif(strpos($cur,'supplier')!==false)                                    $ag='supplier';
elseif(strpos($cur,'employee')!==false)                                    $ag='employee';
elseif(strpos($cur,'sale')!==false)                                        $ag='sale';
elseif(strpos($cur,'customer')!==false)                                    $ag='customer';
elseif(strpos($cur,'statistic')!==false)                                   $ag='statistic';
else                                                                        $ag='home';
?>
<style>
.sidebar{
    width:190px;min-height:calc(100vh - 60px);
    background:linear-gradient(180deg,#0f2d4a 0%,#1a3a5c 40%,#1e4976 100%);
    flex-shrink:0;display:flex;flex-direction:column;
    position:sticky;top:60px;height:calc(100vh - 60px);
    overflow-y:auto;scrollbar-width:none;
    box-shadow:3px 0 20px rgba(0,0,0,.3);z-index:10;
}
.sidebar::-webkit-scrollbar{display:none;}
.sb-top{padding:13px 16px 9px;border-bottom:1px solid rgba(255,255,255,.08);}
.sb-top-label{font-size:9px;font-weight:800;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:2.5px;}
.sb-menu{list-style:none;padding:4px 0 20px;margin:0;flex:1;}
.sb-menu li.sl{
    padding:14px 16px 5px;
    font-size:9px;font-weight:800;
    color:rgba(255,255,255,.3);
    text-transform:uppercase;letter-spacing:2px;
}
.sb-menu li a{
    display:flex;align-items:center;gap:10px;
    padding:9px 16px;
    color:rgba(255,255,255,.7);
    text-decoration:none;font-size:13px;font-weight:500;
    border-left:3px solid transparent;
    transition:all .18s;
}
.sb-menu li a i{
    width:17px;font-size:13px;flex-shrink:0;
    color:rgba(255,255,255,.45);transition:color .18s;
}
.sb-menu li a:hover{
    background:rgba(255,255,255,.1);
    color:#fff;border-left-color:rgba(255,255,255,.5);
}
.sb-menu li a:hover i{color:#fff;}
.sb-menu li a.active{
    background:rgba(255,255,255,.15);
    color:#fff;border-left-color:#38bdf8;font-weight:700;
}
.sb-menu li a.active i{color:#38bdf8;}
</style>

<div class="sidebar">
    <div class="sb-top">
        <div class="sb-top-label">Menu ch&#7913;c n&#259;ng</div>
    </div>
    <ul class="sb-menu">
        <?php if($isAdmin): ?>

        <li>
            <a href="<?php echo BASE_URL; ?>home/admin"
               class="<?php echo $ag==='home'?'active':''; ?>"
               onclick="switchSubnav('home')">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>

        <li class="sl">Qu&#7843;n l&#253;</li>

        <li>
            <a href="<?php echo BASE_URL; ?>medicine/index"
               class="<?php echo $ag==='medicine'?'active':''; ?>"
               onclick="switchSubnav('medicine')">
                <i class="fas fa-pills"></i> Qu&#7843;n l&#253; thu&#7889;c
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL; ?>warehouse/stock"
               class="<?php echo $ag==='warehouse'?'active':''; ?>"
               onclick="switchSubnav('warehouse')">
                <i class="fas fa-warehouse"></i> Qu&#7843;n l&#253; kho
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL; ?>supplier/index"
               class="<?php echo $ag==='supplier'?'active':''; ?>"
               onclick="switchSubnav('supplier')">
                <i class="fas fa-truck"></i> Nh&#224; cung c&#7845;p
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL; ?>employee/index"
               class="<?php echo $ag==='employee'?'active':''; ?>"
               onclick="switchSubnav('employee')">
                <i class="fas fa-users"></i> Nh&#226;n vi&#234;n
            </a>
        </li>

        <li class="sl">B&#225;n h&#224;ng</li>

        <li>
            <a href="<?php echo BASE_URL; ?>sale/create"
               class="<?php echo $ag==='sale'?'active':''; ?>"
               onclick="switchSubnav('sale')">
                <i class="fas fa-cash-register"></i> B&#225;n h&#224;ng
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL; ?>customer/index"
               class="<?php echo $ag==='customer'?'active':''; ?>"
               onclick="switchSubnav('customer')">
                <i class="fas fa-user-friends"></i> Kh&#225;ch h&#224;ng
            </a>
        </li>

        <li class="sl">Th&#7889;ng k&#234;</li>

        <li>
            <a href="<?php echo BASE_URL; ?>statistic/revenue"
               class="<?php echo $ag==='statistic'?'active':''; ?>"
               onclick="switchSubnav('statistic')">
                <i class="fas fa-chart-line"></i> Th&#7889;ng k&#234;
            </a>
        </li>

        <?php else: ?>

        <li>
            <a href="<?php echo BASE_URL; ?>home/employee"
               class="<?php echo $ag==='home'?'active':''; ?>"
               onclick="switchSubnav('home')">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>

        <li class="sl">B&#225;n h&#224;ng</li>

        <li>
            <a href="<?php echo BASE_URL; ?>sale/create"
               class="<?php echo $ag==='sale'?'active':''; ?>"
               onclick="switchSubnav('sale')">
                <i class="fas fa-cash-register"></i> B&#225;n h&#224;ng
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL; ?>medicine/index"
               class="<?php echo $ag==='medicine'?'active':''; ?>"
               onclick="switchSubnav('medicine')">
                <i class="fas fa-pills"></i> Tra c&#7913;u thu&#7889;c
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL; ?>customer/index"
               class="<?php echo $ag==='customer'?'active':''; ?>"
               onclick="switchSubnav('customer')">
                <i class="fas fa-user-friends"></i> Kh&#225;ch h&#224;ng
            </a>
        </li>

        <?php endif; ?>
    </ul>
</div>
