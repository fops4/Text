<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Formulaire d'enregistrement</title>
</head>
<body>
    <h2>Formulaire d'enregistrement</h2>
    <form action="process1.php" method="post" id="registrationForm">
        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name" required><br>
        
        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="birth_date">Date de naissance:</label>
        <input type="date" id="birth_date" name="birth_date" required><br>
        
        <label for="birth_place">Lieu de naissance:</label>
        <input type="text" id="birth_place" name="birth_place" required><br>
        
        <label for="phone_number">Numéro de téléphone:</label>
        <input type="text" id="phone_number" name="phone_number" required><br>
        
        <input type="submit" value="Enregistrer">
    </form>

    <script src="script.js"></script>
</body>
</html>
