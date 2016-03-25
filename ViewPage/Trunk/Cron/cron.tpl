<!DOCTYPE html>
<html lang="en">
<head>
    <title>Task List</title>
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
            <h3>Task List</h3>
            <form action="cron.php.php?type=changeStep" method="post">
                <div style="border: 1px solid black;padding: 5px">
                    <label class="control-label">Cron Step Length</label>
                    <input class="form-control" name="step"/>
                    <button type="submit" class="btn btn-primary" style="float: right">保存</button>
                    <div style="clear: both"></div>
                </div>
            </form>
        </div>
        <div class="panel-body" style="overflow-y:scroll">
            <table class="table">
                <thead>
                <tr>
                    <td>
                        TaskName
                    </td>
                    <td>
                        Trunk Class
                    </td>
                    <td>
                        Method
                    </td>
                    <td>
                        NextExecTime
                    </td>
                </tr>
                </thead>
                <tbody>
                <{foreach from=$tasks item=task }>
                    <tr>
                        <td>
                            <{$task.name}>
                        </td>
                        <td>
                            <{$task.plugin}>
                        </td>
                        <td>
                            <{$task.method}>
                        </td>
                        <td>
                            <{($smarty.now+$task.lefttime)|date_format:'%Y-%m-%d %H:%M:%S'}>
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