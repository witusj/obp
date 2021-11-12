<style>
.slidecontainer {
    width: 90%;
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

<?php
error_reporting(0); 
//error_reporting(E_ALL ^ E_NOTICE);

// Process inputs:
if (isset($_POST['n'])) { $n = $_POST['n']; } else { $n = null; }
if (isset($_POST['type'])) { $type = $_POST['type']; } else { $type = null; }
if (isset($_POST['beta'])) { $beta = $_POST['beta']; } else { $beta = null; }
if (isset($_POST['stdDev'])) { $stdDev = $_POST['stdDev']; } else { $stdDev = null; }
if (isset($_POST['TotalTime'])) { $TotalTime = $_POST['TotalTime']; } else { $TotalTime = null; }
if (isset($_POST['d'])) { $d = $_POST['d']; } else { $d = null; }
if (isset($_POST['no_show'])) { $no_show = $_POST['no_show']; } else { $no_show = null; }
if (isset($_POST['time_limit'])) { $time_limit = $_POST['time_limit']; } else { $time_limit = null; }
if (isset($_POST['alphaSlider'])) { $alphaSlider = $_POST['alphaSlider']; } else { $alphaSlider = null; }
$alpha_I = 0;
$alpha_T = $alphaSlider/1000 - 0.00000001;
$alpha_W = (1 - $alpha_T) + 0.00000001;
$I = $TotalTime / $d;
if ($stdDev=="") {
    $stdDev=0;
    ?>
    <script>alert("Standard deviation should be greater than 0.");</script>
    <?php
}
// Options for results
if (isset($_POST['column1'])) { $column1 = $_POST['column1']; } else { $column1 = null; }
if (isset($_POST['column3'])) { $column3 = $_POST['column3']; } else { $column3 = null; }
if (isset($_POST['model'])) { $model = $_POST['model']; } else { $model = null; }
?>



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

	<TITLE>Optimal outpatient appointment scheduling tool</TITLE>

	<META NAME="description" CONTENT="On this page presents a health-care outpatient appointment scheduling tool">

	<META NAME="keywords" CONTENT="software, health care, optimization, local search, multimodularity, appointment, outpatient, schedule">

	<link rel="stylesheet" href="style.css" type="text/css">
    <script src="amcharts.js" type="text/javascript"></script>
    <script src="serial.js" type="text/javascript"></script>
	
	</head>

	<body bgcolor="#FFFFFF" link="#003399" vlink="#003399" alink="#003399">

		<form action="schedulecalc.php" name="formulier" method=post>

	<table style=width:620>
		<tr>
			<td bgcolor="#FFFFFF" align=left><font color="#000000"><b>Optimal outpatient appointment scheduling tool</b></font></td>
			<td bgcolor="#FFFFFF" align=right><span title="Click on this questionmark to go to the help page."><A HREF="help.html"><img width=25 height=25 src="questionmark.png"></A></span></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF"><b>Input</b><td>
		</tr>
	</table>

	<FIELDSET><table>
	
	<tr>
		<td >Total number of arrivals</td>
		<td >  <input type=text name="n" value="<?php print("$n") ?>" size=6></td>
		<td ></td>
	 	<td rowspan=9><b><button class='button button1' type=submit name="submit">Compute</button></b>
		</td>
	</tr>
	
	<tr>
		<td >Service time type</td>
		<td > <select id="type" name="type" size=1 onchange="readonly(document.getElementById('type').value,'stdDev')">
		<?php if ($type=="deterministic") {?>
    		<OPTION VALUE="deterministic" SELECTED>deterministic
    		<OPTION VALUE="exponential" >exponential
    		<OPTION VALUE="log-normal">log-normal
		<?php } else if ($type=="exponential") {?>
    		<OPTION VALUE="deterministic" >deterministic
    		<OPTION VALUE="exponential" SELECTED>exponential
    		<OPTION VALUE="log-normal">log-normal
		<?php } else if ($type=="log-normal") {?>
    		<OPTION VALUE="deterministic" >deterministic
    		<OPTION VALUE="exponential" >exponential
    		<OPTION VALUE="log-normal"SELECTED>log-normal
		<?php }?>
		</SELECT></td>
		<td ></td>
	</tr>
	
	<tr>

		<td>Average service time</td>

		<td> <input type=text name="beta" value="<?php print("$beta") ?>" size=6></td>

		<td>minutes</td>

	</tr>
	
	<tr>
		<td>Standard deviation</td>
		<td> <input type=text name="stdDev" id="stdDev"value="<?php print("$stdDev") ?>" size=6></td>
		<td></td>
	</tr>

	<tr>

		<td>Total available time</td>

		<td> <input type=text name="TotalTime" value="<?php print("$TotalTime") ?>" size=6>  </td>

		<td>minutes</td>

	</tr>

	<tr>

		<td>Schedule in intervals of</td>

		<td> <input type=text name="d" value="<?php print("$d") ?>" size=6>

		</td><td> minutes</td>

	</tr>

	<tr>

		<td>Percentage no-shows</td>

		<td>  <input type=text name="no_show" value="<?php print("$no_show") ?>" size=6> 

		</td><td>%</td>

	</tr>
	
		<tr>

		<td>Time limit for the search</td>

		<td>  <input type=text name="time_limit" value="<?php print("$time_limit") ?>" size=6> 

		</td><td>seconds</td>

	</tr>
	
	<tr>
		<td style=padding-top:10>Patient-centric</td>
		<td style=padding-top:10>
			<div class="slidecontainer">
			<input type="range" min="0" max="1000" value="<?php print("$alphaSlider") ?>" class="slider" id="myRange" name = "alphaSlider">
			</div>
		</td>
		<td style=padding-top:10>Doctor-centric</td>
	</tr>
	</table></FIELDSET>
	<table>
		<tr>
			<td colspan=4 bgcolor="#FFFFFF"><b>Options for results</b><td>
		</tr>
	</table>

	<FIELDSET><table>
	<colgroup>
        <col width="5%">
        <col width="5%">
        <col width="90%">
    </colgroup>
	<tr>
		<?php //Options for results

			if($column1==TRUE){

		?>

			<td align="right"><input type="checkbox" name="column1" checked></td>

		<?php

			}else{

		?>

			<td align="right"><input type="checkbox" name="column1"></td>
		
		<?php
			}
		?>
		<td colspan="2">Results of the average number of patients</td>
	</tr>
	<tr>
		<?php //uitprinten output

			if($column3==TRUE){

		?>

			<td align="right"><input type="checkbox" name="column3" checked></td>

		<?php

			}else{

		?>

			<td align="right"><input type="checkbox" name="column3"></td>
		
		<?php
			}
		?>
		<td colspan="2">Results of the Small or Full Neighborhood</td>
	</tr>
	<tr>
		<td></td>
		<?php //uitprinten output

			if($model=="SMALL"){

		?>

			<td align="right"><input type="radio" value="SMALL" name="model" checked></td>

		<?php

			}else{

		?>

			<td align="right"><input type="radio" value="SMALL" name="model"></td>
		
		<?php
			}
		?>
		<td>Small Neighborhood <br><i> (Suboptimal, short calculation time)</i></td>
	</tr>
	<tr>
		<td></td>
		<?php //uitprinten output

			if($model=="FULL"){

		?>

			<td align="right"><input type="radio" value="FULL" name="model" checked></td>

		<?php

			}else{

		?>

			<td align="right"><input type="radio" value="FULL" name="model"></td>
		
		<?php
			}
		?>
		<td>Full Neighborhood <br><i> (Optimal, long calculation time)</i></td>
	</tr>
	</table></FIELDSET>


<?php
/*	$floor = floor($n / $I);
	$ceil = ceil($n / $I);
	if ($n <= $I){
		if($n == $I){
			for($interval=1; $interval<=$I; $interval++){
				$x_zelf[$interval] = 1;
			}
		} else{
			for($interval=1; $interval<=$n; $interval++){
				$x_zelf[$interval] = 1;
			}
			for($interval=$n+1; $interval<=$I; $interval++){
				$x_zelf[$interval] = 0;
			}
		}
	} else {
		if($n % $I == 0){
			for($interval=1; $interval<=$I; $interval++){
				$x_zelf[$interval] = $ceil;
			}
		} else {
			$remainder = $n;
			$counter = $I + 1;
			$boolean = false;
			for($interval=1; $interval<=$I; $interval++){
				if($boolean){
					$x_zelf[$interval] = $floor;
				} else {
					$x_zelf[$interval] = $ceil;
				}
				if($interval * $ceil + ($I - $interval) * $floor == $n){
					$boolean = true;
				}
			}
		}
	}*/

//assignment of patients --> $x_zelf is the list of assignments per interval
$x_zelf = null;
for($interval=1; $interval<=$I; $interval++){
	$x_zelf[$interval] = 0;
}
for($patient=1; $patient<=$n; $patient++){
	$interval = round(($patient-1)*$I / $n)+1;
	if($interval > $I){
		$interval -= 1;
	}
	$x_zelf[$interval] += 1;
}
?>		<table style=width:620px style=height:400px>
    		<tr>
    			<td colspan=4 bgcolor="#FFFFFF"><b>Number of arrivals per time interval</b>
    			<div id="progress"></div></td>
    		</tr>
    		<tr>
    			<td colspan = 4><div id="chartdiv" style="width: 100%; height: 400px;"></div></td>
    		</tr>
		</table>
		
		<Table>
    		<tr>
    			<td style=font-size:15px; colspan=4 bgcolor="#FFFFFF"><b>Output</b></td>
    		</tr>
		</Table>
		<FIELDSET><table>
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

			<td><input class=output type=text name="waitingTime" size=6 disabled> minutes</td>

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

			<td><input class=output type=text name="objVal_zelf" size=6 disabled></td>

			<td><input class=output type=text name="objVal" size=6 disabled>

			</td>

		</tr>
		</table></FIELDSET>
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

<script>
readonly(document.getElementById('type').value,'stdDev')
</script>

</body>

</html>

<?php

flush();
set_time_limit();

//p and a calculations:
//p denotes the poisson probability
//a denotes the cumulative prob.: p(x>=$i)

$no_show = $no_show/100;
$precision=0.9999;
$p=array();
$i=0;
while(array_sum($p)<$precision){
   $p[$i]=service($i);
   $i++;
}

function limit($type,$mu) {
    global $stdDev;
    global $p;
    global $beta;
    if ($type=="deterministic") {
        return $mu+1;
    }
    else if ($type=="exponential") {
        return max($mu+4*sqrt($mu),100);
    }
    else if ($type=="log-normal") {
        return count($p)*$mu/$beta;
    }
}

//results for the average number of patients:
if($column1==TRUE) {
	echo "<script>document.getElementById('progress').innerHTML = \"Calculating individual schedule...\";</script>"; flush();	
//calculates the output of individual schedule as a list

	$n_temp=$n;
	$n=$x_zelf[1];
	$results=results($x_zelf, 1);

	$waitingTime_zelf = round($results['waitingTime'],2);
    $idleTime_zelf = round($results['idleTime'],2);
    $tardiness_zelf = round($results['tardiness'],2);
	$objVal_zelf = round($results['objVal'],2);
	$fracExcess_zelf = round($results['fracExcess'],2);
	$makeSpan_zelf = round($idleTime_zelf+$beta*$n_temp*(1-$no_show),2);
	$lateness_zelf = round($makeSpan_zelf-$d*$I,2);
    $n=$n_temp;
    ?>
    <script>
    	eval("document.formulier.waitingTime_zelf.value = " + <?php print("$waitingTime_zelf") ?>);
    	eval("document.formulier.idleTime_zelf.value = " + <?php print("$idleTime_zelf") ?>);
    	eval("document.formulier.tardiness_zelf.value = " + <?php print("$tardiness_zelf") ?>);
    	eval("document.formulier.fracExcess_zelf.value = " + <?php print("$fracExcess_zelf") ?>);
    	eval("document.formulier.makeSpan_zelf.value = " + <?php print("$makeSpan_zelf") ?>);
    	eval("document.formulier.lateness_zelf.value = " + <?php print("$lateness_zelf") ?>);
    	eval("document.formulier.objVal_zelf.value = " + <?php print("$objVal_zelf") ?>);
    </script>    
	<?php
    echo "<script>document.getElementById('progress').innerHTML = \"Finished calculating individual schedule.\";</script>"; flush();	
}


//results for the small or full neighborhood
if($column3==TRUE) {
  //initiate the values
  $x[1]=$n;
  for($interval=2;$interval<=$I;$interval++) {$x[$interval]=0;}
  $results=results($x, 0);

	?>
	<script>
	   eval("document.formulier.waitingTime.value = " + <?php print("$results[waitingTime]") ?>);
	   eval("document.formulier.idleTime.value = " + <?php print("$results[idleTime]") ?>);
	   eval("document.formulier.tardiness.value = " + <?php print("$results[tardiness]") ?>);
	   eval("document.formulier.objVal.value = " + <?php print("$results[objVal]") ?>);
	</script>
	<?php
	//flush();
	if ($model=="SMALL"){
		$counter_progress = 0;
  	   echo "<script>document.getElementById('progress').innerHTML = \"Searching small neighborhood...\";</script>"; flush();
  	   $start = microtime(true);
	   do{
	      $counter_progress++;
	      list ($x,$results) = iteratie_small($x,$results);
	      if ($counter_progress % 10 == 0) {
			echo "<script>document.getElementById('progress').innerHTML = \"Searching small neighborhood...<br>Performed $counter_progress iterations.\";</script>"; flush();
		}
	   }while($results != "" && $results['objVal'] != 0 && microtime(true)-$start<$time_limit);
	   if (microtime(true)-$start>$time_limit) {
	       ?>
	       <script>alert('Time limit ('+ <?php print($time_limit) ?> +' seconds) is reached before the optimization ends.');</script>
	       <?php
	   }
        echo "<script>document.getElementById('progress').innerHTML = \"Finished searching small neighborhood.\";</script>"; flush();
	}else if($model=="FULL"){
		echo "<script>document.getElementById('progress').innerHTML = \"Searching full neighborhood...\";</script>"; flush();
	
        do{
	      list ($x,$results) = iteratie_small($x,$results);
           }while($results != "");
           do{
	      list ($x,$results) = iteratie_full($x,$results);
	   }while($results != ""); 
	   echo "<script>document.getElementById('progress').innerHTML = \"Finished searching full neighborhood.\";</script>"; flush();
	
	}
	$results=results($x, 1);
	$waitingTime = round($results['waitingTime'],2);
  $idleTime = round($results['idleTime'],2);
  $tardiness = round($results['tardiness'],2);
	$objVal = round($results['objVal'],2);
	$fracExcess = round($results['fracExcess'],2);
	$makeSpan = round($idleTime+$beta*$n_temp*(1-$no_show),2);
	$lateness = round($makeSpan-$d*$I,2);
//print($makeSpan);print("<br>");
//print($lateness);print("<br>");
	?>
	<?php
	for($interval=2; $interval<=$I; $interval++){
		?>
		<?php
	}
	?>
	<script>
		eval("document.formulier.waitingTime.value = " + <?php print("$waitingTime") ?>);
		eval("document.formulier.idleTime.value = " + <?php print("$idleTime") ?>);
		eval("document.formulier.tardiness.value = " + <?php print("$tardiness") ?>);
		eval("document.formulier.fracExcess.value = " + <?php print("$fracExcess") ?>);
		eval("document.formulier.makeSpan.value = " + <?php print("$makeSpan") ?>);
		eval("document.formulier.lateness.value = " + <?php print("$lateness") ?>);
		eval("document.formulier.objVal.value = " + <?php print("$objVal") ?>);
	</script>
	<?php
	echo "<script>document.getElementById('progress').innerHTML = \"Finished searching.\";</script>"; flush();

} //END IF

//Following functions check the format of the entry
function isDecimal($d) {
    $pattern = "/^[0-9]+.?([0-9]+)?$/";
    return preg_match($pattern, $d);
}
function checkDecimal($value, $variableName) {
    if((!isDecimal($value)) AND $value !="") {
        print("<p style=color:#900C3F; >&#10140 The $variableName should be any positive double.</p>");
        return false;
    }
    else if($value =="") {
        print("<p style=color:#900C3F; >&#10140 Please fill in the $variableName. </p>");
    }
    else { return true;}
}

function isInteger($i) {
    $pattern = "/^[0-9]+$/";
    return preg_match($pattern, $i);
}
function checkIntegerPositive($present, $value, $variableName) {
    if($present) {
        if(!isInteger($value) OR $value<=0) {
            print("<p style=color:#900C3F; >&#10140 The $variableName should be any positive integer.</p>");
            return false;
        }
    }
    return true;
}
function factorial($factVal) {
    $factorial = 1;
    while ($factVal > 1) {
        $factorial *= $factVal--;
    }
    return $factorial ;
}
function checkStdDev($serviceTimeType, $value, $variableName) {
    if($serviceTimeType=="log-normal") {
        if((!isDecimal($value)) AND $value !="") {
            print("<p style=color:#900C3F; >&#10140 The $variableName should be any positive double.</p>");
            return false;
        }
        else if ($value =="") {
            print("<p style=color:#900C3F; >&#10140 Please fill in the $variableName. </p>");
            return false;
        }
        else { return true;}
    }
    else { return true;}
}




//PROBABILITIES FUNCTION + W(x), I(x), T(x)
function calculateProbabilities($x){
	global $n;
	global $beta;
	global $d;
	global $no_show;
	global $I;
	global $p;
	global $n_temp;
	global $type;
	global $stdDev;
	global $precision;
    $count=count($p);
	$waiting=0;
	$idletime=0;
	$tardiness=0;   
	
	$p_plus = array();
	$p_min = array();
	$v=[];
	$w=[];
    $add_v=[];
	/*
	$v[$k][$i]=probability of having $i units of work given that 
	$k patients are scheduled for the interval.
	$p[$i]= probability of serving the patient in $i mins given that
	the average service time is $beta.
	*/
    for ($k=0;$k<=$n_temp;$k++){
        $limit=limit($type,$beta*$k);
        $i=0;
        $sum_k=0;
        while ($sum_k<$precision && $i<=$limit) {
            if ($k==0){
                if ($i>0) {
                    $add_v[$k][$i]=0;
                }
                else if ($i==0) {
                    $add_v[$k][$i]=1;
                }
            }
            else {
                $n=0;
                while ($n<=$count) {
                    $add_v[$k][$i]+=$p[$n]*$add_v[$k-1][$i-$n];
                    $n++;
                }
            }
            $sum_k+=$add_v[$k][$i];
            $i++;
        }
    }

	for ($k=0;$k<=$n_temp;$k++){
        $sum_k=0;
        $i=0;	 
        while ($sum_k<$precision && $i<=$limit) {
            for ($m=0;$m<=$k;$m++){
                $v[$k][$i]+=binom($k,$m)*$add_v[$m][$i]*pow((1-$no_show),$m)*pow($no_show,$k-$m);
            }
	        $sum_k+=$v[$k][$i];
	        $i++;
	    }
	}
    /*
	echo "Sum of probabilities of having i mins of work, for all i, when k arrivals are expected:";
	echo "<br>";
	for ($k=0;$k<=$n_temp;$k++){
	    echo "For k=".($k).": sum=". array_sum($v[$k])."<br>";
	}
	*/
	/*
	 p_min[$t][$i] = probability that there are i minutes of work
	 in the system just before the arrival at time t.
	 p_plus[$t][$i] = probability that there are i minutes of work
	 in the system just after the arrival at time t.
	 */

	//CONSTRAINT 1: system starts empty
	// p(there are 0 minutes of work in the system just before time t=1)

    //CONSTRAINT 2: p(i minutes of work just after the first interval):
    $sum_p=0;
    $i=0;
    while ($sum_p<$precision && $i<=$limit) {
        if ($i==0) {
            $p_min[1][$i]=1;
        }
        else {
            $p_min[1][$i]=0;
        }
        $p_plus[1][$i]=$v[$x[1]][$i]*$p_min[1][0];
        $sum_p+=$p_plus[1][$i];
        $i++;
    }
	for ($t=2; $t<=$I+1; $t++){
	    if (!isset($x[$t])) {
	        $x[$t] = 0;
	    }
	//CONSTRAINT 3:
	    for ($k=0; $k<=$d; $k++){
	            $p_min[$t][0] += $p_plus[$t-1][$k];         
	    }

	//CONSTRAINT 4:
	    for ($i=1;$i<=$limit;$i++){
    	        $p_min[$t][$i] = $p_plus[$t-1][$i+$d];  	
	    }
    //CONSTRAINT 5:
	    if ($t!=$I+1) {
	        for ($i=0;$i<=$limit;$i++){
	            for ($j=0; $j<=$i; $j++){
	                   $p_plus[$t][$i]+=$p_min[$t][$j]*$v[$x[$t]][$i-$j];	                
	            }	            
	        }
	    }
	    /*
	    echo 'p_min for t='.$t."= ".array_sum($p_min[$t]);
	    echo '<Br>';
	    */
	    /*
	    echo 'p_plus for t='.$t."= ".array_sum($p_plus[$t]);
	    echo '<Br>';
        */
	    
	}
    //TARDINESS:
    for ($k=1; $k<=$limit; $k++){
        //if $k hours of work cannot be done within $I
        $tardiness += $k*$p_min[$I+1][$k];
    }
    //IDLE TIME:
    $idletime=$I*$d+$tardiness-$n_temp*(1-$no_show)*$beta;
    
    //WAITING TIME:
    for ($t=1; $t<=$I; $t++){
        if ($x[$t]>0) {
            for ($k=0;$k<=$limit;$k++){
                $w[$t][1][$k] = $p_min[$t][$k];
            }
        }
        if ($x[$t]>1) {
            for ($i=2;$i<=$x[$t];$i++){
                for ($k=0;$k<=$limit;$k++){
                    for ($j=0; $j<=$k; $j++){
                        $w[$t][$i][$k] += $w[$t][$i-1][$j]*$p[$k-$j];
                    }
                }
            }
        }
    }

    for ($t=1; $t<=$I; $t++){
        for ($i=1;$i<=$x[$t];$i++){
            for ($k=0;$k<=$limit;$k++){
                $waiting+=$w[$t][$i][$k]*$k;
            }
        }
    }
    $waiting/=$n_temp;
	return array ($p_min, $waiting, $idletime ,$tardiness);
}

function erf($i) {
    $first=0.278393*$i;
    $second=0.230389*pow($i,2);
    $third=0.000972*pow($i,3);
    $fourth=0.078108*pow($i,4);
    return 1-(1/pow((1+$first+$second+$third+$fourth),4));
}
//Poisson probability that $i patients are served per interval
//given that service rate per interval is $d/$beta patients.
function service($i) {
    global $beta;   
    global $type;
    global $stdDev;
    if ($type=="deterministic") {
        if ($i==$beta) {return 1;}
        else {return 0;}
    }
    else if ($type=="exponential") {
        if($i>20){ //dan werkt fact niet meer (java)
            $resultaat = 1;
            for ($j=1; $j<=$i; $j++){
                $resultaat*=$beta/$j;
            }
            return $resultaat * exp(-$beta);
        }
        return pow(($beta),$i) / fact($i) * exp(-$beta);
    }
    else if ($type=="log-normal") {
        if ($stdDev=="") {$stdDev=0.000001;}
        $sigma = sqrt(log((pow($stdDev,2)/pow($beta,2))+1));
        $mu = log($beta)-pow($sigma,2)/2;
        if ($i==0) { return 0;}
        else {
            $first=1/($i*$sigma*sqrt(2 * pi()));
            $second=exp(-pow(log($i)-$mu,2)/(2*pow($sigma,2)));
            return $first*$second;
        }
    }
}

//factorial function
function fact($i) {
    $factorial = 1;
    while ($i > 1) {
        $factorial *= $i--;
    }
    return $factorial ;
}
//binomial coefficient function
function binom($k, $i){
	return fact($k)/(fact($k-$i)*fact($i));
}
//summation function
function som($i){
	if ($i==1){
		return 1;
	}
	return $i+som($i-1);
}

//CALCULATE WAITING, IDLE TIME, TARDINESS AND OBJECTIVE VALUE FOR GIVEN SCHEDULE
function results($schedule, $eind){
	global $alpha_W;
	global $alpha_I;
	global $alpha_T;
	list ($p_min, $results['waitingTime'], $results['idleTime'], $results['tardiness']) = calculateProbabilities($schedule);
	$results['objVal'] = $alpha_W*$results['waitingTime']+$alpha_I*$results['idleTime']+$alpha_T*$results['tardiness'];

	if($eind==1){
		$results['fracExcess'] = calculateFracExcess($p_min);
	}
	return $results;
	
}


function calculateFracExcess($p_min){
	global $I;
	$fracExcess=0;
	$t=$I+1;
	for($j=1; $j<=count($p_min[$t]); $j++){
   		$fracExcess+=$p_min[$t][$j];
   	}
	$fracExcess*=100;
	return $fracExcess;
}

 //ITERATIE SMALL
 
 function iteratie_small($x,$results){
     global $I;
     global $n;
     $x_new = $x;
    // we are going to shift from k to (k+m-1 mod I)  (m further)
     for($m=1; $m<$I; $m++) {
        for($k=$I; $k>0; $k--) {
            if ($x_new[$k]>0) {
                $x_new[$k]-=1;
                $x_new[(($k+$m-1) % $I)+1]+=1;
                $results_temp=results($x_new, 0);
                 if($results_temp['objVal']<$results['objVal']) {
                     ?>
                     <script>
                     eval("document.formulier.waitingTime.value = " + <?php print("$results_temp[waitingTime]") ?>);
                     eval("document.formulier.idleTime.value = " + <?php print("$results_temp[idleTime]") ?>);
                     eval("document.formulier.tardiness.value = " + <?php print("$results_temp[tardiness]") ?>);
                     eval("document.formulier.objVal.value = " + <?php print("$results_temp[objVal]") ?>);
                     </script>
                     <?php
                     //flush();
                     return array ($x_new, $results_temp);
                }
                else {
                    $x_new[$k]+=1;
                    $x_new[(($k+$m-1) % $I)+1]-=1;
                }
            } // endif
        } // endforif
    } // end iteratie_small
    return array ($x, "");
}

//ITERATIE FULL

function iteratie_full($x,$results){
    global $I;
    global $time_limit;
    // initialization
    // x_pos_indices contains indices of positive entries of x
    
    // num_pos_entries the number of positive entries
    $num_pos_entries=0;
    for($k=1;$k<=$I;$k++) {
        if($x[$k]>0) {
            $x_pos_indices[++$num_pos_entries]=$k;
        }
    }
    
    // x_dist_next_one is number of positions until next entry >0
    for($k=1;$k<$num_pos_entries;$k++) {
        $x_dist_next_one[$k]=$x_pos_indices[$k+1]-$x_pos_indices[$k];
    }
    $x_dist_next_one[$num_pos_entries]=$I-$x_pos_indices[$num_pos_entries]+$x_pos_indices[1];
    
    // maxiter is number of possible schedules --- iter shows current iteration
    $maxiter=1;
    for($k=1;$k<=$num_pos_entries;$k++){
        $maxiter*=$x_dist_next_one[$k]+1;
        $iter[$k]=0;
    }
    
    // iterate
    $iter_num=1;
    $start = microtime(true);
    $time_elapsed_secs = microtime(true) - $start;
    $time_check = False;
    while($iter_num<=$maxiter && $time_check == False) {       
        // iter[k] will contain the number of intervals that a patient at the k-th positive
        // interval will be shifted forward --- maximum is x_dist_next_one[k]
        $iter[1]++;
        if($iter[1]==$x_dist_next_one[1]+1) { // extra condition to speed up code
            for($k=1;$k<=$num_pos_entries;$k++) {
                if($iter[$k]==$x_dist_next_one[$k]+1) {
                    $iter[$k]=0;
                    $iter[$k+1]++;
                }
            }
        }
        // determine new schedule x_temp
        $x_temp=$x;

        for($k=1;$k<$num_pos_entries;$k++) {
            $x_temp[$x_pos_indices[$k]]--;
            $x_temp[$x_pos_indices[$k]+$iter[$k]]++;
        }
        // special treatment last positive entry because it goes to beginning schedule
        $x_temp[$x_pos_indices[$num_pos_entries]]--;
        $x_temp[($x_pos_indices[$num_pos_entries]+$iter[$num_pos_entries]-1)%$I+1]++;
            
        // print progress
        if($iter_num%10==0) {
            echo "<script>document.getElementById('progress').innerHTML = \"Searching full neighborhood...<br>Checked $iter_num of $maxiter schedules.\";</script>"; flush();
        }
        
        $results_temp=results($x_temp, 0);
        if($results_temp[objVal]<$results[objVal]) {
			?>
			<script>
            eval("document.formulier.waitingTime.value = " + <?php print("$results_temp[waitingTime]") ?>);
            eval("document.formulier.idleTime.value = " + <?php print("$results_temp[idleTime]") ?>);
            eval("document.formulier.tardiness.value = " + <?php print("$results_temp[tardiness]") ?>);
            eval("document.formulier.objVal.value = " + <?php print("$results_temp[objVal]") ?>);
			</script>
			<?php
			//flush();
			return array ($x_temp, $results_temp);
	     } // endif(improvement)
	     
	     $time_elapsed_secs = microtime(true) - $start;
	     if ($time_elapsed_secs >= $time_limit) {
	         $time_check = True;
	         ?>
	         <script>alert('Time limit ('+ <?php print($time_limit) ?> +' seconds) is reached before the optimization ends.');</script>
	         <?php
         }
         $iter_num+=1;
	} // end while
	return array ($x, "");
} // end iteratie_full

//ITERATIE FULL BACKUP

function iteratie_full_backup($x,$results){

	global $I;
        $maxiter=pow(2,$I)-1;
        for($k=2;$k<=$I+1;$k++)$pow[$k]=pow(2,$k);
        // the binary representation of i tells which vectors are chosen
	for($i=1; $i<=$maxiter; $i++){
             for($interval=1; $interval<=$I; $interval++)$x_temp[$interval]=$x[$interval];
             // i%2=1 means odd means vector 1 is included
             if($i%2==1){$x_temp[1]-=1;$x_temp[$I]+=1;}
             // for all other vectors look if 2^k is in i; if yes add vector
	     for($k=2;$k<=$I;$k++)if($i % $pow[$k+1] > $pow[$k]-1){$x_temp[$k-1]+=1;$x_temp[$k]-=1;}
             $positief=1;
             for($k=2;$k<=$I;$k++)if($x_temp[$k]<0)$positief=0;
             // print progress
	     if($i%10==0) {
   	        echo "<script>document.getElementById('progress').innerHTML = \"Searching full neighborhood...<br>Checked $i of $maxiter schedules.\";</script>"; flush();
	     }
	     if($positief){
                $results_temp=results($x_temp, 0);
	        if($results_temp[objVal]<$results[objVal]) {
					?>
					<?php
					for($interval=2; $interval<=$I; $interval++){
						?>
						<?php
					} // endfor
					?>
					<script>
eval("document.formulier.waitingTime.value = " + <?php print("$results_temp[waitingTime]") ?>);
eval("document.formulier.idleTime.value = " + <?php print("$results_temp[idleTime]") ?>);
eval("document.formulier.tardiness.value = " + <?php print("$results_temp[tardiness]") ?>);
eval("document.formulier.objVal.value = " + <?php print("$results[objVal]") ?>);
					</script>
					<?php
					//flush();
					return array ($x_temp, $results_temp);
	       } // endif
	     } // endif
	} // endforif
	return array ($x, "");
} // end iteraie_full_backup
?>
<script>
	var averageArray = [];
	var optionArray = [];
</script>

<?php
	for($interval=1; $interval<=$I; $interval++){
		?>
		<script>
		averageArray.push(<?php print("$x_zelf[$interval]") ?>);
		optionArray.push(<?php print("$x[$interval]") ?>);
		</script>
		<?php
	}
	?>
	
<?php
	$minYValue = 0;
	if($column3){
		$minX = min(array_slice($x, 0, $I-1, true));
		$minYValue = min($minX, $minYValue);
	}
?>

<script>
// prints the chart:
	var timeInterval = [];
	
	for(interval = 1; interval <= <?php echo $I; ?>; interval++){
			var minuut=((interval-1)*<?php echo $d; ?>)%60;

			var uur=((interval-1)*<?php echo $d; ?>-minuut)/60;

			uur = uur.toString();
			
			var part1 = uur.concat(":");
			
			if(minuut<10){
				var part1 = part1.concat("0");
			}
			minuut = minuut.toString();
			var part1 = part1.concat(minuut);
			timeInterval.push(part1)
	}		
	

    var chart;
    var chartData = [];
	
	var nameAverage = null;
	
	if (<?php echo json_encode($column1); ?>){
		nameAverage = "Individual schedule"
	} else {
		nameAverage = "Not available"
	}
	
	var nameOption = null;
	
	if (<?php echo json_encode($column3); ?>){
		if (<?php echo json_encode($model); ?>=="SMALL"){
			nameOption = "Small Neighborhood"
		} else if (<?php echo json_encode($model); ?>=="FULL"){
			nameOption = "Full Neighborhood"
		} 
	} else {
			nameOption = "Not available"
	}
	
	if (<?php echo json_encode($column3); ?>){
		for (i = 0; i < <?php echo floor($I); ?>; i++) { 
				chartData.push({
                    "Time": timeInterval[i],
                    "Option": optionArray[i],
					"Average" : averageArray[i]
                });
			}
	} else {
		for (i = 0; i < <?php echo floor($I); ?>; i++) { 
				chartData.push({
                    "Time": timeInterval[i],
                    "Option": 0,
					"Average" : averageArray[i]
                });
			}
	}
               
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
		valueAxis.minimum = <?php echo json_encode($minYValue); ?>;
		chart.addValueAxis(valueAxis);

		// GRAPH
		var graph = new AmCharts.AmGraph();
		graph.title = nameOption;
        graph.valueField = "Option";
        graph.balloonText = "[[category]]: <b>[[value]]</b>";
		graph.showBalloon = false;
        graph.type = "column";
		graph.lineColor = "#4CAF50";
        graph.lineAlpha = 0;
        graph.fillAlphas = 0.8;
        chart.addGraph(graph);
		
		var graph2 = new AmCharts.AmGraph();
		graph2.title = nameAverage;
        graph2.type = "step"; // this line makes the graph smoothed line.
        graph2.lineColor = "#FF0000";
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