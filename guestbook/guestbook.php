<?php
session_start();

function file_write($arr, $filename) {
    $jsonString = json_encode($arr);
    $fileStream = fopen ($filename , 'a');
    fwrite ( $fileStream, $jsonString ."\n");
    fclose ($fileStream );
}

function text_to_html($text) {
    return htmlspecialchars(stripslashes(trim($text)));
}

function comment_read($file) {
    $comments = [];
    if( file_exists ($file)) {
        $fileStream = fopen ( $file , "r");

        while (! feof ($fileStream )) {
            $jsonString = fgets ($fileStream);
            $array = json_decode ( $jsonString , true);
            if ( empty ($array)) break ;
            $comments[$array['name']] = $array['text'];
        }
        fclose ($fileStream );
    }
    return $comments;
}

$guestbook = "guestbook.csv";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $name = $text = "";

    if (!empty($_POST["email"]) && !empty($_POST["name"]) && !empty($_POST["text"])) {
        $email = text_to_html($_POST["email"]);
        $name = text_to_html($_POST["name"]);
        $text = text_to_html($_POST["text"]);
        $record = ['name' => $name, 'email' => $email, 'text' => $text];
        file_write($record, $guestbook);
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
                    $data = comment_read($guestbook);
                    foreach ($data as $name => $comment) {
                        echo "<p><span style=\"color:blue\">$name</span> залишив відгук:"."<br>".$comment."</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>

</body>
</html>