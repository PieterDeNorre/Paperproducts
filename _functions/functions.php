<?php
	

// COLLECTION

	function AllColl () {
		include "_php/db_config.php";
		include "_php/db_connect.php";


		echo "<div id='cont'><ul>	<li class='home'><a href='index.php'>Home</a></li>
				<li class='home'>Collections</li>
				<li class='contact'><a href='contact.php'>Contact</a></li>
			</ul></div>
			<div id='cont'><ul>";


		$query=mysqli_query($connect, " SELECT * FROM collections WHERE coll_active = '1'");
		mysqli_close($connect);

		$numa=mysqli_num_rows($query);
		$i=0;

		while ($i < $numa) {
			mysqli_data_seek($query,$i);
			$row=mysqli_fetch_row($query);
			$coll_name=html_entity_decode($row[2]);
			$coll_id=html_entity_decode($row[1]);
			$coll_sub_id= $coll_id . "_1";

			echo "<li><a href='collections.php?coll_id=$coll_id&coll_sub_id=$coll_sub_id'>" . $coll_name . "</a></li>";

			$i++;
		};

		echo "</ul></div>";
	}

	function ActiveColl ($coll_id) {
		include "_php/db_config.php";
		include "_php/db_connect.php";

		$result = mysqli_query($connect, " SELECT * FROM collections WHERE coll_id = $coll_id ");
		mysqli_close($connect);

		$row = mysqli_fetch_row ($result);

		echo $row[2] ;

	}

// DESIGN INFO

	function GetDesign ($coll_id, $coll_sub_id) {
		include "_php/db_config.php";
		include "_php/db_connect.php";

		include "_functions/variables.php";

		$result = mysqli_query($connect, " SELECT * FROM design WHERE coll_id = $coll_id ");
		mysqli_close($connect);

		$row = mysqli_fetch_row ($result);

		echo "<ul>";
		echo "<li><a href='collections.php?coll_id=$coll_id&coll_sub_id=$row[3]&type_id=$type_id'><img src='_img/color/" . $row[3] . "_C.png'/></a></li>";
		echo "<li><a href='collections.php?coll_id=$coll_id&coll_sub_id=$row[5]&type_id=$type_id'><img src='_img/color/" . $row[5] . "_C.png'/></a></li>";
		echo "<li><a href='collections.php?coll_id=$coll_id&coll_sub_id=$row[7]&type_id=$type_id'><img src='_img/color/" . $row[7] . "_C.png'/></a></li>";
		echo "<li><a href='collections.php?coll_id=$coll_id&coll_sub_id=$row[9]&type_id=$type_id'><img src='_img/color/" . $row[9] . "_C.png'/></a></li>";
		echo "<li><a href='collections.php?coll_id=$coll_id&coll_sub_id=$row[11]&type_id=$type_id'><img src='_img/color/" . $row[11] . "_C.png'/></a></li>";
		echo "<li><a href='collections.php?coll_id=$coll_id&coll_sub_id=$row[13]&type_id=$type_id'><img src='_img/color/" . $row[13] . "_C.png'/></a></li>";
		echo "<li><a href='collections.php?coll_id=$coll_id&coll_sub_id=$row[15]&type_id=$type_id'><img src='_img/color/" . $row[15] . "_C.png'/></a></li>";
		echo "</ul>";
		echo "<div id='coverimg'><img src='_img/collections/" . $coll_sub_id . ".png'/></div>";
	}

