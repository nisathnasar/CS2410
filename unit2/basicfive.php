<!DOCTYPE html>
<html>
<head>
  <title> Basic PHP Programing </title>
</head>

<body>
	<h1>Tasks</h1>

	<!-- Task 1: String-->
	<!-- write your solution to Task 1 here -->
	<div class="section">
		<h2>Task 1 : String</h2>
		<?php
		$var1="I love programming";
		print($var1);
		print("<br>First letter is: " . substr($var1, 0, 1));
		print("<br>Length of string is: " . strlen($var1) . "\n");
		print("<br>Last letter is: " . substr($var1, strlen($var1)-1, 1));
		print("<br>First 6 letters are: " . substr($var1, 0, 6));
		print("<br>In capital: " . strtoupper($var1));
		 ?>
	
	
	</div>

	<!-- Task 2: Array and image-->
	<!-- write your solution to Task 2 here -->
	<div class="section">
		<h2>Task 2 : Array and image</h2>
		<?php
		$images = array();
		$images[0] = "<img src=\"images/earth.jpg\" width=\"20%\">";
		$images[1] = "<img src=\"images/flower.jpg\" width=\"20%\">";
		$images[2] = "<img src=\"images/plane.jpg\" width=\"20%\">";
		$images[3] = "<img src=\"images/tiger.jpg\" width=\"20%\">";
		$rndint = rand() % 4;
		print($images[$rndint]);
		?>
		
		
	</div>	

	<!-- Task 3: Function definition dayinmonth  -->
	<!-- write your solution to Task 3 here -->
	<div class="section">
		<h2>Task 3 : Function definition</h2>
		<?php
		function daysInMonth($monthNumber){
			if($monthNumber % 2 != 0){
				print("<br> 31");
			} else if ($monthNumber == 2){
				print("<br> 28");
			} else{
				print("<br> 30");
			}
		}
		daysInMonth(1);
		daysInMonth(2);
		daysInMonth(3);
		daysInMonth(4);
		daysInMonth(5);
		daysInMonth(6);
		daysInMonth(7);
		daysInMonth(8);
		daysInMonth(9);
		daysInMonth(10);
		daysInMonth(11);
		daysInMonth(12);
		?>
	</div>
		
	<!-- Task 5: Directory operations -->
	<!-- write your solution to Task 5 here -->
	<div class="section">
		<h2>Task 5 : Directory operations</h2>
		<?php
		$filesarr = scandir('..');
		for($int=0; $int < count($filesarr); $int++){
			if(is_file('../' . $filesarr[$int])){
				print("<br>".$filesarr[$int]);
			}
		}
		?>
	</div>

	<!-- Task 5 optional: Directory operations -->
	<!-- write your solution to Task 5 optional here -->
	<div class="section">
		<h2>Task 5 optional: Directory operations optional</h2>
		<?php
		function printfiles($directory){
			$filesarr = scandir($directory);
			for($int=0; $int < count($filesarr); $int++){
				if(is_file('../' . $filesarr[$int])){
					print("<br>".$filesarr[$int]);
				}/*
				if(is_dir('../' . $filesarr[$int])){
					//printfiles('../'.$filesarr[$int]);
					$filesarr2 = scandir('../'.$filesarr[$int]);
					for($int=0; $int < count($filesarr2); $int++){
						if(is_file('../' . $filesarr2[$int])){
							print("<br>".$filesarr2[$int]);
						}
					}
				}*/
			}
		}
		printfiles('..');
		?>
	
	
	</div>
	</div>


	
    <!-- Task 4: including external files -->
	<!-- write your solution to Task 5 here -->
	<div class="section">
		<h2>Task 4: including external files</h2>
		<?php
		include("footer.php");
		?>
			
	</div>

</body>
</html>
