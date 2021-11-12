<style>
.slidecontainer {
    width: 97%;
}

.slider {
    -webkit-appearance: none;
    width: 100%;
    height: 10px;
    background: #d3d3d3;
    outline: none;
    opacity: 0.7;
    -webkit-transition: .2s;
    transition: opacity .2s;
}

.slider:hover {
    opacity: 1;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    background: #4CAF50;
    cursor: pointer;
}

.slider::-moz-range-thumb {
    width: 25px;
    height: 25px;
    background: #4CAF50;
    cursor: pointer;
}
fieldset
{
    border:3px solid green;
    -moz-border-radius:8px;
    -webkit-border-radius:8px;
    border-radius:8px;
	width: 590px;
}
table
{
	width: 590px;
}
select {
    width: 100%;
    height:35px;
    font-size: 15px;
    text-align-last:center; 
}

input[type="text"]{
    font-size: 15px;
    text-align: center;
    height:35px; 
	width: 100%;
}
input.output{
    width: 70px;
    height:35px;
    font-size: 15px;
}
.button {
    border: none;
    color: white;
    padding: 6px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    transition-duration: 0.2s;
    cursor: pointer;
    -moz-border-radius:8px;
    -webkit-border-radius:8px;
    border-radius:8px;
}
.button1 {
    background-color: white;
    color: black;
    border: 2px solid #555555;
    -moz-border-radius:8px;
    -webkit-border-radius:8px;
    border-radius:8px;
}

.button1:hover {
    background-color: #555555;
    color: white;
    -moz-border-radius:8px;
    -webkit-border-radius:8px;
    border-radius:8px;
}
</style>

<script>
function readonly(value,write) {
	if (value=="log-normal") {
		if (document.getElementById(write).value=="-") {
			document.getElementById(write).value="";
		}
        document.getElementById(write).readOnly= false;
	}
	else {
		document.getElementById(write).value="-";
	    document.getElementById(write).readOnly= true;
	}
}

	var slider = document.getElementById("myRange");
	var output = document.getElementById("demo");
	output.innerHTML = slider.value;

	slider.oninput = function() {
		output.innerHTML = this.value;
}
</script>

