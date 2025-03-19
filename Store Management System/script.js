// Data Storage
let currentUser = null;
const users = [
  { username: "admin", password: "admin123", role: "admin" },
  { username: "employee1", password: "emp123", role: "employee" }
];

// Translations
const translations = {
  en: {
    login_title: "Login", username_label: "Username:", password_label: "Password:", login_button: "Login",
    app_title: "Store Management System", logout_button: "Logout",
    welcome_title: "Welcome", welcome_message: "Select a page from the sidebar.",
    products_title: "Products", schedule_title: "Schedule", reports_title: "Reports",
    orders_title: "Orders", suppliers_title: "Suppliers", employees_title: "Employees",
    settings_title: "Settings"
  },
  fr: {
    login_title: "Connexion", username_label: "Nom d'utilisateur :", password_label: "Mot de passe :", login_button: "Connexion",
    app_title: "Système de Gestion de Magasin", logout_button: "Déconnexion",
    welcome_title: "Bienvenue", welcome_message: "Sélectionnez une page dans la barre latérale.",
    products_title: "Produits", schedule_title: "Horaire", reports_title: "Rapports",
    orders_title: "Commandes", suppliers_title: "Fournisseurs", employees_title: "Employés",
    settings_title: "Paramètres"
  }
};

let currentLanguage = "en";

// Authentication
function login(username, password) {
  const user = users.find(u => u.username === username && u.password === password);
  if (user) {
    currentUser = user;
    localStorage.setItem('currentUser', JSON.stringify(user));
    window.location.href = 'mainpage.html';
  } else {
    alert('Invalid credentials');
  }
}

function logout() {
  currentUser = null;
  localStorage.removeItem('currentUser');
  window.location.href = 'login.html';
}

// Language Switching
function updateLanguage(lang) {
  currentLanguage = lang;
  localStorage.setItem('language', lang);
  document.querySelectorAll('[data-translate]').forEach(el => {
    const key = el.getAttribute('data-translate');
    el.textContent = translations[lang][key];
  });
}

// Check if user is logged in
function checkAuth() {
  const user = JSON.parse(localStorage.getItem('currentUser'));
  if (!user) {
    window.location.href = 'login.html';
  } else {
    currentUser = user;
  }
}

// Initialize language
function initLanguage() {
  const lang = localStorage.getItem('language') || 'en';
  updateLanguage(lang);
}