<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $birth_date = $_POST['birth_date'];
    $birth_place = $_POST['birth_place'];
    $phone_number = $_POST['phone_number'];

    $sql = "INSERT INTO users (first_name, last_name, email, birth_date, birth_place, phone_number)
            VALUES ('$first_name', '$last_name', '$email', '$birth_date', '$birth_place', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouveau enregistrement créé avec succès";
        header('location:process.php');
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}


