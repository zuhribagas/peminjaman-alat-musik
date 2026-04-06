<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Web - Administrasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
            --dark-color: #1d3557;
            --light-color: #f8f9fa;
            --gray-color: #6c757d;
            --sidebar-width: 250px;
            --header-height: 70px;
            --card-border-radius: 12px;
            --transition-speed: 0.3s;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fb;
            color: #333;
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--dark-color);
            color: white;
            position: fixed;
            height: 100vh;
            padding: 20px 0;
            transition: width var(--transition-speed);
            overflow: hidden;
            z-index: 100;
        }
        
        .sidebar.collapsed {
            width: 70px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            padding: 0 20px;
            margin-bottom: 30px;
        }
        
        .logo {
            font-size: 28px;
            margin-right: 15px;
            color: var(--success-color);
        }
        
        .logo-text {
            font-size: 22px;
            font-weight: 700;
            white-space: nowrap;
        }
        
        .sidebar.collapsed .logo-text {
            display: none;
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .menu-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            cursor: pointer;
            white-space: nowrap;
        }
        
        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .menu-item.active {
            background-color: var(--primary-color);
            border-left: 4px solid var(--success-color);
        }
        
        .menu-icon {
            font-size: 20px;
            margin-right: 15px;
            width: 24px;
            text-align: center;
        }
        
        .sidebar.collapsed .menu-text {
            display: none;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed);
        }
        
        .main-content.expanded {
            margin-left: 70px;
        }
        
        /* Header Styles */
        .header {
            height: var(--header-height);
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .header-left {
            display: flex;
            align-items: center;
        }
        
        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--dark-color);
            cursor: pointer;
            margin-right: 20px;
            padding: 5px;
            border-radius: 5px;
            transition: background-color 0.2s;
        }
        
        .toggle-sidebar:hover {
            background-color: #f0f0f0;
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .header-right {
            display: flex;
            align-items: center;
        }
        
        .search-box {
            position: relative;
            margin-right: 20px;
        }
        
        .search-box input {
            padding: 10px 15px 10px 40px;
            border-radius: 30px;
            border: 1px solid #ddd;
            outline: none;
            width: 250px;
            transition: width 0.3s;
        }
        
        .search-box input:focus {
            width: 300px;
            border-color: var(--primary-color);
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .user-name {
            font-weight: 500;
            margin-right: 5px;
        }
        
        /* Content Area */
        .content-area {
            padding: 30px;
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: var(--card-border-radius);
            padding: 25px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .welcome-text h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .welcome-text p {
            opacity: 0.9;
            font-size: 16px;
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: white;
            border-radius: var(--card-border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
            border-top: 4px solid var(--primary-color);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card:nth-child(2) {
            border-top-color: var(--success-color);
        }
        
        .stat-card:nth-child(3) {
            border-top-color: var(--warning-color);
        }
        
        .stat-card:nth-child(4) {
            border-top-color: #7209b7;
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .stat-title {
            font-size: 16px;
            color: var(--gray-color);
            font-weight: 500;
        }
        
        .stat-icon {
            font-size: 24px;
            color: var(--primary-color);
        }
        
        .stat-card:nth-child(2) .stat-icon {
            color: var(--success-color);
        }
        
        .stat-card:nth-child(3) .stat-icon {
            color: var(--warning-color);
        }
        
        .stat-card:nth-child(4) .stat-icon {
            color: #7209b7;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .stat-change {
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        
        .stat-change.positive {
            color: #2ecc71;
        }
        
        .stat-change.negative {
            color: #e74c3c;
        }
        
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .chart-card {
            background-color: white;
            border-radius: var(--card-border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .chart-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .chart-actions {
            display: flex;
            gap: 10px;
        }
        
        .chart-btn {
            background: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .chart-btn:hover {
            background-color: #f8f9fa;
        }
        
        .chart-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .chart-placeholder {
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 8px;
            color: var(--gray-color);
        }
        
        .recent-activity {
            background-color: white;
            border-radius: var(--card-border-radius);
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .activity-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 20px;
        }
        
        .activity-list {
            list-style: none;
        }
        
        .activity-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(67, 97, 238, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary-color);
            font-size: 18px;
        }
        
        .activity-details {
            flex: 1;
        }
        
        .activity-text {
            margin-bottom: 5px;
            line-height: 1.4;
        }
        
        .activity-time {
            font-size: 14px;
            color: var(--gray-color);
        }
        
        /* Responsive Styles */
        @media (max-width: 1200px) {
            .charts-container {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar .logo-text,
            .sidebar .menu-text {
                display: none;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .search-box input {
                width: 40px;
                padding-left: 40px;
            }
            
            .search-box input:focus {
                width: 200px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .header {
                padding: 0 15px;
            }
            
            .content-area {
                padding: 15px;
            }
            
            .welcome-banner {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .welcome-text h1 {
                font-size: 24px;
            }
            
            .stats-cards {
                grid-template-columns: 1fr;
            }
            
            .charts-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    
    <aside class="sidebar" id="sidebar">
        <div class="logo-container">
            <div class="logo">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="logo-text">DashboardPro</div>
        </div>
        
        <ul class="sidebar-menu">
            <li class="menu-item active">
                <div class="menu-icon"><i class="fas fa-home"></i></div>
                <div class="menu-text">Dashboard</div>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-chart-bar"></i></div>
                <div class="menu-text">Analytics</div>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-users"></i></div>
                <div class="menu-text">Users</div>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="menu-text">Orders</div>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-cog"></i></div>
                <div class="menu-text">Settings</div>
            </li>
            <li class="menu-item">
                <div class="menu-icon"><i class="fas fa-question-circle"></i></div>
                <div class="menu-text">Help & Support</div>
            </li>
        </ul>
    </aside>
    
    
    <main class="main-content" id="mainContent">
        
        <header class="header">
            <div class="header-left">
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">Dashboard</h1>
            </div>
            
            <div class="header-right">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Search...">
                </div>
                
                <div class="user-profile">
                    <div class="user-avatar">JS</div>
                    <span class="user-name">John Smith</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </header>
        
        
        <div class="content-area">
            
            <section class="welcome-banner">
                <div class="welcome-text">
                    <h1>Selamat Datang, John!</h1>
                    <p>Dashboard ini memberikan gambaran tentang kinerja dan aktivitas terbaru.</p>
                </div>
                <div class="welcome-date">
                    <p id="currentDate">Senin, 15 Januari 2024</p>
                </div>
            </section>
            
            
            <section class="stats-cards">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Total Pengguna</div>
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="stat-value" id="totalUsers">2,847</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> 12.5% dari bulan lalu
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Total Pendapatan</div>
                        <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
                    </div>
                    <div class="stat-value" id="totalRevenue">$42,580</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> 8.2% dari bulan lalu
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Konversi</div>
                        <div class="stat-icon"><i class="fas fa-percentage"></i></div>
                    </div>
                    <div class="stat-value" id="conversionRate">3.24%</div>
                    <div class="stat-change negative">
                        <i class="fas fa-arrow-down"></i> 1.1% dari bulan lalu
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Waktu Rata-rata</div>
                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    </div>
                    <div class="stat-value" id="avgTime">4m 32s</div>
                    <div class="stat-change positive">
                        <i class="fas fa-arrow-up"></i> 15 detik lebih lama
                    </div>
                </div>
            </section>
            
            
            <section class="charts-container">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Traffic Pengunjung</h3>
                        <div class="chart-actions">
                            <button class="chart-btn active" data-period="week">Minggu</button>
                            <button class="chart-btn" data-period="month">Bulan</button>
                            <button class="chart-btn" data-period="year">Tahun</button>
                        </div>
                    </div>
                    <div class="chart-placeholder">
                        <p>Grafik Traffic Pengunjung akan ditampilkan di sini</p>
                    </div>
                </div>
                
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Sumber Traffic</h3>
                        <div class="chart-actions">
                            <button class="chart-btn active" data-chart="pie">Pie</button>
                            <button class="chart-btn" data-chart="bar">Bar</button>
                            <button class="chart-btn" data-chart="doughnut">Donat</button>
                        </div>
                    </div>
                    <div class="chart-placeholder">
                        <p>Grafik Sumber Traffic akan ditampilkan di sini</p>
                    </div>
                </div>
            </section>
            
            
            <section class="recent-activity">
                <h3 class="activity-title">Aktivitas Terbaru</h3>
                <ul class="activity-list" id="activityList">
                    
                </ul>
            </section>
        </div>
    </main>
    
    <script>
        // DOM Elements
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');
        const menuItems = document.querySelectorAll('.menu-item');
        const chartPeriodBtns = document.querySelectorAll('.chart-btn[data-period]');
        const chartTypeBtns = document.querySelectorAll('.chart-btn[data-chart]');
        const currentDateElement = document.getElementById('currentDate');
        const activityList = document.getElementById('activityList');
        
        // Format tanggal saat ini
        function updateCurrentDate() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            currentDateElement.textContent = now.toLocaleDateString('id-ID', options);
        }
        
        // Toggle sidebar collapse/expand
        toggleSidebarBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            // Toggle icon
            const icon = toggleSidebarBtn.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-chevron-right');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-bars');
            }
        });
        
        // Set active menu item
        menuItems.forEach(item => {
            item.addEventListener('click', () => {
                menuItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
            });
        });
        
        // Handle chart period buttons
        chartPeriodBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                chartPeriodBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                // In a real app, this would update the chart data
                console.log(`Changed chart period to: ${btn.dataset.period}`);
            });
        });
        
        // Handle chart type buttons
        chartTypeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                chartTypeBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                // In a real app, this would change the chart type
                console.log(`Changed chart type to: ${btn.dataset.chart}`);
            });
        });
        
        // Sample activity data
        const activities = [
            { icon: 'fa-user-plus', text: 'Pengguna baru "Sarah Johnson" telah terdaftar', time: '10 menit yang lalu' },
            { icon: 'fa-shopping-cart', text: 'Pesanan #ORD-7842 telah berhasil diproses', time: '30 menit yang lalu' },
            { icon: 'fa-chart-line', text: 'Laporan bulanan telah dihasilkan dan siap diunduh', time: '2 jam yang lalu' },
            { icon: 'fa-exclamation-circle', text: 'Peringatan: Terjadi penurunan traffic sebesar 5%', time: '5 jam yang lalu' },
            { icon: 'fa-check-circle', text: 'Pembaruan sistem berhasil diterapkan', time: '1 hari yang lalu' },
            { icon: 'fa-envelope', text: 'Email kampanye baru telah dikirim ke 2.500 pelanggan', time: '2 hari yang lalu' }
        ];
        
        // Populate activity list
        function loadActivities() {
            activityList.innerHTML = '';
            
            activities.forEach(activity => {
                const li = document.createElement('li');
                li.className = 'activity-item';
                
                li.innerHTML = `
                    <div class="activity-icon">
                        <i class="fas ${activity.icon}"></i>
                    </div>
                    <div class="activity-details">
                        <div class="activity-text">${activity.text}</div>
                        <div class="activity-time">${activity.time}</div>
                    </div>
                `;
                
                activityList.appendChild(li);
            });
        }
        
        // Simulate real-time updates for stats
        function updateStats() {
            // Simulate changing numbers
            const users = document.getElementById('totalUsers');
            const revenue = document.getElementById('totalRevenue');
            const conversion = document.getElementById('conversionRate');
            const avgTime = document.getElementById('avgTime');
            
            // Animate numbers (simulated)
            let userCount = 2847;
            let revenueCount = 42580;
            
            // In a real app, these would be fetched from an API
            setInterval(() => {
                // Random small fluctuations
                userCount += Math.floor(Math.random() * 5) - 2;
                revenueCount += Math.floor(Math.random() * 20) - 10;
                
                users.textContent = userCount.toLocaleString();
                revenue.textContent = `$${revenueCount.toLocaleString()}`;
            }, 5000);
        }
        
        // Initialize the dashboard
        function initDashboard() {
            updateCurrentDate();
            loadActivities();
            updateStats();
            
            // For mobile, close sidebar by default
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                sidebar.classList.remove('mobile-open');
                mainContent.classList.add('expanded');
                
                const icon = toggleSidebarBtn.querySelector('i');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-chevron-right');
            }
            
            // Mobile sidebar toggle
            if (window.innerWidth <= 768) {
                toggleSidebarBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('mobile-open');
                });
            }
        }
        
        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', initDashboard);
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-open');
            }
        });
    </script>
</body>
</html>