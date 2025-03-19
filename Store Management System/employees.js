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


  // Example employee data
  const employees = [
    { id: 1, name: "Employee 1", role: "Cashier" }
  ];

  // Render employees
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
});

