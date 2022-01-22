<?php ob_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Database</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<?php

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "demo";

		$conn = mysqli_connect($servername, $username, $password, $dbname);

		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		} 

	?>

	<div class="w-100 d-flex justify-content-center mt-5">
		<table class="table table-bordered w-50">
			<thead>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>Sex</th>
					<th>Position</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

				<?php

					$query = "SELECT * FROM users";
					$result = mysqli_query($conn, $query);

					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							$userId = $row['user_id'];
							$username = $row['username'];
							$sex = $row['sex'];
							$position = $row['position'];

							?>


								<tr>
									<td><?php echo $userId; ?></td>
									<td><?php echo $username; ?></td>
									<td><?php echo $sex; ?></td>
									<td><?php echo $position; ?></td>
									<td><a class="btn btn-danger" href="database.php?delete=<?php echo $userId; ?>">Delete</a></td>
								</tr>


							<?php
						}
					} else echo "0 data";
				?>

			</tbody>
		</table>
	</div>



	<?php


		if (isset($_GET['delete'])) {
			$userId = $_GET['delete'];

			$query = "DELETE FROM users WHERE user_id = $userId";
			$result = mysqli_query($conn, $query);

			if (!$result) {
				echo "<script>alert('Erorr create user!')</script>";
			} else {
				echo "<script>alert('Create user successfully!')</script>";
				header('Location: database.php');
			}
		}


	?>




	<?php

		if (isset($_POST['create_user'])) {
			$username = mysqli_real_escape_string($conn, $_POST['usename']);
			$sex = mysqli_real_escape_string($conn, $_POST['sex']);
			$position = mysqli_real_escape_string($conn, $_POST['position']);

			$query = "INSERT INTO users (username, sex, position) VALUES ('$username', '$sex', '$position')";
			$result = mysqli_query($conn, $query);

			if (!$result) {
				echo "<script>alert('Erorr create user!')</script>";
			} else {
				echo "<script>alert('Create user successfully!')</script>";
				header('Location: database.php');
			}
		}
	?>






	<div class="w-100 d-flex justify-content-center mt-5">
		<form action="database.php" method="POST" class="w-50">
			<div class="form-group mb-3">
				<label>Username:</label>
				<input type="text" name="usename" class="form-control">
			</div>
			<div class="form-group mb-3">
				<label>Sex:</label>
				<select class="form-select" name="sex">
				  <option value="Male">Male</option>
				  <option value="Female">Female</option>
				  <option value="Other">Other</option>
				</select>
			</div>
			<div class="form-group mb-3">
				<label>Position:</label>
				<input type="text" name="position" class="form-control">
			</div>
			<input type="submit" name="create_user" class="btn btn-primary" value="Create User">
		</form>
	</div>

</body>
</html>