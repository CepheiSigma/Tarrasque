<!DOCTYPE html>
<html lang="en">
<head>
    <title>System Info</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="Resource/packages/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="Resource/packages/adminlte-dist/css/AdminLTE.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="Resource/packages/adminlte-dist/css/skins/_all-skins.min.css" rel="stylesheet">
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
</head>
<body>
<section class="content">
    <div class="row" style="padding: 0.8em">
        <h3>System Info</h3>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">CPU</span>
                    <span class="info-box-number"><{$info.cpus[0].name}></span>
                    <span><small><{$info.cpus[0].corenumber}></small></span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="<{if $info.os.type=="Windows"}>
                    ion-social-windows
                    <{elseif $info.os.type=="Mac OS X"}>
                    ion-social-apple
                    <{elseif $info.os.type=="Linux" }>
                    ion-social-tux
                <{/if}>"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">OS</span>
                    <span id="os-identifier" class="info-box-number"><{$info.os.name}></span>
                    <span><small><{$info.os.version}></small></span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-social-buffer"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Memory</span>
                    <span class="info-box-number"><{$info.memory.size}></span>
                    <span><small><{$info.memory.type}></small></span>
                </div>
            </div>
        </div>


    </div>
    <div class="row" style="padding: 0.8em">
        <h3>System Usage</h3>
        <div class="col-md-8" style="padding: 0.8em;height:315px">
            <div id="chart_container" style="width: 100%;height:315px;color: red"></div>
        </div>
        <div class="col-md-4" style="padding: 0.8em">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion-ios-gear-outline"></i></span>
                <div id="cpu-usage" class="info-box-content">
                    <span class="info-box-text">CPU Usage</span>
                    <span class="info-box-number">86.8 %</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 86.8%"></div>
                    </div>
                </div><!-- /.info-box-content -->
            </div>
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="ion-social-buffer-outline"></i></span>
                <div id="phymemory-usage" class="info-box-content">
                    <span class="info-box-text">Physical Memory Usage</span>
                    <span class="info-box-number">76.4 %</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 76.4%"></div>
                    </div>
                </div><!-- /.info-box-content -->
            </div>
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="ion-social-buffer-outline"></i></span>
                <div id="realmemory-usage" class="info-box-content">
                    <span class="info-box-text">Real Memory Usage</span>
                    <span class="info-box-number">46.8 %</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 46.8%"></div>
                    </div>
                </div><!-- /.info-box-content -->
            </div>
        </div>
    </div>
    <div class="row" style="padding: 0.8em">
        <h3>Disk Usage</h3>
        <{foreach from=$info.disks item=disk}>
        <div class="info-box bg-teal">
            <span class="info-box-icon"><i class="ion-ios-pie-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text"><{$disk.name}></span>
                <span class="info-box-number"><{$disk.percent}> %</span>
                <div class="progress">
                    <div class="progress-bar" style="width:<{$disk.percent}>%"></div>
                </div>
            </div><!-- /.info-box-content -->
        </div>
        <{/foreach}>
    </div>
</section>

<script src="Resource/packages/jquery-2.2.0-dist/jquery-2.2.0.min.js"></script>
<script src="Resource/packages/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="Resource/packages/fastclick/js/fastclick.min.js"></script>
<script src="Resource/packages/echart-dist/echarts.min.js"></script>
<script src="Resource/packages/adminlte-dist/js/app.min.js"></script>
<script src="Resource/javascript/view/view_systeminfo.js"></script>
</body>
</html>