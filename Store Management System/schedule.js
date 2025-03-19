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


  // Example schedule data
  const schedules = [
    { id: 1, day: "Monday", employee: "Employee 1", start: "9:00", end: "17:00" }
  ];

  // Render schedule
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

  // Show/hide add button based on role
  document.getElementById('add-schedule-btn').style.display = currentUser.role === 'admin' ? 'block' : 'none';
});