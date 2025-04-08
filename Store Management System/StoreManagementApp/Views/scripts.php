<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>



<?php

// -------------------------------
// General Utility Functions
// -------------------------------

/*

// Data Storage
let currentUser = null;
const users = [
  { 'username': 'admin', password: "admin123", role: "admin" },
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

// Render Sidebar
function renderSidebar() {
  const sidebar = document.getElementById('sidebar');
  const links = currentUser.role === 'admin' ? [
    { href: 'mainpage.html', text: 'welcome_title' },
    { href: 'Product.html', text: 'products_title' },
    { href: 'schedule.html', text: 'schedule_title' },
    { href: 'orders.html', text: 'orders_title' },
    { href: 'suppliers.html', text: 'suppliers_title' },
    { href: 'employees.html', text: 'employees_title' },
    { href: 'reports.html', text: 'reports_title' },
    { href: 'settings.html', text: 'settings_title' }
  ] : [
    { href: 'mainpage.html', text: 'welcome_title' },
    { href: 'Product.html', text: 'products_title' },
    { href: 'schedule.html', text: 'schedule_title' },
    { href: 'settings.html', text: 'settings_title' }
  ];

  links.forEach(link => {
    const a = document.createElement('a');
    a.href = link.href;
    a.textContent = translations[currentLanguage][link.text];
    sidebar.appendChild(a);
  });
}

// -------------------------------
// Page-specific Functionality
// -------------------------------

document.addEventListener('DOMContentLoaded', () => {
  checkAuth();
  initLanguage();

  // Set user info and logout functionality
  const userInfo = document.getElementById('user-info');
  const logoutButton = document.getElementById('logout');

  if (userInfo) userInfo.textContent = `Logged in as: ${currentUser.username} (${currentUser.role})`;
  if (logoutButton) logoutButton.addEventListener('click', logout);

  renderSidebar();

  // Handle page-specific functionality
  const page = document.body.dataset.page;

  if (page === 'Product') {
    // Populate product table
    const Product = [
      { id: 1, name: "Milk", category: "Dairy", quantity: 10 },
      { id: 2, name: "Chips", category: "Snacks", quantity: 3 }
    ];
    const tbody = document.getElementById('product-table').querySelector('tbody');
    Product.forEach(p => {
      const tr = document.createElement('tr');
      tr.className = p.quantity < 5 ? 'low-stock' : '';
      tr.innerHTML = `
        <td>${p.name}</td>
        <td>${p.category}</td>
        <td>${p.quantity}</td>
        <td>
          ${currentUser.role === 'admin' ? `
            <button onclick="updateProduct(${p.id})">Update</button>
            <button onclick="deleteProduct(${p.id})">Delete</button>
          ` : `
            <button onclick="updateQuantity(${p.id})">Update Quantity</button>
          `}
          <button onclick="addToOrder(${p.id})">Add to Order</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
    document.getElementById('add-product-btn').style.display = currentUser.role === 'admin' ? 'block' : 'none';
  }

  if (page === 'schedule') {
    // Render schedule data
    const schedules = [
      { id: 1, day: "Monday", employee: "User 1", start: "9:00", end: "17:00" }
    ];
    const grid = document.getElementById('schedule-grid');
    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    days.forEach(day => {
      const div = document.createElement('div');
      div.className = 'day';
      div.innerHTML = `<h3>${day}</h3>`;
      const ul = document.createElement('ul');
      schedules.filter(s => s.day === day).forEach(s => {
        const li = document.createElement('li');
        li.textContent = `${s.employee}: ${s.start} - ${s.end}`;
        if (currentUser.role === 'admin') {
          const btn = document.createElement('button');
          btn.textContent = 'Update';
          btn.onclick = () => updateSchedule(s.id);
          li.appendChild(btn);
        }
        ul.appendChild(li);
      });
      div.appendChild(ul);
      grid.appendChild(div);
    });
    document.getElementById('add-schedule-btn').style.display = currentUser.role === 'admin' ? 'block' : 'none';
  }

  if (page === 'employees' && currentUser.role === 'admin') {
    // Populate employees table (admin only)
    const employees = [
      { id: 1, name: "User 1", role: "Cashier" }
    ];
    const tbody = document.getElementById('employee-table').querySelector('tbody');
    employees.forEach(e => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${e.name}</td>
        <td>${e.role}</td>
        <td>
          <button onclick="updateEmployee(${e.id})">Update</button>
          <button onclick="deleteEmployee(${e.id})">Delete</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  // Additional page-specific logic for 'reports', 'settings', etc., can be added similarly
});



*/