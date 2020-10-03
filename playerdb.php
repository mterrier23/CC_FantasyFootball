<form>

	<p>
		<input name="search" placeholder="Enter name">
	</p>
	
	<input type="submit" name="submit">
	
</form>

<style>
	table {
		border: 1px solid black;
		border-collapse: collaphse;
		margin-bottom: 30px;
	}
	th, td {
		border: 1px solid black;
		padding: 25px;
	}
</style>

<?php>


// Include config file
require_once "config.php";
 
 
if(isset($_GET["submit"}))
{
	$search = $_GET["search"];
	
	$tables = mysqli_query($link, "SHOW TABLES");
	// loop thru each table:
	while($table = mysqli_fetch_object($tables))
	{
		$table_name = $table->"Tables in my db"};
		// to search input value of each column of each table:
		$sql = "SELECT * FROM " . $table_name . " WHERE ";
		$field = array(); // from mySQL only
		
		$columns = mysqli_query($link, "SHOW COLUMNS FROM " . $table_name);
		?>
		<table>
		
			<caption>
				<?php echo $table_name; ?>
			</caption>
			<tr>
				<!-- loop thru each column : -->
					<?php while ($col = mysqli_fetch_object($columns)) {
						
						array_push($fields, $col->Field . " LIKE '%" . $search . "%'");
						
						?>
						<th>
							<?php echo $col->Field; ?>
							<!-- Field variable is column name -->
						</th>
					<?php } 
					
						mysqli_data_seek($columns, 0);
					
					?>
			</tr>
			
			<?php
				$sql .= implode(" OR ", $fields);
				$result = mysqli_query($conn, $sql);
				
				while($row = mysqli_fetch_object($result))
				{
					?>
					<tr>
						<?php while ($col = mysqli_fetch_object($columns)) { ?>
						
							<td>
							
								<?php echo $row->{$col->Field}; ?>
							
							</td>
							
						<?php } ?>
						
					</tr>
					
					<?php
			?>
			
		</table>
		
		<?php
		//		$sql .= imploe(" OR ", $fields);	echo $sql;
		// ^^ to check what sql query you need to run
		
	}
}