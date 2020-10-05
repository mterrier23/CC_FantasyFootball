<?php
// Initialize the session
session_start();

require_once "config.php";
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>
 
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

	<div class="main-container">
		<div class="roster-dropdowns">
			<label>Quarterback:</label>
			<select>
			<?php
				$sql = "SELECT id, Player FROM stats WHERE Pos='QB'";
				$result = $mysqli->query($sql);

				if ($result) {
					while ($row = $result->fetch_assoc()) {
						echo '<option value="' . $row['Player'] . '">' . $row['Player'] . '</option>';
					}
				}
			?>
			</select>

			<label>Running Back 1:</label>
			<select>
			<?php
				$sql = "SELECT id, Player FROM stats WHERE Pos='RB'";
				$result = $mysqli->query($sql);

				if ($result) {
					while ($row = $result->fetch_assoc()) {
						echo '<option value="' . $row['Player'] . '">' . $row['Player'] . '</option>';
					}
				}
			?>
			</select>

			<label>Running Back 2:</label>
			<select>
			<?php
				$sql = "SELECT id, Player FROM stats WHERE Pos='RB'";
				$result = $mysqli->query($sql);

				if ($result) {
					while ($row = $result->fetch_assoc()) {
						echo '<option value="' . $row['Player'] . '">' . $row['Player'] . '</option>';
					}
				}
			?>
			</select>

			<label>Wide Receiver 1:</label>
			<select>
			<?php
				$sql = "SELECT id, Player FROM stats WHERE Pos='WR'";
				$result = $mysqli->query($sql);

				if ($result) {
					while ($row = $result->fetch_assoc()) {
						echo '<option value="' . $row['Player'] . '">' . $row['Player'] . '</option>';
					}
				}
			?>
			</select>

			<label>Wide Receiver 2:</label>
			<select>
			<?php
				$sql = "SELECT id, Player FROM stats WHERE Pos='WR'";
				$result = $mysqli->query($sql);

				if ($result) {
					while ($row = $result->fetch_assoc()) {
						echo '<option value="' . $row['Player'] . '">' . $row['Player'] . '</option>';
					}
				}
			?>
			</select>

			<label>Tight End:</label>
			<select>
			<?php
				$sql = "SELECT id, Player FROM stats WHERE Pos='TE'";
				$result = $mysqli->query($sql);

				if ($result) {
					while ($row = $result->fetch_assoc()) {
						echo '<option value="' . $row['Player'] . '">' . $row['Player'] . '</option>';
					}
				}
			?>
			</select>
		</div>
							
		<!-- Modal for explaining column names -->
		<button id="myBtn">Table Key</button>
		
		<!-- The Modal -->
		<div id="myModal" class="modal">

		<!-- Modal content -->
		<div class="modal-content">
			<span class="close">&times;</span>
			<p>
				</br>Rk = Rank
				</br>Pos = Position
				</br>G = Games Played
				</br>GS = Games Started
				</br>Tgt = Pass Targets
				</br>Rec = Receptions
				</br>Ctch% = Catch Percentage
				</br>Yds = Receiving Yards
				</br>Y/R = Receiving Yards per Receptions
				</br>TD = Receiving Touchdowns
				</br>1D = First Downs Receiving
				</br>Lng = Longest Reception
				</br>Y/Tgt = Receiving Yards per Target
				</br>R/G = Receptions Per Game
				</br>Y/G = Receiving Yards Per Game
				</br>Fmb = Fumbles	
			</p>
		</div>

		</div>
		<div>
		
			<input type="text" id="myInput" onkeyup="searchPlayer()" placeholder="Search Player Name" title="Type in a name">
			<table id="statTable">
			<!--<thead>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(1)')" style="cursor:pointer">Rk</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(2)')" style="cursor:pointer">Player</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(3)')" style="cursor:pointer">Team</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(4)')" style="cursor:pointer">Age</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(5)')" style="cursor:pointer">Pos</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(6)')" style="cursor:pointer">G</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(7)')" style="cursor:pointer">GS</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(8)')" style="cursor:pointer">Tgt</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(9)')" style="cursor:pointer">Rec</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(10)')" style="cursor:pointer">Ctch%</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(11)')" style="cursor:pointer">Yds</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(12)')" style="cursor:pointer">Y/R</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(13)')" style="cursor:pointer">TD</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(14)')" style="cursor:pointer">1D</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(15)')" style="cursor:pointer">Lng</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(16)')" style="cursor:pointer">Y/Tgt</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(17)')" style="cursor:pointer">R/G</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(18)')" style="cursor:pointer">Y/G</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(19)')" style="cursor:pointer">Fmb</th>
			</thead>-->
			<tr>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(1)')" style="cursor:pointer">Rk</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(2)')" style="cursor:pointer">Player</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(3)')" style="cursor:pointer">Team</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(4)')" style="cursor:pointer">Age</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(5)')" style="cursor:pointer">Pos</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(6)')" style="cursor:pointer">G</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(7)')" style="cursor:pointer">GS</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(8)')" style="cursor:pointer">Tgt</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(9)')" style="cursor:pointer">Rec</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(10)')" style="cursor:pointer">Ctch%</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(11)')" style="cursor:pointer">Yds</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(12)')" style="cursor:pointer">Y/R</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(13)')" style="cursor:pointer">TD</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(14)')" style="cursor:pointer">1D</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(15)')" style="cursor:pointer">Lng</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(16)')" style="cursor:pointer">Y/Tgt</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(17)')" style="cursor:pointer">R/G</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(18)')" style="cursor:pointer">Y/G</th>
				<th onclick="w3.sortHTML('#statTable', '.item', 'td:nth-child(19)')" style="cursor:pointer">Fmb</th>
			</tr>
			<!--<tbody>-->
			<!--  <?php foreach ($stats as $stat): ?> -->
				<!--<tr class="item">
				<td><?php echo $stat['Rk']; ?></td>
				<td><?php echo $stat['Player']; ?></td>
				<td><?php echo $stat['Team']; ?></td>
				<td><?php echo $stat['Age']; ?></td>
				<td><?php echo $stat['Pos']; ?></td>
				<td><?php echo $stat['G']; ?></td>
				<td><?php echo $stat['GS']; ?></td>
				<td><?php echo $stat['Tgt']; ?></td>
				<td><?php echo $stat['Rec']; ?></td>
				<td><?php echo $stat['Ctch']; ?></td>
				<td><?php echo $stat['Yds']; ?></td>
				<td><?php echo $stat['YPR']; ?></td>
				<td><?php echo $stat['TD']; ?></td>
				<td><?php echo $stat['FD']; ?></td>
				<td><?php echo $stat['Lng']; ?></td>
				<td><?php echo $stat['YPT']; ?></td>
				<td><?php echo $stat['RPG']; ?></td>
				<td><?php echo $stat['YPG']; ?></td>
				<td><?php echo $stat['Fmb']; ?></td>
				</tr>-->
				<!-- sample input -->
				<tr class="item">
				<td>1</td>
				<td>John</td>			 
				<td>SEA</td>
				<td>23</td>
				<td>RB</td>
				<td>3</td>
				<td>5</td>
				<td>4</td>
				<td>4</td>
				<td>4</td>
				<td>4</td>
				<td>32</td>
				<td>4</td>
				<td>4</td>
				<td>4</td>
				<td>4</td>
				<td>4</td>
				<td>3</td>
				<td>2</td>
				</tr>
				<tr class="item">
				<td>2</td>
				<td>Alex</td>			 
				<td>DEV</td>
				<td>34</td>
				<td>QB</td>
				<td>2</td>
				<td>7</td>
				<td>8</td>
				<td>1</td>
				<td>9</td>
				<td>6</td>
				<td>8</td>
				<td>3</td>
				<td>6</td>
				<td>7</td>
				<td>4</td>
				<td>3</td>
				<td>8</td>
				<td>2</td>
				</tr>	
				<tr class="item">
				<td>3</td>
				<td>Bob</td>			 
				<td>OHIO</td>
				<td>20</td>
				<td>RB</td>
				<td>3</td>
				<td>5</td>
				<td>4</td>
				<td>8</td>
				<td>4</td>
				<td>4</td>
				<td>32</td>
				<td>4</td>
				<td>4</td>
				<td>4</td>
				<td>4</td>
				<td>4</td>
				<td>3</td>
				<td>2</td>
				</tr>
			<!--  <?php endforeach;?> -->
			<!--</tbody>-->
			</table>
		</div>
		<a href="welcome.php" class="btn btn-primary">Search</a>
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

function searchPlayer() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("statTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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

