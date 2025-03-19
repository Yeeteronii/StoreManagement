document.addEventListener('DOMContentLoaded', () => {
  // Get the current user from localStorage
  const currentUser = JSON.parse(localStorage.getItem('currentUser'));
  
  // If no user is logged in, redirect to login page
  if (!currentUser) {
      window.location.href = 'login.html';
      return;
  }
  
  // Display user info
  document.getElementById('user-info').textContent = `Logged in as: ${currentUser.username} (${currentUser.role})`;
  
  // Define sidebar links based on role
  const sidebar = document.getElementById('sidebar');
  const links = currentUser.role === 'admin' ? [
      { href: 'products.html', text: 'Products' },
      { href: 'schedule.html', text: 'Schedule' },
      { href: 'orders.html', text: 'Orders' },
      { href: 'suppliers.html', text: 'Suppliers' },
      { href: 'employees.html', text: 'Employees' }
  ] : [
      { href: 'products.html', text: 'Products' },
      { href: 'schedule.html', text: 'Schedule' }
  ];
  
  // Add links to the sidebar
  links.forEach(link => {
      const a = document.createElement('a');
      a.href = link.href;
      a.textContent = link.text;
      sidebar.appendChild(a);
  });
  
  // Show admin-specific content
  if (currentUser.role === 'admin') {
      document.getElementById('admin-section').style.display = 'block';
  } else {
      document.getElementById('admin-section').style.display = 'none';
  }
  
  // Handle logout
  document.getElementById('logout').addEventListener('click', () => {
      localStorage.removeItem('currentUser');
      window.location.href = 'login.html';
  });
});