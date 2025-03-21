// Sample user data (in practice, this would come from a database)
const users = [
    { username: "admin", password: "12345", role: "admin" },
    { username: "employee", password: "67890", role: "employee" }
];

// Language translations (optional, for multilingual support)
const translations = {
    en: {
        invalid_credentials: "Invalid username or password!"
    },
    // Add other languages as needed
};

// Default language
let currentLanguage = localStorage.getItem('language') || 'en';

// Handle login form submission
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const errorMessage = document.getElementById("error-message");
    
    // Find user in the users array
    const user = users.find(u => u.username === username && u.password === password);
    if (user) {
        // Store user data, including role, in localStorage
        localStorage.setItem('currentUser', JSON.stringify(user));
        window.location.href = "mainpage.html"; // Redirect to main page
    } else {
        errorMessage.textContent = translations[currentLanguage].invalid_credentials;
    }
});

document.getElementById('language-select').addEventListener('change', (e) => {
    updateLanguage(e.target.value); // From script.js
  });