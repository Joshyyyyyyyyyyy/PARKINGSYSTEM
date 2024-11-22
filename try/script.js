 // AJAX registration logic
 document.getElementById('signUpForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the form from submitting normally

    const formData = new FormData(this); // Gather form data
    const notificationDiv = document.getElementById('notification');
});

// Handle sign in and sign up button clicks
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
    container.classList.add('right-panel-active');
});

signInButton.addEventListener('click', () => {
    container.classList.remove('right-panel-active');
});