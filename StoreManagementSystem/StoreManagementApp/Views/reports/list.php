<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports - Store Management System</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="reports.css">
</head>
<body>
  <header>
    <h1 data-translate="app_title">Store Management System</h1>
    <div id="user-info"></div>
    <button id="logout" data-translate="logout_button">Logout</button>
  </header>
  <nav id="sidebar"></nav>
  <main>
    <h2 data-translate="reports_title">Reports</h2>
    <button id="add-report-btn" data-translate="add_report">Add Report</button>
    <table id="report-table">
      <thead>
        <tr>
          <th data-translate="date">Date</th>
          <th data-translate="earnings">Earnings</th>
          <th data-translate="notes">Notes</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </main>
  <script src="script.js"></script>
  <script src="../reports.js"></script>
</body>
</html>