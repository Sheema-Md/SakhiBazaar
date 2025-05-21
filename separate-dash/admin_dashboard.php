<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sakhi Bazaar Admin Dashboard</title>
  <link rel="stylesheet" href="sell_dash_style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Additional styles specific to Admin Dashboard */
    .admin-main {
      display: grid;
      grid-template-columns: 250px 1fr;
      height: 100vh;
    }

    .sidebar {
      background-color: #fff;
      border-right: 1px solid #ccc;
      padding: 1rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .sidebar a {
      color: #333;
      text-decoration: none;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .topbar {
      background-color: #fff;
      padding: 1rem;
      border-bottom: 1px solid #ccc;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .dashboard-content {
      padding: 1rem;
      overflow-y: auto;
    }

    .summary-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 1rem;
    }

    .card {
      background: #f8f9fa;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .charts {
      margin-top: 2rem;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
    }

    .table-section {
      margin-top: 2rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th, table td {
      border: 1px solid #ccc;
      padding: 0.5rem;
      text-align: left;
    }

    .actions button {
      margin-right: 5px;
      padding: 0.3rem 0.6rem;
      font-size: 0.85rem;
    }

    .quick-actions {
      margin-top: 2rem;
      display: flex;
      gap: 1rem;
    }
  </style>
</head>
<body>
  <div class="admin-main">
    <!-- Sidebar -->
    <aside class="sidebar">
      <a href="#"><i class="fas fa-home"></i> Dashboard</a>
      <a href="#"><i class="fas fa-users"></i> Sellers Management</a>
      <a href="#"><i class="fas fa-user"></i> Buyers Management</a>
      <a href="#"><i class="fas fa-box"></i> Products Management</a>
      <a href="#"><i class="fas fa-clipboard-list"></i> Orders Overview</a>
      <a href="#"><i class="fas fa-chart-line"></i> Reports & Analytics</a>
      <a href="#"><i class="fas fa-th"></i> Category Management</a>
      <a href="#"><i class="fas fa-money-bill-wave"></i> Payments & Transactions</a>
      <a href="#"><i class="fas fa-ticket-alt"></i> Support Tickets</a>
      <a href="#"><i class="fas fa-cog"></i> Admin Profile / Settings</a>
      <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </aside>

    <!-- Main Content -->
    <main>
      <div class="topbar">
        <input type="text" placeholder="Search users, orders, products..." />
        <div>
          <i class="fas fa-bell"></i>
          <select>
            <option>EN</option>
            <option>HI</option>
          </select>
          <i class="fas fa-user-circle"></i>
        </div>
      </div>

      <div class="dashboard-content">
        <!-- Summary Cards -->
        <div class="summary-cards">
          <div class="card">Total Sellers: 1,240</div>
          <div class="card">Total Buyers: 8,310</div>
          <div class="card">Active Products: 5,980</div>
          <div class="card">Orders Today: 320</div>
          <div class="card">Pending Verifications: 18</div>
          <div class="card">Revenue This Month: ₹12.5L</div>
        </div>

        <!-- Charts Section -->
        <div class="charts">
          <div class="card">[Line Chart - Daily Orders]</div>
          <div class="card">[Bar Chart - Monthly Revenue]</div>
          <div class="card">[Pie Chart - Order Status]</div>
          <div class="card">[Pie Chart - Seller Approval Status]</div>
        </div>

        <!-- Tables Section -->
        <div class="table-section">
          <h3>Recent Orders</h3>
          <table>
            <tr><th>Order ID</th><th>Buyer</th><th>Seller</th><th>Amount</th><th>Date</th><th>Status</th></tr>
            <tr><td>#1023</td><td>Rita</td><td>Meena Crafts</td><td>₹1,250</td><td>20-May</td><td>Delivered</td></tr>
          </table>

          <h3>Pending Seller Approvals</h3>
          <table>
            <tr><th>Seller Name</th><th>Email</th><th>Registered</th><th>Action</th></tr>
            <tr><td>Savita Textiles</td><td>savita@mail.com</td><td>18-May</td><td class="actions"><button>Approve</button><button>Reject</button></td></tr>
          </table>

          <h3>Support Tickets</h3>
          <table>
            <tr><th>Ticket ID</th><th>Subject</th><th>From</th><th>Status</th><th>Date</th></tr>
            <tr><td>#548</td><td>Order not received</td><td>Buyer: Anita</td><td>Open</td><td>19-May</td></tr>
          </table>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
          <button>Add New Category</button>
          <button>Block User</button>
          <button>Generate Report</button>
          <button>Export CSV</button>
        </div>
      </div>
    </main>
  </div>
</body>
</html> 