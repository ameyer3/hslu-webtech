<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="icon" type="image/x-icon" href="/img/hotel.jpg">
    <title>Hotel Green - Reviews</title>
</head>

<body class="w3-sand">
    <?php
    // TODO: check style everywhere and remove if not needed the classes from sections etc
    $conn = mysqli_connect("localhost", "phpmyadmin", "admin", "reviews");
    if (!$conn) {
        die("Database connection failed");
    }
    echo "<header class='w3-container w3-light-green w3-center'><h1>Reviews</1></header>";
    echo "<main class='w3-container w3-center'>";
    if (!isset($_COOKIE['block'])) {
        if (
            !isset($_POST['title']) ||
            !isset($_POST['content']) ||
            !isset($_POST['room']) ||
            !isset($_POST['recommend'])
        ) {
            echo "<p class='w3-container w3-center'>Not all required parameters were set.</p>";
        } elseif (
            strlen($_POST['title']) > 100 ||
            strlen($_POST['content']) > 500
        ) {
            echo "<p class='w3-container w3-center'>Not all required parameters were set correctly. Make sure your title is not longer than 100 charcters and the review itself should not be longer than 500 characters.</p>";
        } else {
            echo "<section>";
            echo "<p>Thank you for your review with the title '<i>" . $_POST['title'] . "'</i>.</p>";
            echo "<p>During your stay with us you stayed in a " . $_POST['room'] . " . We hope you loved it.</p<";
            echo "<p>You told us the following about your stay: <p> <i>\"" . $_POST['content'] . "\"</i></p></p>";

            echo "<p>When we asked you whether you would recommend us or not you said " . $_POST['recommend'] . ".<p>";
            if ($_POST['recommend'] == 'yes') {
                echo "<p>Thank you for your stay and you possible recommendation to friends and family.</p>";
            } else {
                echo "<p>We are sorry to hear about that. We will consider your review and try to make the experience at Hotel Green better.</p>";
            }

            echo "<p>We will add your review to our database and try to learn and improve from it. Please wait 5 minutes before writing another review.";
            echo "</section>";

            $query = "INSERT INTO reviews (title, content, room, recommend, creation_date) values ( ? , ? , ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            $creation_date = date('Y-m-d');
            $recommend_bit = $_POST['recommend'] == "yes" ? 1 : 0;
            mysqli_stmt_bind_param($stmt, 'sssis', $_POST['title'], $_POST['content'], $_POST['room'], $recommend_bit, $creation_date);
            $res = mysqli_stmt_execute($stmt);

            // create cookies to block
            $cookie_name = "block";
            $cookie_value = $_POST['title'];
            setcookie($cookie_name, $cookie_value, time() + (300), "/"); // 300 = 5min
    
        }

    } else {
        echo "<p class='w3-container w3-center'>You submitted a review in the last 5 minutes, please wait some more time.</p>";
    }
    echo "<p class='w3-container w3-center'> To get back to the homepage, click <a href='./index.html'>here</a></p>";

    echo "<section>";
    echo "<h1>Have a look at other people's reviews!</h1>";
    $stmt = mysqli_prepare($conn, "SELECT title, content, room, recommend, creation_date FROM reviews WHERE creation_date > ?");
    $date_two_moths_ago = date('Y-m-d', strtotime("-2 month"));
    mysqli_stmt_bind_param($stmt, "s", $date_two_moths_ago);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $recommend_arr = ["no", "yes"];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<h2>" . $row['title'] . "</h2>";
            echo "<p>Stayed in a <b>" . ucfirst($row['room']) . "</b>.</p>";
            echo "<p>\"" . $row['content'] . "\"</p>";
            echo "<p><i> Would you recommend Hotel Green? " . ucfirst($recommend_arr[$row['recommend']]) . "</i>.</p>";
            echo "<p><i>Created on " . $row['creation_date'] . "</i>.</p>";
            echo "<hr/>";
        }
        echo "</section>";
    }
    echo "</main>";
    mysqli_close($conn);

    ?>
</body>

</html>