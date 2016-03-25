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
    <div class="row" style="padding: 0.8em">
        <div class="panel">
            <div class="panel-heading">
                <h3>Logs Board</h3>
                <div class="panel">
                    <div class="panel-body">
                        <div class="form-control text-left" style="height: 50px;">
                                <select id="select-log" class="select2-dropdown" style="display: inline-block">
                                    <{foreach from=$logs item=log}>
                                    <option><{$log}></option>

                                    <{/foreach}>
                                </select>
                            <button class="btn btn-primary" style="float: right">Submit</button>
                            <div style="clear: both">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <textarea id="log" style="width: 100%;height: 600px"></textarea>
            </div>
        </div>
    </div>
</section>

<script src="../../Resource/packages/jquery-2.2.0-dist/jquery-2.2.0.min.js"></script>
<script src="../../Resource/packages/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="../../Resource/packages/fastclick/js/fastclick.min.js"></script>
<script src="../../Resource/packages/echart-dist/echarts.min.js"></script>
<script src="../../Resource/packages/adminlte-dist/js/app.min.js"></script>
<script>
    $("button").on("click",function(){
        $.ajax({
           url:"?getlog=true&log="+$("#select-log").val(),
            async:true,
            success:function(data){
                $("#log").val(data);
            }
        });
    });
</script>
</body>
</html>