<?php
// Initialize the session

// For error reporting
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(!isset($_SESSION["loggedin"]) || (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false)){
	header("location: login.php");
	exit;
}

require_once "config.php";
 
$sql = "SELECT * FROM stats";
$result = mysqli_query($link, $sql);
$stats = mysqli_fetch_all($result, MYSQLI_ASSOC);

$id = $_SESSION['id'];
$rosterTmp = "SELECT s.Player as Player, s.Team as Team FROM roster r, stats s WHERE r.player_id = s.id AND r.username_id = $id";
$rosterResult = mysqli_query($link, $rosterTmp);
$players = mysqli_fetch_all($rosterResult, MYSQLI_ASSOC);

$usersTmp = "SELECT * FROM users";
$userResult = mysqli_query($link, $usersTmp);
$users = mysqli_fetch_all($userResult, MYSQLI_ASSOC);

$weeks = range(1, 17);

$pointsTmp = "SELECT points FROM users WHERE id = $id";     // id is passed from the session variables occurs in login.php
$pointsResult = mysqli_query($link, $pointsTmp);
$points = mysqli_fetch_all($pointsResult, MYSQLI_ASSOC);
$currPoints = 0;

$currUserPoints = 0;
$user_id = 0;


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
		<table id="leaderBoard">
			<!-- this table is going to have the players compared to each other in the rows, and the weeks in the columns -->
		  <tr>
			<th>Player Name</th>
			
			<?php foreach ($weeks as $week): ?>  
			<th>W<?php echo $week?></th>
			<?php endforeach; ?>
			
			<th>Final Points</th>
			
		  </tr>
		  
		  <?php foreach ($users as $user) : 
			$finalPoints = 0;			
			$user_id = $user['id'];
			?>
		  <tr class="item">
		  
			<td><?php echo $user['username']; ?></td> 	<!-- NOTE -- confirm that 'username' is the correct column name -->
			
			<!-- the following code represents each column for each week for each player lol -->
			<?php foreach ($weeks as $week): ?>  
			<td> 
				<!-- point for that week for that player -->
				<?php
				$weekInt = (int)$week;			
				$s_rosterTmp = "SELECT s.Player as Player, s.Team as Team FROM roster r, stats s WHERE r.player_id = s.id AND r.username_id = $user_id";
				$s_rosterResult = mysqli_query($link, $s_rosterTmp);
				$s_players = mysqli_fetch_all($s_rosterResult, MYSQLI_ASSOC);
				$newPoints = 0;
				foreach ($s_players as $s_player){ 
					
					$playerName = $s_player['Player'];

					$s_winningTemp =  "SELECT * FROM results r, stats s WHERE r.Week = $weekInt AND s.Player = '$playerName' AND s.Team = r.WinningTeam";
								
					$s_winningRes = mysqli_query($link, $s_winningTemp);

					
					$s_winVal = mysqli_fetch_all($s_winningRes, MYSQLI_ASSOC);

					
	
					if(!empty($s_winVal)){$newPoints += 1;}
				}
				echo $newPoints;
				$finalPoints += $newPoints;

				if ($user_id == $id){
					$currUserPoints = $finalPoints;
				}
				//echo $currPoints;
				// update currPoints into users table at points column
			
				?>
			</td>
			<?php endforeach; ?> <!-- end weeks loop for specific user -->
			<td>
			<?php echo $finalPoints; ?>
			</td>
          
		  </tr>
		  <?php endforeach;  ?> <!-- end users loop -->
			
		</table>
	</div>
	<h2><i> You scored <b>
			<?php
			echo $currUserPoints;  
			?> points!
		  </b</i></h2>
	<div>
		<br>
		<h2>Your Breakdown</h2>
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
		</table>
	</div>
	

</body>
</html>
