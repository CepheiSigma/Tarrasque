<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Tarrasque's Console</title>
    <link href="Resource/packages/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="Resource/packages/adminlte-dist/css/AdminLTE.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="Resource/packages/adminlte-dist/css/skins/_all-skins.min.css" rel="stylesheet">
</head>
<body class="skin-blue sidebar-mini">
<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Tarrasque</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
    </nav>
</header>
<div class="wrapper">
    <!--left-panel start-->
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="treeview">
                    <a href="#" data-url="SystemInfo.html">
                        <i class="fa fa-linux"></i>
                        <span>System Info</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span>Trunks</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu" style="display: none">
                        <li><a><i class="fa fa-cubes"></i>Test</a></li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>
    <!--left-panel end-->
    <div class="content-wrapper">
        <iframe id="right_frame" class="col-sm-12" style="border: 0;height: 100%;padding: 0">

        </iframe>
    </div>
</div>
<script src="Resource/packages/jquery-2.2.0-dist/jquery-2.2.0.min.js"></script>
<script src="Resource/packages/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="Resource/packages/fastclick/js/fastclick.min.js"></script>
<script src="Resource/packages/adminlte-dist/js/app.min.js"></script>
<script src="Resource/javascript/view_index.js"></script>
</body>
</html>