<?php

$subject = 'New Email';

echo '----------' . "\n";
echo $subject . "\n";
echo '----------' . "\n";

$firstName = 'Valentyn';
$text1 = "firstName : {$firstName}" . "\n";

$lastName = 'Yanytskyi';
$text2 = "lastName : {$lastName}" . "\n";

$location = 'Kharkiv, Ukraine';
$text3 = "location : {$firstName}" . "\n";

$occupaion = 'student';
$text4 = "firstName : {$occupaion}" . "\n";

$date = '28.04.2003';
$text5 = "date : {$date}" . "\n";
$text6 = "Hello";
$message = $text1 . $text2 . $text3 . $text4 . $text5 . $text6;
echo $message;
$headers = 'From: fama9935@gmail.com@gmail.com';
mail('valiy.yanik@gmail.com', $subject, $message, $headers);