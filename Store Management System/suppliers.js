document.addEventListener('DOMContentLoaded', () => {
  checkAuth();
  if (currentUser.role !== 'admin') {
    window.location.href = 'mainpage.html';
  }
  initLanguage();

  document.getElementById('user-info').textContent = `Logged in as: ${currentUser.username} (${currentUser.role})`;
  document.getElementById('logout').addEventListener('click', logout);

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

  ];
  links.forEach(link => {
    const a = document.createElement('a');
    a.href = link.href;
    a.textContent = translations[currentLanguage][link.text]; // From script.js
    sidebar.appendChild(a);
  });


  // Example supplier data
  const suppliers = [
    { id: 1, name: "Dairy Supplier", contact: "dairy@example.com" }
  ];

  // Render suppliers
  const tbody = document.getElementById('supplier-table').querySelector('tbody');
  suppliers.forEach(s => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${s.name}</td>
      <td>${s.contact}</td>
      <td>
        <button onclick="updateSupplier(${s.id})">Update</button>
        <button onclick="deleteSupplier(${s.id})">Delete</button>
      </td>
    `;
    tbody.appendChild(tr);
  });
});