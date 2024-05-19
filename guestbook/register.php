<?php
// TODO 1: PREPARING ENVIRONMENT: 1) session 2) functions
session_start();

$aConfig = require_once 'config.php';
$db = mysqli_connect ($aConfig['host'],
    $aConfig ['user'],
    $aConfig ['pass'],
    $aConfig ['name']
);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// TODO 2: ROUTING
if (!empty($_SESSION['auth'])) {
    header('Location: /admin.php');
    die;
}

// TODO 3: CODE by REQUEST METHODS (ACTIONS) GET, POST, etc. (handle data from request): 1) validate 2) working with data source 3) transforming data

// 1. Create empty $infoMessage
$infoMessage = '';

// 2. handle form data
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $db->real_escape_string($_POST['email']);
    $password = $db->real_escape_string($_POST['password']);

    // 3. Check that user has already existed
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $infoMessage = "Такой пользователь уже существует! Перейдите на страницу входа. ";
        $infoMessage .= "<a href='/login.php'>Страница входа</a>";
    } else {
        // 4. Create new user
        $stmt = $db->prepare("INSERT INTO users (email, password, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();

        header('Location: /login.php');
        die;
    }

    $stmt->close();

} elseif (!empty($_POST)) {
    $infoMessage = 'Заполните форму регистрации!';
}

// TODO 4: RENDER: 1) view (html) 2) data (from php)

$db->close();
?>

<!DOCTYPE html>
<html>

<?php require_once 'sectionHead.php' ?>

<body>

<div class="container">

    <?php require_once 'sectionNavbar.php' ?>

    <br>

    <div class="card card-primary">
        <div class="card-header bg-success text-light">
            Register form
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" type="email" name="email" required/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" required/>
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="formRegister"/>
                </div>
            </form>

            <!-- TODO: render php data -->
            <?php
            if ($infoMessage) {
                echo '<hr/>';
                echo "<span style='color:red'>$infoMessage</span>";
            }
            ?>

        </div>

    </div>
</div>

</body>
</html>
