document.addEventListener('DOMContentLoaded', () => {
  checkAuth(); // From script.js
  initLanguage(); // From script.js

  document.getElementById('user-info').textContent = `Logged in as: ${currentUser.username} (${currentUser.role})`;
  document.getElementById('logout').addEventListener('click', logout); // From script.js

  // Render sidebar
  const sidebar = document.getElementById('sidebar');
  const links = currentUser.role === 'admin' ? [
    { href: 'mainpage.html', text: 'welcome_title' },
    { href: 'products.html', text: 'products_title' },
    { href: 'schedule.html', text: 'schedule_title' },
    { href: 'orders.html', text: 'orders_title' },
    { href: 'suppliers.html', text: 'suppliers_title' },
    { href: 'employees.html', text: 'employees_title' },
    { href: 'reports.html', text: 'reports_title' },
    { href: 'settings.html', text: 'settings_title' }
  ] : [
    { href: 'mainpage.html', text: 'welcome_title' },
    { href: 'products.html', text: 'products_title' },
    { href: 'schedule.html', text: 'schedule_title' },
    { href: 'settings.html', text: 'settings_title' }
  ];
  links.forEach(link => {
    const a = document.createElement('a');
    a.href = link.href;
    a.textContent = translations[currentLanguage][link.text]; // From script.js
    sidebar.appendChild(a);
  });

  // Example product data
  const products = [
    { id: 1, name: "Milk", category: "Dairy", quantity: 10 },
    { id: 2, name: "Chips", category: "Snacks", quantity: 3 }
  ];

  // Render products
  const tbody = document.getElementById('product-table').querySelector('tbody');
  products.forEach(p => {
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

  // Show/hide add button based on role
  document.getElementById('add-product-btn').style.display = currentUser.role === 'admin' ? 'block' : 'none';
});