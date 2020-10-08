<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://www.w3schools.com/lib/w3.js"></script>
</head>
<body>
	<p class="signout">
        <a href="logout.php" class="btn">Sign Out</a>
	</p>

	<div>
	
		<table id="statTable">
		  <tr>
			<th>Week</th>
			<th>Total Points</th>
			<th>Result</th>
		  </tr>
		  <?php for ($week = 1; $week <= 17; $week++): ?>  <!-- not sure if it would be : or { for this since it's broken up with html ... -->
			<tr class="item">
			  <td>$week</td> 
			  <td>
			  <?php 
			  
				// REFER TO MAILYS' ONE NOTE FOR LOGIC EXPLANATION
			  
				$currPoints = "SELECT points FROM users WHERE id = $id";     // id is passed from the session variables occurs in login.php
				$Players = "SELECT PlayerName FROM rosterDB WHERE userID = $id";
				
				foreach($Players as $player):  
					$newPoints = 0;
					$result =  "SELECT result FROM results r, stats s WHERE r.week = $week AND s.PlayerName = $player AND s.Team = r.Team";
					if($result == 'win'){$newPoints = 1;}
					$currPoints += $newPoints;
				endforeach;   

				echo $currPoints;
			  ?>
			  </td> 
			  <td>  
				<?php
				$Players = "SELECT PlayerName FROM rosterDB WHERE userID = $id";
				foreach($Players as $player):       // individual rows from the rosterDB
					echo $PlayerName; ?>'s team, <?php
				$Team = "SELECT Team FROM stats WHERE player = $player";    // player is the name of the column for player name in the states DB
				echo $Team;
				?>, <?php
				// Calculates if they won or loss
				$result =  "SELECT result FROM results r, stats s WHERE r.week = $week AND s.PlayerName = $player AND s.Team = r.Team";
				if ($result == "win"){echo "won. +1 points. ";}
				else {echo "lost. No points gained. ";} ?>
				
				<?php endforeach; ?>
				</td>
			</tr>

		  <?php endforeach;?>
		<!--</tbody>-->
		</table>
		<a href="welcome.php" class="btn btn-primary">Choose a new roster</a>
	</div>
	

</body>
</html>
