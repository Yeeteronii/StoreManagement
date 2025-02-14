// Add event listener to the login form for form submission
document.getElementById("loginForm").addEventListener("input", function() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const adminButton = document.getElementById("admin-button");
    
    // Show admin button if correct admin credentials are entered
    if (username === "admin" && password === "12345") {
        adminButton.style.display = "block";
    } else {
        adminButton.style.display = "none";
    }
});

// Redirect to the appropriate page based on credentials
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const errorMessage = document.getElementById("error-message");
    
    if (username === "admin" && password === "12345") {
        window.location.href = "adminMainPage.html";
    } else if (username === "employee" && password === "67890") {
        window.location.href = "employeeMainPage.html";
    } else {
        errorMessage.textContent = "Invalid username or password!";
    }
});

// Function to update current date and time dynamically
function updateDateTime() {
    const dateTimeElement = document.getElementById("current-datetime");
    const now = new Date();
    dateTimeElement.textContent = now.toLocaleString();
}

// Update the date and time every second
setInterval(updateDateTime, 1000);
updateDateTime();
