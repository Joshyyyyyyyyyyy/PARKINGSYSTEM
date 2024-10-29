const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggleBtn');

// Toggle the sidebar open and closed
toggleBtn.addEventListener('click', function() {
    sidebar.classList.toggle('close');
});

// Select all the navigation links
const navLinks = document.querySelectorAll('.menu a');

// Add click event listener to each link
navLinks.forEach(link => {
    link.addEventListener('click', function() {
        // Remove the 'active' class from all links
        navLinks.forEach(item => item.classList.remove('active'));
        // Add the 'active' class to the clicked link
        this.classList.add('active');
    });
});
