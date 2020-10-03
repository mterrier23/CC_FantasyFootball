<?php

// Initialize the session
session_start();
 
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
	<script src="https://www.w3schools.com/lib/w3.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
		form{ width: 30%;  margin: 100px auto;  padding: 30px;  border: 1px solid #555;	}
		input{ width: 100%;  border: 1px solid #f1e1e1;  display: block; padding: 5px 10px; }
		button { border: none; padding: 10px; border-radius: 5px;}
		table {  width: 60%; border-collapse: collapse; margin: 100px auto;}
		th,	td {  height: 50px;  vertical-align: center; border: 1px solid black;}
		.signout { text-align: right;}
		.modal {
		  display: none; 
		  position: fixed;
		  z-index: 1; 
		  padding-top: 100px; 
		  left: 0;
		  top: 0;
		  width: 100%;
		  height: 100%; 
		  overflow: auto;
		  background-color: rgb(0,0,0); 
		  background-color: rgba(0,0,0,0.4); 
		}
		.modal-content {
		  background-color: #fefefe;
		  margin: auto;
		  padding: 20px;
		  border: 1px solid #888;
		  width: 80%;
		}
		.close {
		  color: #aaaaaa;
		  float: right;
		  font-size: 28px;
		  font-weight: bold;
		}
		.close:hover,
		.close:focus {
		  color: #000;
		  text-decoration: none;
		  cursor: pointer;
		}
		
		#myInput {
		  width: 80%;
		  font-size: 16px;
		  border: 1px solid #ddd;
		  margin: 50px auto -75px;
		}

		#statTable {
		  border-collapse: collapse;
		  width: 80%;
		  border: 1px solid #ddd;
		  font-size: 12px;
		}

		#statTable th, #statTable td {
		  text-align: left;
		  padding: 12px;
		}

		#statTable tr {
		  border-bottom: 1px solid #ddd;
		}

		#statTable tr.header, #statTable tr:hover {
		  background-color: #f1f1f1;
		}


    </style>
</head>
<body>
    <p class="signout">
        <a href="logout.php" class="btn">Sign Out</a>
    </p>
						
	<!-- Modal for explaining column names -->
	<button id="myBtn">Explanations</button>
	
	<!-- The Modal -->
	<div id="myModal" class="modal">

	 <!-- Modal content -->
	<div class="modal-content">
		<span class="close">&times;</span>
		<p>
			<center><b>Statistics Explanations</b></center>
			</br>Rk = Rank
			</br>Pos = Position
			</br>G = Games Players
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
		  <?php foreach ($files as $file): ?>		<!-- STILL HAVE TO FIND OUT WHERE FILES COMES FROM -->
			<!--<tr class="item">
			  <td><?php echo $file['Rk']; ?></td>
			  <td><?php echo $file['Player']; ?></td>
			  <td><?php echo $file['Team']; ?></td>
			  <td><?php echo $file['Age']; ?></td>
			  <td><?php echo $file['Pos']; ?></td>
			  <td><?php echo $file['G']; ?></td>
			  <td><?php echo $file['GS']; ?></td>
			  <td><?php echo $file['Tgt']; ?></td>
			  <td><?php echo $file['Rec']; ?></td>
			  <td><?php echo $file['Ctch']; ?></td>
			  <td><?php echo $file['Yds']; ?></td>
			  <td><?php echo $file['YPR']; ?></td>
			  <td><?php echo $file['TD']; ?></td>
			  <td><?php echo $file['FD']; ?></td>
			  <td><?php echo $file['Lng']; ?></td>
			  <td><?php echo $file['YPT']; ?></td>
			  <td><?php echo $file['RPG']; ?></td>
			  <td><?php echo $file['YPG']; ?></td>
			  <td><?php echo $file['Fmb']; ?></td>
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
		  <?php endforeach;?>
		<!--</tbody>-->
		</table>
	</div>
	<a href="welcome.php" class="btn btn-primary">Search</a>
	
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

<!-- THIS WORKS !! -->
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

