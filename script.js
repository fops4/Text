document.getElementById('registrationForm').addEventListener('submit', function(event) {
    var phoneNumber = document.getElementById('phone_number').value;
    if (!/^\d+$/.test(phoneNumber)) {
        alert('Veuillez entrer un numéro de téléphone valide.');
        event.preventDefault();
    }
});
