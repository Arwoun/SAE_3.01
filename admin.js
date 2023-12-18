window.onscroll = function() {
    var navbar = document.getElementById('navbar');
    if (window.pageYOffset > 50) {
        navbar.classList.add('opaque');
    } else {
        navbar.classList.remove('opaque');
    }
}

function showModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

function closeModal() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}

function showEditForm(userId, nom, prenom, email, mdp) {
    document.getElementById('edit_user_id').value = userId;
    document.getElementById('edit_nom').value = nom;
    showModal();
}

function closeEditForm() {
    document.getElementById('popupContainer').style.display = 'none';
}
if (typeof showModal === 'function') {
    console.log('showModal is defined.');
} else {
    console.log('showModal is NOT defined.');
}
