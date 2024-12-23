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

        <div class="relative px-4">
            <!-- Notification Bell Button -->
            <button id="notificationButton" class="nav-item flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800/50 hover:text-white rounded-lg transition-all duration-200 group">
                <div class="relative">
                    <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </div>
                <span>Notifications</span>
            </button>

            <!-- Notification Slide-out Panel -->
            <div id="notificationPanel" class="fixed left-64 top-0 h-full w-80 bg-white shadow-2xl hidden z-40">
                <div class="h-full flex flex-col">
                    <!-- Panel Header -->
                    <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">Notifications</h2>
                        <button id="closeNotifications" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Panel Content -->
                    <div class="flex-1 overflow-y-auto">
                        <!-- Today's Notifications -->
                        <div class="p-4">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Today</h3>
                            <!-- Notification Item -->
                            <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-blue-100 rounded-full p-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm text-gray-900">New appointment request from <span class="font-semibold">John Doe</span></p>
                                        <p class="mt-1 text-xs text-gray-500">2 hours ago</p>
                                    </div>
                                    <button class="ml-2 text-gray-400 hover:text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Earlier Notifications -->
                        <div class="p-4 border-t border-gray-100">
                            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Earlier</h3>
                            <!-- Notification Item -->
                            <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-gray-100 rounded-full p-2">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <p class="text-sm text-gray-900">Appointment with <span class="font-semibold">Jane Smith</span> was confirmed</p>
                                        <p class="mt-1 text-xs text-gray-500">Yesterday at 4:30 PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Footer -->
                    <div class="p-4 border-t border-gray-200">
                        <button class="w-full px-4 py-2 text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Mark all as read
                        </button>
                    </div>
                </div>
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

        // Replace the existing notification JavaScript with this:
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const notificationPanel = document.getElementById('notificationPanel');
            const notificationButton = document.getElementById('notificationButton');
            const closeNotifications = document.getElementById('closeNotifications');

            // Update CSS class for notification panel - remove transform classes
            notificationPanel.classList.remove('transform', 'translate-x-full', 'transition-transform');
            notificationPanel.classList.add('hidden'); // Add hidden by default

            // Function to close notification panel
            function closeNotificationPanel() {
                notificationPanel.classList.add('hidden');
            }

            // Open notification panel
            if (notificationButton) {
                notificationButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationPanel.classList.remove('hidden');
                });
            }

            // Close notification panel with close button
            if (closeNotifications) {
                closeNotifications.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeNotificationPanel();
                });
            }

            // Close panel when clicking outside
            document.addEventListener('click', function(event) {
                if (!notificationPanel.contains(event.target) && !notificationButton.contains(event.target)) {
                    closeNotificationPanel();
                }
            });

            // Close notification panel when sidebar closes
            sidebar.addEventListener('mouseleave', function() {
                closeNotificationPanel();
            });

            // Close notification panel when clicking sidebar trigger
            document.querySelector('.sidebar-trigger').addEventListener('click', function() {
                if (!sidebar.classList.contains('active')) {
                    closeNotificationPanel();
                }
            });
        });
    </script>
</body>
</html>