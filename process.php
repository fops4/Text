<?php
include 'db.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Enregistrement supprimé avec succès";
    } else {
        echo "Erreur de suppression: " . $conn->error;
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <h2>Modifier l'utilisateur</h2>
        <form action="process.php?action=update&id=<?php echo $id; ?>" method="post">
            <label for="first_name">Prénom:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $row['first_name']; ?>" required><br>
            
            <label for="last_name">Nom:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $row['last_name']; ?>" required><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required><br>
            
            <label for="birth_date">Date de naissance:</label>
            <input type="date" id="birth_date" name="birth_date" value="<?php echo $row['birth_date']; ?>" required><br>
            
            <label for="birth_place">Lieu de naissance:</label>
            <input type="text" id="birth_place" name="birth_place" value="<?php echo $row['birth_place']; ?>" required><br>
            
            <label for="phone_number">Numéro de téléphone:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $row['phone_number']; ?>" required><br>
            
            <input type="submit" value="Mettre à jour">
        </form>
        <?php
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $birth_date = $_POST['birth_date'];
    $birth_place = $_POST['birth_place'];
    $phone_number = $_POST['phone_number'];

    $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', birth_date='$birth_date', birth_place='$birth_place', phone_number='$phone_number' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Enregistrement mis à jour avec succès";
    } else {
        echo "Erreur de mise à jour: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Liste des utilisateurs</title>
</head>
<body>
    <h2>Liste des utilisateurs</h2>
    <?php
    // Affichage de la table des utilisateurs
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
        <tr>
        <th>ID</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Date de naissance</th>
        <th>Lieu de naissance</th>
        <th>Numéro de téléphone</th>
        <th>Actions</th>
        </tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>".$row['id']."</td>
            <td>".$row['first_name']."</td>
            <td>".$row['last_name']."</td>
            <td>".$row['email']."</td>
            <td>".$row['birth_date']."</td>
            <td>".$row['birth_place']."</td>
            <td>".$row['phone_number']."</td>
            <td>
            <a href='process.php?action=edit&id=".$row['id']."'>Modifier</a> |
            <a href='process.php?action=delete&id=".$row['id']."'>Supprimer</a>
            </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "Aucun enregistrement trouvé";
    }

    $conn->close();
    ?>
</body>
</html>

