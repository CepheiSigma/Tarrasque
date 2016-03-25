/**
 * Created by cephei on 3/8/16.
 */

var dom = document.getElementById("chart_container");
myChart = echarts.init(dom);
var app = {};
option = null;

var cpu_per= [],phy_memory_per=[],real_memory_per=[];
var series_list = [
    {
        name: 'CPU Usage',
        type: 'line',
        showSymbol: true,
        hoverAnimation: false,
        data: cpu_per
    },
    {
        name: 'Physical Memory Usage',
        type: 'line',
        showSymbol: true,
        hoverAnimation: false,
        data: phy_memory_per
    },
    {
        name: 'Real Memory Usage',
        type: 'line',
        showSymbol: true,
        hoverAnimation: false,
        data: real_memory_per
    }
];


option = {
    title: {
        text: "System Usage",
        show:false
    },
    xAxis: {
        type: 'time',
        splitLine: {
            show: false
        }
    },
    yAxis: {
        type: 'value',
        boundaryGap: [0, '100%'],
        splitLine: {
            show: false
        }
    },
    series: series_list
};

var ticks = 1000;
if($("#os-identifier").html().indexOf("Windows")!==-1)
    ticks=3000;
app.timeTicket = setInterval(function() {
    if(cpu_per.length>15)
    {
        cpu_per.shift();
        real_memory_per.shift();
        phy_memory_per.shift();
    }
    getSystemInfo();
    myChart.setOption({
        series: [
            {
                data: cpu_per
            },
            {
                data: phy_memory_per
            },
            {
                data: real_memory_per
            }
        ]
    });
}, ticks);

function getSystemInfo(){
    $.ajax({
        url:"systeminfo.php?ajax=true",
        type:"GET",
        success:function(data){
            if(!(data instanceof Object)){
                data = $.parseJSON(data);
            }
            var time = new Date(data.timestamp*1000);
            var valueTime = [time.getYear(),time.getMonth(),time.getDay()].join("-")+" "+[time.getHours(),time.getMinutes(),time.getSeconds()].join(':');

            $("#cpu-usage").find(".info-box-number").html(data.runtime.cpu+"%");
            $("#phymemory-usage").find(".info-box-number").html(data.runtime.physicalmemory+"%");
            $("#realmemory-usage").find(".info-box-number").html(data.runtime.realmemory+"%");
            $("#cpu-usage").find(".progress-bar").css("width",data.runtime.cpu+"%");
            $("#phymemory-usage").find(".progress-bar").css("width",data.runtime.physicalmemory+"%");
            $("#realmemory-usage").find(".progress-bar").css("width",data.runtime.realmemory+"%");
            cpu_per.push({
                name: time.toString(),
                value: [
                    valueTime,
                    data.runtime.cpu
                ]
            });
            real_memory_per.push({
                name: time.toString(),
                value: [
                    valueTime,
                    data.runtime.realmemory
                ]
            });
            phy_memory_per.push({
                name: time.toString(),
                value: [
                    valueTime,
                    data.runtime.physicalmemory
                ]
            });
        }
    });
}

myChart.setOption(option, true);
myChart.resize();
