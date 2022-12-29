<?php
$conn = mysqli_connect("localhost", "phpmyadmin", "admin", "reviews");
if (!$conn) {
    die("Database connection failed");
}
echo "<h1>Reviews</h1>";

if (!isset($_COOKIE['block'])) {
    if (
        !isset($_POST['title']) ||
        !isset($_POST['content']) ||
        !isset($_POST['room']) ||
        !isset($_POST['recommend'])
    ) {
        echo "Not all required parameters were set.";
    } else {
        //TODO: add html5 elements
        echo "<section>";
        echo "<p>Thank you for your review with the title '<i>" . $_POST['title'] . "'</i>.</p>";
        echo "<p>During your stay with us you stayed in a " . $_POST['room'] . " . We hope you loved it.</p<";
        echo "<p>You told us the following about your stay: <br/><br/> <i>" . $_POST['content'] . "</i></p>";

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
        $creation_date = date('d-m-Y');
        $recommend_bit = $_POST['recommend'] == "yes" ? 1 : 0;
        mysqli_stmt_bind_param($stmt, 'sssis', $_POST['title'], $_POST['content'], $_POST['room'], $recommend_bit, $creation_date);
        $res = mysqli_stmt_execute($stmt);

        // create cookies to block
        $cookie_name = "block";
        $cookie_value = $_POST['title'];
        setcookie($cookie_name, $cookie_value, time() + (300), "/"); // 300 = 5min

    }

} else {
    echo "<p>You submitted a review in the last 5 minutes, please wait some more time.</p>";
}
echo "<p>To get back to the homepage, click <a href='./index.html'>here</a></p>";

echo "<h2>Have a look at other people's reviews!</h2>";
$stmt = mysqli_prepare($conn, "SELECT title, content, room, recommend, creation_date FROM reviews WHERE creation_date > ?");
// TODO this does not work with the date
$date_two_moths_ago = date('d-m-Y', strtotime('-2 months'));
mysqli_stmt_bind_param($stmt, "s", $date_two_moths_ago);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$recommend_arr = ["no", "yes"];
if ($result) {
    echo "<section>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>Stayed in a <b>" . ucfirst($row['room']) . "</b>.</p>";
        echo "<p>Created on " . $row['creation_date'] . ".</p>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<p><i> Would you recommend Hotel Green? " . ucfirst($recommend_arr[$row['recommend']]) . "</i>.</p>";
        echo "<hr/>";
    }
    echo "</section>";
}
mysqli_close($conn);

?>