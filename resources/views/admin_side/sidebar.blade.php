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
            left: -256px; /* w-64 = 256px */
            transition: transform 0.3s ease-in-out;
            z-index: 50;
        }

        .sidebar.active {
            transform: translateX(256px);
        }

        .sidebar-trigger {
            position: absolute;
            right: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 48px;
            background: #1f2937;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 4px 0 6px rgba(0, 0, 0, 0.1);
        }

        .edge-trigger {
            position: fixed;
            left: 0;
            top: 0;
            width: 20px;
            height: 100vh;
            z-index: 40;
        }

        .sidebar.active .chevron-icon {
            transform: rotate(180deg);
        }

        .chevron-icon {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body>
    <!-- Added edge trigger div -->
    <div id="edge-trigger" class="edge-trigger"></div>

    <div id="sidebar" class="sidebar bg-gradient-to-b from-gray-800 to-gray-900 text-white w-64 min-h-screen p-4 shadow-lg">
        <div class="sidebar-trigger">
            <svg class="chevron-icon w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>

        <!-- Admin Header -->
        <div class="flex items-center space-x-4 mb-8 p-2">
            <div>
                <div class="text-xl font-bold">Admin Panel</div>
                <div class="text-sm text-gray-400">Administrator</div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="space-y-1">
            <div class="px-4 py-2 text-xs text-gray-400 uppercase">Main Menu</div>
            
            <a href="/admin/dashboard" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="/admin/appointments" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>Appointments</span>
            </a>

            <a href="/admin/users" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span>User Management</span>
            </a>

            <a href="/admin/reports" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors duration-200 group">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Reports</span>
            </a>

            <!-- Divider -->
            <div class="border-t border-gray-700 my-4"></div>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}" class="px-4">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-red-600 hover:text-white rounded-lg transition-colors duration-200 group">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const trigger = sidebar.querySelector('.sidebar-trigger');
            const edgeTrigger = document.getElementById('edge-trigger');
            let isDragging = false;
            let startX;
            let sidebarLeft;

            // Toggle sidebar on trigger click
            trigger.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });

            // Function to handle drag start
            function handleDragStart(e) {
                isDragging = true;
                startX = e.clientX;
                sidebarLeft = sidebar.getBoundingClientRect().left;
                // Prevent text selection while dragging
                e.preventDefault();
            }

            // Add mousedown listeners to both sidebar and edge trigger
            sidebar.addEventListener('mousedown', handleDragStart);
            edgeTrigger.addEventListener('mousedown', handleDragStart);

            document.addEventListener('mousemove', (e) => {
                if (!isDragging) return;

                const dragDistance = e.clientX - startX;
                
                // If dragging right and sidebar is closed
                if (dragDistance > 50 && !sidebar.classList.contains('active')) {
                    sidebar.classList.add('active');
                }
                // If dragging left and sidebar is open
                else if (dragDistance < -50 && sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                }
            });

            document.addEventListener('mouseup', () => {
                isDragging = false;
            });

            // Handle hover functionality
            sidebar.addEventListener('mouseenter', () => {
                sidebar.classList.add('active');
            });

            edgeTrigger.addEventListener('mouseenter', () => {
                sidebar.classList.add('active');
            });

            // Only close on mouseleave if we're not dragging
            sidebar.addEventListener('mouseleave', () => {
                if (!isDragging) {
                    sidebar.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>