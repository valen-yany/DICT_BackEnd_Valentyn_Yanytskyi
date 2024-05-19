<?php
session_start();

function text_to_html($text) {
    return htmlspecialchars(stripslashes(trim($text)));
}
function db_write($aComment, $db){
    $query = "INSERT INTO comments(email, name, text, created_at) VALUES(
'".$aComment ['email']."',
'".$aComment ['name']."',
'".$aComment ['text']."',
'\"NOW()\"'
)";
    mysqli_query($db , $query);
    mysqli_close($db);
}

function comment_read($db) {
    $comments = [];
    $result = mysqli_query($db,"SELECT name, text FROM comments ORDER BY created_at DESC");
    $id = 0;
    while ($row = $result->fetch_assoc()) {
        $comments[$row['name']] = $row['text'];
    }
    mysqli_close ($db);
    return $comments;
}

$aConfig = require_once 'config.php';
$db = mysqli_connect ($aConfig['host'],
    $aConfig ['user'],
    $aConfig ['pass'],
    $aConfig ['name']
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $name = $text = "";

    if (!empty($_POST["email"]) && !empty($_POST["name"]) && !empty($_POST["text"])) {
        $email = text_to_html($_POST["email"]);
        $name = text_to_html($_POST["name"]);
        $text = text_to_html($_POST["text"]);
        $record = ['name' => $name, 'email' => $email, 'text' => $text];
        db_write($record, $db);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    else {
        echo "<p style='font-size: 32px;color: red'>Заповніть всі поля!</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="">

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">
    <?php require_once 'sectionNavbar.php' ?>
    <br>
    <div class="card card-primary">
        <div class="card-header bg-primary text-light">
            GuestBook form
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-6">
                    <form action="" method="POST">
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email"><br>
                        <label for="name">Name:</label><br>
                        <input type="text" id="name" name="name"><br>
                        <label for="text">Text:</label><br>
                        <textarea id="text" name="text"></textarea><br>
                        <input type="submit" value="Відправити">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card card-primary">
        <div class="card-header bg-body-secondary text-dark">
            Сomments
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    $data = comment_read($db);
                    foreach ($data as $name => $comment) {
                        echo "<p><span style=\"color:blue\">$name</span> залишив відгук:" . "<br>" . $comment . "</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>