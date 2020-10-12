<?php
// Initialize the session

// For error reporting
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

require_once "config.php";
 
$sql = "SELECT * FROM stats";
$result = mysqli_query($link, $sql);
$stats = mysqli_fetch_all($result, MYSQLI_ASSOC);

$id = $_SESSION['id'];
$rosterTmp = "SELECT s.Player as Player, s.Team as Team FROM roster r, stats s WHERE r.player_id = s.id AND r.username_id = $id";
$rosterResult = mysqli_query($link, $rosterTmp);
$players = mysqli_fetch_all($rosterResult, MYSQLI_ASSOC);


$weeks = range(1, 17);

$pointsTmp = "SELECT points FROM users WHERE id = $id";     // id is passed from the session variables occurs in login.php
$pointsResult = mysqli_query($link, $pointsTmp);
$points = mysqli_fetch_all($pointsResult, MYSQLI_ASSOC);
$currPoints = (int)$points[0];


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">
    <title>Results</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://www.w3schools.com/lib/w3.js"></script>
</head>
<body>
	<p class="signout">
        <a href="logout.php" class="btn">Sign Out</a>
	</p>
	<div class="header">
		<h1>Weekly Results</h1>
    </div>
	<div>
		<table id="statTable">
		  <tr>
			<th>Week</th>
			<th>Total Points</th>
			<th>Result</th>
		  </tr>
		  
		  <?php foreach ($weeks as $week): ?>  
			<tr class="item">
			  <td><?php echo $week; ?></td> 
			  <td>
			  <?php 
			  $weekInt = (int)$week;
			  


				// NOTE: reaches here
			
				foreach ($players as $player){ 
					$newPoints = 0;
					$playerName = $player['Player'];

					$winningTemp =  "SELECT * FROM results r, stats s WHERE r.Week = $weekInt AND s.Player = '$playerName' AND s.Team = r.WinningTeam";
								
					$winningRes = mysqli_query($link, $winningTemp);

					
					$winVal = mysqli_fetch_all($winningRes, MYSQLI_ASSOC);

					
	
					if(!empty($winVal)){$newPoints = 1;}
					$currPoints = $currPoints + $newPoints;
				}
				echo $currPoints;
			  ?>
			  </td> 
			  <td> 
				<?php foreach($players as $player):  ?>
				<?php 
					$playerName = $player['Player'];  
					$playerTeam = $player['Team']; 
					echo $playerName; 
				?>'s team, 
				<?php
					echo $playerTeam;
				?>, 
				<?php
				// Calculates if they won or loss
					$winningTemp =  "SELECT * FROM results r, stats s WHERE r.Week = $weekInt AND s.Player = '$playerName' AND s.Team = r.WinningTeam";			
					$winningRes = mysqli_query($link, $winningTemp);
					$winVal = mysqli_fetch_all($winningRes, MYSQLI_ASSOC);
					if(!empty($winVal)){ 
						echo "won. +1 points."; echo "<br>";
					} else {
						echo "lost. No points gained."; echo "<br>";
					}
					?>
				
				<?php endforeach; ?>
				</td>
			</tr>

		  <?php endforeach;  ?>
		  <br>
		  <h2><i> You scored <b>
			<?php
			echo $currPoints; 
			?> points!
		  </b</i></h2>
		</table>
	</div>
	

</body>
</html>
