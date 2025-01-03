<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar {
            position: fixed;
            left: -256px;
            transition: all 0.3s ease-in-out;
            z-index: 50;
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar.active {
            transform: translateX(256px);
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.3);
        }

        .edge-trigger {
            position: fixed;
            left: 0;
            top: 0;
            width: 20px;
            height: 100vh;
            z-index: 40;
            background: linear-gradient(to right, rgba(0,0,0,0.05), transparent);
        }

        .nav-item {
            position: relative;
            margin: 4px 0;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            width: 4px;
            height: 0;
            background: #3b82f6;
            border-radius: 0 4px 4px 0;
            transition: height 0.2s ease;
        }

        .nav-item:hover::before {
            height: 100%;
        }

        .nav-item.active {
            background: rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body>
    <!-- Added edge trigger div -->
    <div id="edge-trigger" class="edge-trigger"></div>

    <div id="sidebar" class="sidebar bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white w-64 min-h-screen shadow-lg">
        <div class="sidebar-trigger absolute -right-3 top-1/2 transform -translate-y-1/2 w-3 h-12 bg-gray-700/50 rounded-r cursor-pointer hover:bg-blue-500/50 transition-colors"></div>
        <div class="flex items-center space-x-4 mb-8 p-6 border-b border-gray-700/50">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                <span class="text-lg font-bold">A</span>
            </div>
            <div>
                <div class="text-xl font-bold">Admin Panel</div>
                <div class="text-sm text-blue-400">Administrator</div>
            </div>
        </div>

        <nav class="space-y-2 px-4">
            <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Main Menu</div>
            
            <a href="/admin/dashboard" class="nav-item flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800/50 hover:text-white rounded-lg transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="/admin/appointments" class="nav-item flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800/50 hover:text-white rounded-lg transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Appointments</span>
            </a>

            <a href="/admin/clients" class="nav-item flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800/50 hover:text-white rounded-lg transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>Clients</span>
            </a>

            <a href="/admin/users" class="nav-item flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800/50 hover:text-white rounded-lg transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>User Management</span>
            </a>

            <a href="/admin/reports" class="nav-item flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800/50 hover:text-white rounded-lg transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Reports</span>
            </a>
        </nav>

        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700/50">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-red-500/10 hover:text-red-400 rounded-lg transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const trigger = document.querySelector('.sidebar-trigger');
            const edgeTrigger = document.getElementById('edge-trigger');
            let isDragging = false;
            let startX;
            let sidebarLeft;

            // Toggle sidebar on trigger click
            if (trigger) {
                trigger.addEventListener('click', () => {
                    sidebar.classList.toggle('active');
                });
            }

            // Function to handle drag start
            function handleDragStart(e) {
                isDragging = true;
                startX = e.clientX;
                sidebarLeft = sidebar.getBoundingClientRect().left;
                e.preventDefault();
            }

            sidebar.addEventListener('mousedown', handleDragStart);
            edgeTrigger.addEventListener('mousedown', handleDragStart);

            document.addEventListener('mousemove', (e) => {
                if (!isDragging) return;

                const dragDistance = e.clientX - startX;
                
                if (dragDistance > 50 && !sidebar.classList.contains('active')) {
                    sidebar.classList.add('active');
                }
                else if (dragDistance < -50 && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            });

            document.addEventListener('mouseup', () => {
                isDragging = false;
            });

            // Improved hover functionality with delay
            let hoverTimeout;

            function openSidebar() {
                clearTimeout(hoverTimeout);
                sidebar.classList.add('active');
            }

            function closeSidebar() {
                hoverTimeout = setTimeout(() => {
                    if (!isDragging) {
                        sidebar.classList.remove('active');
                    }
                }, 300); // 300ms delay before closing
            }

            // Add hover listeners to both sidebar and edge trigger
            sidebar.addEventListener('mouseenter', openSidebar);
            edgeTrigger.addEventListener('mouseenter', openSidebar);
            sidebar.addEventListener('mouseleave', closeSidebar);
        });
    </script>
</body>
</html>