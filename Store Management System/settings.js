document.addEventListener('DOMContentLoaded', () => {
  checkAuth();
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


  // Show admin settings if user is admin
  if (currentUser.role === 'admin') {
    document.getElementById('admin-settings').style.display = 'block';
  }

  // Language switching
  document.getElementById('language-select').addEventListener('change', (e) => {
    updateLanguage(e.target.value); // From script.js
  });

  // Update credentials (admin only)
  document.getElementById('update-credentials-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const newPassword = document.getElementById('new-password').value;
    // Placeholder for password update logic
    alert('Password updated');
  });
});