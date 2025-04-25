?php

$conn = new mysqli('127.0.0.1', 'root', 'sploitme', 'payroll');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
if (!isset($_POST['s'])) {
?>
<center>
<form action="" method="post">
<h2>Payroll Login</h2>
<table style="border-radius: 25px; border: 2px solid black; padding: 20px;">
    <tr>
        <td>User</td>
        <td><input type="text" name="user"></td>
    </tr>
    <tr>
        <td>Password</td>
        <td><input type="password" name="password"></td>
    </tr>
    <tr>
       <td><input type="submit" value="OK" name="s">
    </tr>
</table>
</form>
</center>
<?php
}
?>

<?php
if($_POST['s']){
    $enable_sanitization = true;
    $user = $_POST['user'];
    $pass = $_POST['password'];

    if ($enable_sanitization) {
        $stmt = mysqli_prepare($conn, "SELECT username, first_name, last_name, salary FROM users WHERE username = ? AND password = ?");
        mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $stmt = "SELECT username, first_name, last_name, salary FROM users WHERE username = '$user' AND password = '$pass'";
        $result = mysqli_query($conn, $stmt);
    }

    // Logging (optional: mask the password in production)
    openlog("payroll_app", LOG_PID | LOG_PERROR, LOG_LOCAL0);
    syslog(LOG_INFO, "Username: $user | Password: $pass");
    closelog();

    // Output
    if ($result && $result->num_rows > 0) {
        echo "<center>";
        echo "<h2>Welcome, " . htmlspecialchars($user) . "</h2><br>";
        echo "<table style='border-radius: 25px; border: 2px solid black;' cellspacing=30>";
        echo "<tr><th>Username</th><th>First Name</th><th>Last Name</th><th>Salary</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }

        echo "</table></center>";
    } else {
        echo "<center><h2>Login failed or no results found.</h2></center>";
    }
}
?>

