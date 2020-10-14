<?php
// Initialize the session
session_start();

require_once "config.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false)){
	header("location: login.php");
	exit;
}

$sql = "SELECT username_id FROM roster WHERE username_id=" . $_SESSION["id"];
                
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
	// Redirect to results page
	header("location: results.php");
	die();
}

$sql = "SELECT * FROM stats";
$result = mysqli_query($link, $sql);

$stats = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
		header("location: login.php");
		die();
	}

	$sql = "INSERT INTO roster (username_id, player_id) VALUES "
		. "(" . $_SESSION["id"] . "," . $_POST["qb"] . "),"
		. "(" . $_SESSION["id"] . "," . $_POST["rb1"] . "),"
		. "(" . $_SESSION["id"] . "," . $_POST["rb2"] . "),"
		. "(" . $_SESSION["id"] . "," . $_POST["wr1"] . "),"
		. "(" . $_SESSION["id"] . "," . $_POST["wr2"] . "),"
		. "(" . $_SESSION["id"] . "," . $_POST["te"] . ")";

	$result = $mysqli->query($sql);

	if ($result) {
		if ($mysqli->affected_rows > 0) {
			// Redirect to results page
			header("location: results.php");
		} else {
			echo "Ran into error. You may have selected the same player for 2 positions. Please change selection and try again.";
		}
	} else {
		echo "Ran into error. You may have selected the same player for 2 positions. Please change selection and try again.";
	}
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://www.w3schools.com/lib/w3.js"></script>
</head>
<body>
    <p class="signout">
        <a href="logout.php" class="btn">Sign Out</a>
	</p>

	<div class="main-container">
		<h1>Select Your Players</h1>
		<form class="roster-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="roster-dropdowns">
				<label>Quarterback</label>
				<select name="qb">
				<?php
					$sql = "SELECT id, Player FROM stats WHERE Pos='QB'";
					$result = $mysqli->query($sql);

					if ($result) {
						while ($row = $result->fetch_assoc()) {
							echo '<option value="' . $row['id'] . '">' . $row['Player'] . '</option>';
						}
					}
				?>
				</select>

				<label>Running Back 1</label>
				<select name="rb1">
				<?php
					$sql = "SELECT id, Player FROM stats WHERE Pos='RB'";
					$result = $mysqli->query($sql);

					if ($result) {
						while ($row = $result->fetch_assoc()) {
							echo '<option value="' . $row['id'] . '">' . $row['Player'] . '</option>';
						}
					}
				?>
				</select>

				<label>Running Back 2</label>
				<select name="rb2">
				<?php
					$sql = "SELECT id, Player FROM stats WHERE Pos='RB'";
					$result = $mysqli->query($sql);

					if ($result) {
						while ($row = $result->fetch_assoc()) {
							echo '<option value="' . $row['id'] . '">' . $row['Player'] . '</option>';
						}
					}
				?>
				</select>

				<label>Wide Receiver 1</label>
				<select name="wr1">
				<?php
					$sql = "SELECT id, Player FROM stats WHERE Pos='WR'";
					$result = $mysqli->query($sql);

					if ($result) {
						while ($row = $result->fetch_assoc()) {
							echo '<option value="' . $row['id'] . '">' . $row['Player'] . '</option>';
						}
					}
				?>
				</select>

				<label>Wide Receiver 2</label>
				<select name="wr2">
				<?php
					$sql = "SELECT id, Player FROM stats WHERE Pos='WR'";
					$result = $mysqli->query($sql);

					if ($result) {
						while ($row = $result->fetch_assoc()) {
							echo '<option value="' . $row['id'] . '">' . $row['Player'] . '</option>';
						}
					}
				?>
				</select>

				<label>Tight End</label>
				<select name="te">
				<?php
					$sql = "SELECT id, Player FROM stats WHERE Pos='TE'";
					$result = $mysqli->query($sql);

					if ($result) {
						while ($row = $result->fetch_assoc()) {
							echo '<option value="' . $row['id'] . '">' . $row['Player'] . '</option>';
						}
					}
				?>
				</select>
			</div>
			<input type="submit" class="btn btn-primary" value="Submit">
		</form>
							
		<!-- Modal for explaining column names -->
		<button id="myBtn">Table Key</button>
		
		<!-- The Modal -->
		<div id="myModal" class="modal">

		<!-- Modal content -->
		<div class="modal-content">
			<span class="close">&times;</span>
			<p>
				</br>Pos = Position
				</br>G = Games Played
				</br>GS = Games Started
				</br>Rec = Receptions
				</br>Ctch% = Catch Percentage
				</br>Yds = Receiving Yards
				</br>TD = Receiving Touchdowns
				</br>1D = First Downs Receiving
				</br>Lng = Longest Reception
				</br>Y/Tgt = Receiving Yards per Target
			</p>
		</div>

		</div>
		<div>
		
			<input type="text" id="myInput" onkeyup="searchPlayer()" placeholder="Search Player Name" title="Type in a name">
			<table id="statTable">
				<tr>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(1)')" style="cursor:pointer">Player</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(2)')" style="cursor:pointer">Team</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(3)')" style="cursor:pointer">Age</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(4)')" style="cursor:pointer">Pos</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(5)')" style="cursor:pointer">G</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(6)')" style="cursor:pointer">GS</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(7)')" style="cursor:pointer">Rec</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(8)')" style="cursor:pointer">Ctch%</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(9)')" style="cursor:pointer">Yds</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(10)')" style="cursor:pointer">TD</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(11)')" style="cursor:pointer">1D</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(12)')" style="cursor:pointer">Lng</th>
					<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(13)')" style="cursor:pointer">Y/Tgt</th>
				</tr>
				<?php foreach ($stats as $stat): ?>		
				<tr class="item">
					<td><?php echo $stat['Player']; ?></td>
					<td><?php echo $stat['Team']; ?></td>
					<td><?php echo $stat['Age']; ?></td>
					<td><?php echo $stat['Pos']; ?></td>
					<td><?php echo $stat['G']; ?></td>
					<td><?php echo $stat['GS']; ?></td>
					<td><?php echo $stat['Rec']; ?></td>
					<td><?php echo $stat['Ctch']; ?></td>
					<td><?php echo $stat['Yds']; ?></td>
					<td><?php echo $stat['TD']; ?></td>
					<td><?php echo $stat['OD']; ?></td>
					<td><?php echo $stat['Lng']; ?></td>
					<td><?php echo $stat['YPT']; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
	
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// NOTE: not working right now
function searchPlayer() {   
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("statTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}


</script>
</body>
</html>

