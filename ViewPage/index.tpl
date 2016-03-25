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
<div class="wrapper" style="padding-top: 0">
    <div class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Tarrasque</b></span>
        </a>
    </div>
    <!--left-panel start-->
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="treeview">
                    <a href="#" data-url="systeminfo.php">
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
                        <{foreach from=$trunks item=trunk}>
                        <{if $trunk.manager_url!=""}>
                        <li><a href="#" data-url="<{$trunk.manager_url}>"><i class="fa fa-cubes"></i><{$trunk.name}></a></li>
                        <{/if}>
                        <{/foreach}>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>
    <!--left-panel end-->
    <div class="content-wrapper">
        <iframe id="right_frame" class="col-sm-12" style="border: 0;padding: 0">

        </iframe>
    </div>
</div>
<script src="Resource/packages/jquery-2.2.0-dist/jquery-2.2.0.min.js"></script>
<script src="Resource/packages/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="Resource/packages/fastclick/js/fastclick.min.js"></script>
<script src="Resource/packages/adminlte-dist/js/app.min.js"></script>
<script src="Resource/javascript/view/view_index.js"></script>
</body>
</html>