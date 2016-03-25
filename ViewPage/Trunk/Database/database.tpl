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
            <h3>DataBase Configuration</h3>
        </div>
        <div class="panel-body">
            <form action="database.php" method="post">
                <div class="form-group">
                    <label class="control-label">Address</label>
                    <input name="address" class="form-control" type="text" value="<{$conf.address}>" />
                </div>
                <div class="form-group">
                    <label class="control-label">UserName</label>
                    <input name="username" class="form-control" type="text" value="<{$conf.username}>"/>
                </div>
                <div class="form-group">
                    <label class="control-label">PassWord</label>
                    <input name="password" class="form-control" type="text" value="<{$conf.password}>" />
                </div>
                <div class="form-group">
                    <label class="control-label">DataBase</label>
                    <input name="database" class="form-control" type="text" value="<{$conf.database}>" />
                </div>
                <div class="form-group">
                    <label class="control-label">Type</label>
                    <input name="type" class="form-control" type="text" value="<{$conf.type}>"/>
                </div>
                <div class="form-group">
                    <label class="control-label">Charset</label>
                    <input name="charset" class="form-control" type="text" value="<{$conf.charset}>"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
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