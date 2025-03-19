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


  // Example report data
  const reports = [
    { id: 1, date: "2025-01-01", earnings: 500, notes: "Good day" }
  ];

  // Render reports
  const tbody = document.getElementById('report-table').querySelector('tbody');
  reports.forEach(r => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${r.date}</td>
      <td>${r.earnings}</td>
      <td>${r.notes}</td>
    `;
    tbody.appendChild(tr);
  });
});