// TECHNICAL INFO
	function ActiveType ($type_id) {
		include "_php/db_config.php";
		include "_php/db_connect.php";

		$result = mysqli_query($connect, " SELECT type_name FROM finishing WHERE type_id = $type_id ");
		mysqli_close($connect);

		$row = mysqli_fetch_row ($result);

		echo $row[0] ;

	}

	function GetTech () {
		include "_php/db_config.php";
		include "_php/db_connect.php";

		include "_functions/variables.php";

		echo "<ul>";

		$techtype = mysqli_query($connect, " SELECT type_name , type_id FROM finishing ");
		mysqli_close($connect);

		$num = mysqli_num_rows ($techtype);

		$i=0;

		while ($i < $num) {
			mysqli_data_seek($techtype,$i);
			$row=mysqli_fetch_row($techtype);
			$type_name=html_entity_decode($row[0]);
			$type_id=html_entity_decode($row[1]);

			echo "<li><a href='collections.php?coll_id=$coll_id&coll_sub_id=$coll_sub_id&type_id=$type_id'>" . $type_name . "</a></li>";

			$i++;

		};

		echo "</ul>";
	}

	function TechDetOne ($type_id) {
		include "_php/db_config.php";
		include "_php/db_connect.php";

		include "_functions/variables.php";

		$techtype = mysqli_query($connect, " SELECT * 
							FROM finishing
							INNER JOIN cover ON finishing.type_id = cover.type_id
							WHERE finishing.type_id =$type_id");
		mysqli_close($connect);

		$num =mysqli_num_rows($techtype);
		$row=mysqli_fetch_row($techtype);

		// MM or NOT
		if ($row[3] == "A4" ) {
			$test = "";
		} elseif ($row[3] == "A4 / A5") {
			$test = "";
		} else {
			$test = " mm";
		}

		// PLASTIFICATION DETERMINER
		$plast = 1;
		if ($type_id == 4 | $type_id == 5){ 
			$plast = 0;
		} else { 
			$plast =1;
		}


		echo "<h2>Size</h2>" ;
		echo "<div id='tech' class='active_1'>" . html_entity_decode($row[3]) . $test . "</div>";

		echo "<br><h2>Binding options</h2>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[4]) . "'>Glued</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[5]) . "'>Wire-O</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[6]) . "'>Sown</div>";

		echo "<br><h2>Corner options</h2>" ;
		echo "<div id='tech' class='active_1'>Straight corners</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[7]) . "'>Rounded corners</div>";

		echo "<br><h2>Cover options</h2>" ;
		echo "<div id='tech' class='active_" . html_entity_decode($row[11]) . "'>Flap left</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[12]) . "'>Double</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[13]) . "'>Softcover</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[14]) . "'>Hardcover</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[15]) . "'>Leather</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[16]) . "'>Cardboard</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[17]) . "'>Linnen Softcover</div>";

		echo "<br><h2>Cover extra finishing</h2>" ;
		echo "<div id='tech' class='active_" . $plast . "'>Softtouch plastification</div>";
	}

	function TechDetTwo ($type_id) {
		include "_php/db_config.php";
		include "_php/db_connect.php";

		include "_functions/variables.php";

		$techtype = mysqli_query($connect, " SELECT * 
							FROM inside
							WHERE type_id =$type_id");
		mysqli_close($connect);

		$num =mysqli_num_rows($techtype);
		$row=mysqli_fetch_row($techtype);

		echo "<h2>Size</h2>" ;
		echo "<div id='tech' class='active_" . html_entity_decode($row[3]) . "'>Lines</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[4]) . "'>Squares</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[5]) . "'> Lines / Notebook</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[6]) . "'>Notes right / Diary left</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[7]) . "'>Academic Diary</div>";
		echo "<div id='tech' class='active_" . html_entity_decode($row[8]) . "'>Note right / Academic Diary left</div>";
	}
// NAVIGATION GLOBAL
	function PrevColl ($coll_id){
		include "_php/db_config.php";
		include "_php/db_connect.php";

		include "_functions/variables.php";

		$query=mysqli_query($connect, " SELECT coll_name FROM collections WHERE coll_active = '1'");

		$numa=mysqli_num_rows($query);

		if ($coll_id == 1) {
			$prev_id = $numa;
		} else {
			$prev_id = $coll_id - 1;
		}
		$prev_sub_id = $prev_id . "_1";

		$query=mysqli_query($connect, " SELECT coll_name FROM collections WHERE coll_id = $prev_id");
		mysqli_close($connect);

		$numa2=mysqli_num_rows($query);
		$row=mysqli_fetch_row($query);

		echo "<a href='collections.php?coll_id=$prev_id&coll_sub_id=$prev_sub_id'> " . $row[0] . "</a>";
	}

	function NextColl ($coll_id){
		include "_php/db_config.php";
		include "_php/db_connect.php";

		include "_functions/variables.php";
		$query=mysqli_query($connect, " SELECT * FROM collections WHERE coll_active = '1'");


		$numa=mysqli_num_rows($query);

		if ($coll_id ==$numa) {
			$next_id = 1;
		} else {
			$next_id = $coll_id + 1;
		}
		$next_sub_id = $next_id . "_1";

		$query=mysqli_query($connect, " SELECT coll_name FROM collections WHERE coll_id = $next_id");
		mysqli_close($connect);

		$numa2=mysqli_num_rows($query);
		$row=mysqli_fetch_row($query);

		echo "<a href='collections.php?coll_id=$next_id&coll_sub_id=$next_sub_id'>" . $row[0] . " </a>";

	}
?>