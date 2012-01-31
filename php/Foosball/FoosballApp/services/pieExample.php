<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Test Pie</title>


<link rel="stylesheet" type="text/css" href="../assets/yui.css" >


<script type="text/javascript" src="../build/yuiloader/yuiloader-min.js"></script>
<script type="text/javascript" src="../build/dom/dom-min.js"></script>
<script type="text/javascript" src="../build/event/event-min.js"></script>
<script type="text/javascript" src="../build/json/json-min.js"></script>
<script type="text/javascript" src="../build/element/element-min.js"></script>
<script type="text/javascript" src="../build/datasource/datasource-min.js"></script>
<script type="text/javascript" src="../build/swf/swf-min.js"></script>
<script type="text/javascript" src="../build/charts/charts-min.js"></script>
<script type="text/javascript" src="../build/button/button-min.js"></script>



</head>

<body class="yui-skin-sam">

<h1>Test Pie</h1>

<div id="chart">Unable to load Flash content. The YUI Charts Control
requires Flash Player 9.0.45 or higher. You can install the latest
version at the <a href="http://www.adobe.com/go/getflashplayer">Adobe
Flash Player Download Center</a>.</div>
<button id="changeData" type="button">Change Data</button>

<script type="text/javascript">
    /*globals YAHOO */


YAHOO.widget.Chart.SWFURL = "../build/charts/assets/charts.swf";


//--- data

    var w =
    [
        { asset: "P1", weigth: 0.10000000000000002 },
        { asset: "P2", weigth: 0.304853201708779 },
        { asset: "P3", weigth: 0.03887074865824967 },
        { asset: "P4", weigth: 0.08907124456880741 },
        { asset: "P5", weigth: 0.038472078322830935 },
        { asset: "P6", weigth: 0.23249229758823953 },
        { asset: "P7", weigth: 0.09624042915309339 },        
        { asset: "P8", weigth: 0.1 }
    ];
    var w2 =
    [
        { asset: "P1", weigth: 0.10000000000000002 },
        { asset: "P2", weigth: 0.304853201708779 },
        { asset: "P3", weigth: 0.03887074865824967 },
        { asset: "P4", weigth: 0.08907124456880741 }
    ];

//--- chart
    var pieDS = new YAHOO.util.DataSource([]);
    pieDS.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    pieDS.responseSchema = { fields: [ "asset", "weigth" ] };

    var mychart = new YAHOO.widget.PieChart("chart", pieDS,
    {
        dataField: "weigth",
        categoryField: "asset",
        style:
        {
            padding: 20,
            legend:
            {
                display: "right",
                padding: 10,
                spacing: 5,
                font:
                {
                    family: "Arial",
                    size: 13
                }
            }
        },
        //only needed for flash player express install
        expressInstall: "/assets/expressinstall.swf"
    });
    
    pieDS.liveData = w;
    mychart._seriesDefs = [{style: {}}]; // hack for yui 2.5.2
    mychart.set('dataSource', pieDS);

    var button_changeData = new YAHOO.widget.Button("changeData");



</script>

</body>
</html> 