<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'H&#7879; th&#7889;ng qu&#7843;n l&#253; nh&#224; thu&#7889;c'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;}
        body{display:flex;flex-direction:column;min-height:100vh;background:linear-gradient(135deg,#0f4c75 0%,#1565c0 50%,#0ea5e9 100%);font-family:'Inter',sans-serif;margin:0;padding:0;}
        body.bg-loaded{background-image:url('<?php echo BASE_URL; ?>assets/images/bg_main.jpg');background-size:cover;background-position:center;background-attachment:fixed;}
        body::before{content:'';position:fixed;inset:0;background:rgba(15,40,80,.55);z-index:0;pointer-events:none;}
        body.bg-loaded::before{background:rgba(220,232,255,.6);}
        .top-navbar,.page-body{position:relative;z-index:1;}

        /* sidebar styles are in sidebar.php */

        /* subnav styles in hnav.php */

        /* ===== PAGE BODY ===== */
        .page-body{display:flex;flex:1;align-items:flex-start;}
        .right-col{flex:1;display:flex;flex-direction:column;min-width:0;}
        .main-content{flex:1;padding:0;overflow-x:auto;min-width:0;}
        .content-wrapper{padding:16px 20px;}

        /* Cards */
        .card{border:none;box-shadow:0 2px 14px rgba(0,0,0,.07);border-radius:14px;margin-bottom:20px;}
        .card-header{background:#fff;border-bottom:1px solid #e2e8f0;font-weight:600;border-radius:14px 14px 0 0 !important;}
    </style>
</head>
<body>
<?php if(Session::get('logged_in')): ?>
    <?php include __DIR__ . '/navbar.php'; ?>
    <div class="page-body">
        <?php include __DIR__ . '/sidebar.php'; ?>
        <div class="right-col">
            <?php include __DIR__ . '/hnav.php'; ?>
            <div class="main-content">
<?php endif; ?>