<!DOCTYPE html>
<html>
<head>
    <title>Reflected XSS Lab</title>
</head>
<body>

<h2>Reflected XSS Lab</h2>

<form method="GET">

    <label>Your Name</label><br>

    <input
        type="text"
        name="name"
        placeholder="Enter your name">

    <button type="submit">Submit</button>

</form>
<?php

if (isset($_GET['name'])) {

    echo "<h3>Hello " . $_GET['name'] . "</h3>";

}

?>
</body>
</html>
