<!DOCTYPE html>
<html lang="en">
<head>
    <title>System Info</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="../../Resource/packages/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="../../Resource/packages/adminlte-dist/css/AdminLTE.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="../../Resource/packages/adminlte-dist/css/skins/_all-skins.min.css" rel="stylesheet">
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
</head>
<body>
<section class="content">
    <div class="panel">
        <div class="panel-heading">
            <h3>Installed Trunk</h3>
            <form action="installer.php?type=install" method="post" enctype="multipart/form-data">
                <div style="border: 1px solid black;padding: 5px">
                    <label class="control-label">Install New Trunk</label>
                    <input name="file" type="file">
                    <button type="submit" class="btn btn-primary" style="float: right">Install</button>
                    <div style="clear: both"></div>
                </div>
            </form>
        </div>
        <div class="panel-body" style="overflow-y:scroll">
            <table class="table">
                <thead>
                    <tr>
                        <td>
                            TrunkName
                        </td>
                        <td>
                            TrunkAuthor
                        </td>
                        <td>
                            TrunkVersion
                        </td>
                        <td>
                            Install Time
                        </td>
                        <td>
                            Description
                        </td>
                    </tr>
                </thead>
                <tbody>
                <{foreach from=$trunks item=trunk}>
                    <tr>
                        <td>
                            <{$trunk.name}>
                        </td>
                        <td>
                            <{$trunk.author}>
                        </td>
                        <td>
                            <{$trunk.version}>
                        </td>
                        <td>
                            <{$trunk.install_time|date_format:'%Y-%m-%d %H:%M:%S'}>
                        </td>
                        <td>
                            <{$trunk.description}>
                        </td>
                    </tr>
                    <{/foreach}>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="../../Resource/packages/jquery-2.2.0-dist/jquery-2.2.0.min.js"></script>
<script src="../../Resource/packages/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="../../Resource/packages/fastclick/js/fastclick.min.js"></script>
<script src="../../Resource/packages/echart-dist/echarts.min.js"></script>
<script src="../../Resource/packages/adminlte-dist/js/app.min.js"></script>
</body>
</html>