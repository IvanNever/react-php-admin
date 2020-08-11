<?php

$_POST = json_decode(file_get_contents("php://input"), true);

$file = $_POST["pageName"];
$newHTML = $_POST["html"];

if(!is_dir("../backup/")) {
    mkdir("../backup/");
}

$backups = json_decode(file_get_contents("../backup/backups.json"));

if(!is_array($backups)) {
   $backups = [];
}


if ($newHTML && $file) {
    $backupFN = uniqid() . ".html";
    copy("../../" . $file, "../backup/" . $backupFN);
    array_push($backups, ["page" => $file, "file" => $backupFN, "time" => date("H:i:s d-m-y")]);
    file_put_contents("../backup/backups.json", json_encode($backups));
    file_put_contents("../../" . $file, $newHTML);
} else {
    header("HTTP/1.0 400 Bad Request");
}