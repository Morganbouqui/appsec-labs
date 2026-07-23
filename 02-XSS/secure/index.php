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
    placeholder="Enter your name"
    value="<?= htmlspecialchars($_GET['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <button type="submit">Submit</button>

</form>
<?php

if (isset($_GET['name'])) {

    echo "<h3>Hello " . htmlspecialchars($_GET['name'] ?? '', ENT_QUOTES, 'UTF-8') . "</h3>";

}

?>
</body>
</html>
