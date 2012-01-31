<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 

<html>
<head>

  <meta http-equiv="content-type" content="text/html; charset=utf-8"> 

<title>Something something dd</title>
	
<!-- Dependencies -->
<script src="/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script src="/build/element/element-min.js"></script>
<script src="/build/datasource/datasource-min.js"></script>
<script src="/build/json/json-min.js"></script>
<script src="/build/swf/swf-min.js"></script>

<!-- OPTIONAL: Connection (enables XHR) -->
<script src="/build/connection/connection-min.js"></script>

<!-- Source files -->
<script src="/build/charts/charts-min.js"></script>

</head>

<body>
<div id="myContainer">hello</div>

<script>

"use strict";  

function TestObj(id)
{
   YAHOO.util.Event.onAvailable(id, this.handleOnAvailable, this); 
}
 

TestObj.prototype.handleOnAvailable = function(me)
{

    YAHOO.widget.Chart.SWFURL = "/build/charts/assets/charts.swf";

    YAHOO.example.puppies = [
        { name: "Ashley", breed: "German Shepherd", age: 12 },
        { name: "Dirty Harry", breed: "Norwich Terrier", age: 5 },
        { name: "Emma", breed: "Labrador Retriever", age: 9 },
        { name: "Oscar", breed: "Yorkshire Terrier", age: 6 },
        { name: "Riley", breed: "Golden Retriever", age: 6 },
        { name: "Shannon", breed: "Greyhound", age: 12 },
        { name: "Washington" ,breed: "English Bulldog", age: 8 },
        { name: "Zoe", breed: "Labrador Retriever", age: 3 }
    ];

    var myDataSource = new YAHOO.util.DataSource(YAHOO.example.puppies);
    myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    myDataSource.responseSchema = {
        fields: [ "name","breed","age" ]
    };
    alert(this.id + " okay to load");

    var myChart = new YAHOO.widget.LineChart( "myContainer", myDataSource, {
        xField: "name",
        yField: "age"
    });

}
var obj = new TestObj("myContainer");

</script>

</body>

</html>