 // AJAX registration logic
 document.getElementById('signUpForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the form from submitting normally

    const formData = new FormData(this); // Gather form data
    const notificationDiv = document.getElementById('notification'); // Select notification div

    // Send the form data to register.php using Fetch API
    fetch('register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Get the response as text
    .then(data => {
        notificationDiv.innerHTML = data; // Display the response message
        this.reset(); // Reset the form after submission
    })
    .catch(error => {
        notificationDiv.innerHTML = "An error occurred. Please try again."; // Handle any errors
        console.error('Error:', error);
    });
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