<html>
	<head>
	<TITLE>Optimal Outpatient Appointment Scheduling Tool</TITLE>
	<META NAME="description" CONTENT="On this page presents a health-care outpatient appointment scheduling tool">
	<META NAME="keywords" CONTENT="software, health care, optimization, local search, multimodularity, appointment, outpatient, schedule">
	<link rel="stylesheet" href="style.css" type="text/css">
    <script src="amcharts.js" type="text/javascript"></script>
    <script src="serial.js" type="text/javascript"></script>
	</head>
	
	<script>
            var chart;

            var chartData = [
                {
                    "Time": "00:00",
                    "Option": 0,
					"Average" : 0
                },
                {
                    "Time": "00:20",
                    "Option": 0,
					"Average" : 0
                },
                {
                    "Time": "00:40",
                    "Option": 0,
					"Average" : 0
                },
                {
                    "Time": "01:00",
                    "Option": 0,
					"Average" : 0
                },
                {
                    "Time": "01:20",
                    "Option": 0,
					"Average" : 0
                },
            ];


            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "Time";
                chart.startDuration = 1;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.gridPosition = "start";
				categoryAxis.title = "Time interval";

                // value
				var valueAxis = new AmCharts.ValueAxis();
				valueAxis.title = "Number of arrivals";
				valueAxis.integersOnly = true;
				chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
				graph.title = "Not available";
                graph.valueField = "Option";
                graph.balloonText = "[[category]]: <b>[[value]]</b>";
				graph.showBalloon = false;
                graph.type = "column";
				graph.lineColor = "#4CAF50";
                graph.lineAlpha = 0;
                graph.fillAlphas = 0.8;
                chart.addGraph(graph);
				
				var graph2 = new AmCharts.AmGraph();
				graph2.title = "Not available";
                graph2.type = "smoothedLine"; // this line makes the graph smoothed line.
                graph2.lineColor = "#d1655d";
                graph2.lineThickness = 2;
                graph2.valueField = "Average";
                graph2.balloonText = "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span></b>";
				graph2.showBalloon = false;
                chart.addGraph(graph2);
				
				var legend = new AmCharts.AmLegend();
                legend.borderAlpha = 0.2;
                legend.horizontalGap = 10;
                legend.autoMargins = false;
                legend.marginLeft = 20;
                legend.marginRight = 20;
                chart.addLegend(legend);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = true;
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = "top-right";

                chart.write("chartdiv");
            });
        </script>

	<body bgcolor="#FFFFFF" link="#003399" vlink="#003399" alink="#003399">
	<form action="schedulecalc.php" name="formulier" method=POST>
	<table style=width:620>
		<tr>
			<td bgcolor="#FFFFFF" align=left><font color="#000000"><b>Optimal outpatient appointment scheduling tool</b></font></td>
			<td bgcolor="#FFFFFF" align=right><span title="Click on this questionmark to go to the help page."><A HREF="help.html"><img width=25 height=25 src="questionmark.png"></A></span></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF"><b>Input</b><td>
		</tr>
	</table>
	
	<FIELDSET>
	<table>
	
	<tr>
		<td>Total number of arrivals</td>
		<td>  <input type=text name="n" value=10 size=6></td>
		<td></td>
		<td rowspan=9><b><button class='button button1' type=submit name="submit">Compute</button></b>
	</tr>
	<tr>
		<td>Service time type</td>
		<td> <select id="type" name="type" size=1 onchange="readonly(document.getElementById('type').value,'stdDev')"><OPTION VALUE="deterministic">deterministic<OPTION VALUE="exponential" SELECTED>exponential<OPTION VALUE="log-normal">log-normal</SELECT></td>
		<td></td>
	</tr>
	<tr>
		<td >Average service time</td>
		<td > <input type=text name="beta" value=15 size=6></td>
		<td > minutes</td>
	</tr>
	<tr>
		<td >Standard deviation</td>
		<td > <input id="stdDev" type=text name="stdDev" value=0 size=6></td>
		<td ></td>
	</tr>
	<tr>
		<td>Total available time</td>
		<td> <input type=text name="TotalTime" value=100 size=6> 
		</td><td>minutes</td>
	</tr>
	<tr>
		<td>Schedule in intervals of</td>
		<td> <input type=text name="d" value=20 size=6> 
		</td><td>minutes</td>
	</tr>
	<tr>
		<td>Percentage no-shows</td>
		<td>  <input type=text name="no_show" value=5 size=6>
		</td><td> % </td>
	</tr>
    <tr>
		<td>Time limit for the search</td>
		<td>  <input type=text name="time_limit" value=10 size=6> 
		</td><td>seconds</td>
	</tr>
	<tr>
		<td style=padding-top:10>Patient-centric</td>
		<td style=padding-top:10>
			<div class="slidecontainer">
			<input type="range" min="0" max="1000" value="500" class="slider" id="myRange" name = "alphaSlider">
			</div>
		</td>
		<td style=padding-top:10>Doctor-centric</td>
	</tr>
	</table>
	</FIELDSET>
	
	<table>
	<tr>
		<td colspan=4 bgcolor="#FFFFFF"><b>Options for results</b><td>
	</tr>
	</table>
	
	
	<FIELDSET>
	<table>
    	<colgroup>
            <col width="5%">
            <col width="5%">
            <col width="90%">
        </colgroup>
	<tr>
		<td align="right"><input type="checkbox" name="column1" checked></td>
		<td colspan="2">Results of the average number of patients</td>
	</tr>
	<tr>
		<td align="right"><input type="checkbox" name="column3"></td>
		<td colspan="2">Results of the Small or Full Neighborhood</td>
	</tr>
	<tr>
		<td></td>
		<td align="right"><input type="radio" value="SMALL" name="model" checked></td>
		<td>Small Neighborhood <br><i> (Suboptimal, short calculation time)</i></td>
	</tr>
	<tr>
		<td></td>
		<td align="right"><input type="radio" value="FULL" name="model"></td>
		<td>Full Neighborhood <br><i> (Optimal, long calculation time)</i></td>
	</tr>
	</table>
	</FIELDSET>
	
	<table style=width:620px style=height:400px>
    	<tr>
    		<td colspan=4 bgcolor="#FFFFFF"><b>Number of arrivals per time interval</b></td>
    	</tr>
    	<tr>
    		<td colspan = 4><div id="chartdiv" style="width: 100%; height: 400px;"></div></td>
    	</tr>
    	<tr>
    		<td colspan=4 bgcolor="#FFFFFF"><b>Output</b></td>
    	</tr>
	</table>
	
	<FIELDSET>
	<table>
    	<colgroup>
            <col width=100>
            <col width=100>
            <col width=200>
    		<col width=300>
        </colgroup>
	<tr>
			<td colspan=2></td>
			<td>Individual schedule</td>
			<td>Optimized schedule</td>
	</tr>
	<tr>
			<td colspan=2>Waiting time<br></td>
			<td><input class=output type=text name="waitingTime_zelf" size=6 disabled> minutes</td>
			<td><input class=output type=text name="waitingTime" size=6 disabled>
			minutes</td>
		</tr>
		<tr>
			<td colspan=2>Idle time<br></td>
			<td><input class=output type=text name="idleTime_zelf" size=6 disabled> minutes</td>
			<td><input class=output type=text name="idleTime" size=6 disabled>
			minutes</td>
		</tr>
		<tr>
			<td colspan=2>Tardiness<br></td>
			<td><input class=output type=text name="tardiness_zelf" size=6 disabled> minutes</td>
			<td><input class=output type=text name="tardiness" size=6 disabled>
			minutes</td>
		</tr>
		<tr>
			<td colspan=2>Fraction of excess<br></td>
			<td><input class=output type=text name="fracExcess_zelf" size=6 disabled> %</td>
			<td><input class=output type=text name="fracExcess" size=6 disabled> %</td>
		</tr>
		<tr>
			<td><br></td>
		</tr>
		<tr>
			<td colspan=2>Makespan<br></td>
			<td><input class=output type=text name="makeSpan_zelf" size=6 disabled> minutes</td>
			<td><input class=output type=text name="makeSpan" size=6 disabled> minutes</td>
		</tr>
		<tr>
			<td colspan=2>Lateness<br></td>
			<td><input class=output type=text name="lateness_zelf" size=6 disabled> minutes</td>
			<td><input class=output type=text name="lateness" size=6 disabled> minutes</td>
		</tr>
		<tr>
			<td><br></td>
		</tr>
		<tr>
			<td colspan=2>Objective Value<br></td>
			<td><input class=output  type=text name="objVal_zelf" size=6 disabled></td>
			<td><input class=output  type=text name="objVal" size=6 disabled>
			</td>
		</tr>
	</table>
	</FIELDSET>
		<TABLE style=width:620 style=padding-top:10>
		<TR>
			<TD WIDTH=20% ALIGN=left>
				<A HREF="disclaimer.html">disclaimer</A>
			</TD>
			<TD WIDTH=60% ALIGN=center>
&copy; 2007-2018
Guido Kaandorp,
<A HREF="http://www.few.vu.nl/~koole">Ger Koole</A> and Jerry Timmer (thanks to Dennis Roubos)
			</TD>
			<TD WIDTH=20% ALIGN=right>		
				 <!--<A HREF="help.html">help</A>
				 | --><A HREF="mailto: koole@few.vu.nl">contact</A>
			</TD>
		</tr>
		</TABLE>
	</form>

	</body>
<script>
readonly(document.getElementById('type').value,'stdDev')
</script>

</html>

