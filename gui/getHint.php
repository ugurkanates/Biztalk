<?php
	require_once ('session.php');
	header('Content-Type: application/json');
	if ($db->connect_error) {
	        die("Connection failed: " . $db->connect_error);
	    }
	if(!empty($_POST["keyword"])) {
		$keyword = $_POST["keyword"];
		$keywords = explode(",", $keyword);
		$relativesString = "";
		for ($i=0; $i < sizeof($keywords)-1; $i++) { 
			$relativesString = $relativesString.$keywords[$i];
			if($i != sizeof($keywords)-1)
				$relativesString = $relativesString.",";
		}
		$query ="SELECT username, id FROM tbl_usr WHERE username like '" . $keywords[sizeof($keywords)-1] . "%' ORDER BY username";
		$result = mysqli_query($db, $query);
	    while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		if(!empty($resultset)) {
			?>
			<select class="form-control mb-4" id="user-list" name="user-list" multiple="multiple">
			<?php
			foreach($resultset as $user) {
			?>
			<option onClick="selectRelative('<?php echo $relativesString.$user["id"]; ?>');" value='<?php echo $user["id"]; ?>'><?php echo $user["id"]."-".$user["username"]; ?></option>
			<?php 
			} 
			?>
			</select>
		<?php
		}
	}else{
		$relativesString = "";
		$query ="SELECT username, id FROM tbl_usr WHERE type = 'user' or type = 'manager' ORDER BY username";
		$result = mysqli_query($db, $query);
	    while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}
		if(!empty($resultset)) {
			?>
			<select class="form-control mb-4" id="user-list" name="user-list" multiple="multiple">
			<?php
			foreach($resultset as $user) {
			?>
			<option onClick="selectRelative('<?php echo $user["id"]; ?>');" value='<?php echo $user["id"]; ?>'><?php echo $user["id"]."-".$user["username"]; ?></option>
			<?php 
			} 
			?>
			</select>
		<?php
		}
	}
?>