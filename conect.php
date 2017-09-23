<?php
define ("SERVEUR", "localhost");
define ("USER", "hysterias");
define ("PASS", "azerty");
define ("BDD", "blog");

/*
$conn = new mysqli(SERVEUR, USER, PASS, BDD);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//CREATE
$sql = "INSERT INTO article  VALUES (NULL,'titre1', 'blabla1', 'Jeremy')";
//UPDATE
$sql = "UPDATE article  SET titre:'' WHERE ";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();*/