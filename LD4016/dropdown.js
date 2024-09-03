document.addEventListener('click', function(event) {
    const accountDropdown = document.querySelector('.account-dropdown');
    const accountLink = document.querySelector('.my-account > a');

    if (!accountDropdown.contains(event.target) && !accountLink.contains(event.target)) {
        accountDropdown.style.display = 'none';
    } else {
        accountDropdown.style.display = 'block';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const authModal = document.getElementById('authModal');
    const signInBtn = document.querySelector('.sign-in-btn');
    const closeAuthModal = document.querySelector('.close-auth-modal');

    signInBtn.addEventListener('click', function (e) {
        e.preventDefault();
        authModal.style.display = 'block';
    });

    closeAuthModal.addEventListener('click', function () {
        authModal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target == authModal) {
            authModal.style.display = 'none';
        }
    });
});

