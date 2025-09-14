<?php
// new_form.php

// Create a new folder for the new form page
$new_form_folder = 'posts/' . uniqid();
mkdir($new_form_folder, 0777, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Save the form data to a new file in the posts folder
    $new_file = $new_form_folder . '/' . uniqid() . '.html';
    $html_content = '<!DOCTYPE html>
<html>
<head>
    <title>' . $title . '</title>
</head>
<body>
    <h1>' . $title . '</h1>
    <p>' . $description . '</p>
</body>
</html>';
    file_put_contents($new_file, $html_content);

    // Redirect to the new form page
    header('Location: ' . $new_file);
    exit;
}