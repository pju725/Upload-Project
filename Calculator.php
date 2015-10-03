<html>
<head>
	<title>Calculator</title>
</head>
<body>
	<h1>Calculator</h1>
	Type an expression in the following box (e.g., 10.5+20*3/25).
	<p>
		<form action = "calculator.php" method = "GET">
			<input type = "text" name = "expr" />
			<input type = "submit" value="Calculate"/>
		</form>
	</p>





	<?php
	if($_GET["expr"]){
		$equ = $_GET["expr"];


		//Handle invalid expression error: 
		//1. containing special character 
		//2. containing only whitespace
		//3,4,5,6. consecutive operators + * / or consecutive decimal points .
		//7,8. start or end with operators + * / or decimal points .
		//9. start with --
		//10. + used as a positive sign, i.e. * / - followed by +
		//11,12. consecutive 0 as a number
		//13,14. 0 in front of a number, e.g. 001 020
		//15. special case e.g. 2.3.4
		if (preg_match("/[^0-9+\-*\/\s\.]+/", $equ) 
			|| preg_match("/^\s+$/", $equ)
			|| preg_match("/[+*\/\.]{2,}/", $equ)
			|| preg_match("/[\-]{1}[*\/\.]+/", $equ)
			|| preg_match("/[\.]+[\-]{1}/", $equ)
			|| preg_match("/[+*\/\.\-]{3,}/", $equ)
			|| preg_match("/^[+*\/\.]+/", $equ)
			|| preg_match("/[+*\/\.\-]+$/", $equ)
			|| preg_match("/^[-]{2,}/", $equ)
			|| preg_match("/[-]+[+]+/", $equ)
			|| preg_match("/[^0-9\.]+[0]{2,}/", $equ)
			|| preg_match("/^[0]{2,}/", $equ)
			|| preg_match("/[+\-*\/]{1}[0]{1}[1-9]{1}/", $equ)
			|| preg_match("/^[0]{1}[1-9]{1}/", $equ)
			|| preg_match("/[.]+[0-9]+[.]+/", $equ)){
			$res = "Invalid Expression!";
		}
		//Handle division by zero error: 
		else if(preg_match("/[0-9]{1}[\/]{1}[0]{1}[^\.]{1}/", $equ)
			|| preg_match("/[0-9]{1}[\/]{1}[0]{1}$/", $equ)
			|| preg_match("/[0-9]{1}[\/]{1}[0]{1}[\.]{1}[0]+[^0-9]{1}/", $equ)
			|| preg_match("/[0-9]{1}[\/]{1}[0]{1}[\.]{1}[0]+$/", $equ)){
			$res = "Division by zero error!";
		}
		//Calculate
		else {
			$newequ = preg_replace("/[\-]{2}/", "+", $equ);
			eval("\$ans = $newequ;");
			$res = $equ." = ".$ans."\n";
		}

		print("<h2>Result</h2>");
		print("<p>");
		echo $res;
		print("</p>");

	}
	?>

</body>
</html>
