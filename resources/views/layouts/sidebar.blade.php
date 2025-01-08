<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-bold">
                    <span class="bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent">Acad</span><span class="text-white">Point</span>
                </div>
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
                <span>&nbsp;&nbsp;Notifications</span>
            </button>

            <!-- Notification Slide-out Panel -->
            <div id="notificationPanel" class="fixed left-64 top-0 h-full w-80 bg-white shadow-2xl hidden z-40">
                <div class="h-full flex flex-col">
                    <!-- Panel Header -->
                    <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">Notifications</h2>
                        <div class="flex items-center space-x-2">
                            <button id="deleteAllNotifications" class="text-red-500 hover:text-red-700 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete All
                            </button>
                            <!-- <button id="closeNotifications" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button> -->
                        </div>
                    </div>

                    <!-- Panel Content -->
                    <div class="overflow-y-auto flex-1">
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
                                    <button class="ml-2 text-gray-400 hover:text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
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

            <a href="{{ route('admin.reports.index') }}" class="nav-item flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800/50 hover:text-white rounded-lg transition-all duration-200 group">
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

        document.addEventListener('DOMContentLoaded', function() {
            const notificationButton = document.getElementById('notificationButton');
            const notificationPanel = document.getElementById('notificationPanel');
            const notificationBadge = notificationButton?.querySelector('.rounded-full');
            
            // Function to mark notification as read
            window.markAsRead = function(id) {
                // Only make the API call if the notification is unread
                fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(() => {
                    fetchNotifications(); // Refresh the notifications
                })
                .catch(error => console.error('Error marking notification as read:', error));
            }

            // Only set up notification refresh if we're not on a page that shows success/error messages
            if (notificationButton && notificationPanel) {
                const hasSuccessMessage = document.getElementById('success-message');
                const hasErrorMessage = document.getElementById('error-message');

                // Initial fetch
                fetchNotifications();

                // Only set up interval if we're not on a page with messages
                if (!hasSuccessMessage && !hasErrorMessage) {
                    const notificationInterval = setInterval(fetchNotifications, 5000);

                    // Clean up interval when page is unloaded
                    window.addEventListener('beforeunload', () => {
                        clearInterval(notificationInterval);
                    });
                }
            }
        });

        // Function to fetch notifications
        function fetchNotifications() {
            fetch('/notifications')
                .then(response => response.json())
                .then(data => {
                    // Update notification count and badge
                    const notificationBadge = document.querySelector('#notificationButton .rounded-full');
                    if (notificationBadge) {
                        notificationBadge.textContent = data.count;
                        notificationBadge.classList.toggle('hidden', data.count === 0);
                    }
                    
                    // Update notification panel content
                    const notificationContent = document.querySelector('#notificationPanel .overflow-y-auto');
                    if (notificationContent) {
                        // Get notifications from the grouped data
                        const todayNotifications = data.notifications.today || [];
                        const earlierNotifications = data.notifications.earlier || [];

                        // Update the panel content
                        notificationContent.innerHTML = `
                            ${renderNotificationGroup('Today', todayNotifications)}
                            ${renderNotificationGroup('Earlier', earlierNotifications)}
                        `;

                        // If no notifications, show a message
                        if (todayNotifications.length === 0 && earlierNotifications.length === 0) {
                            notificationContent.innerHTML = `
                                <div class="p-4 text-center text-gray-500">
                                    No notifications
                                </div>
                            `;
                        }
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }

        // Function to render notification groups
        function renderNotificationGroup(title, notifications) {
            if (!notifications || notifications.length === 0) return '';
            
            return `
                <div class="p-4 ${title === 'Earlier' ? 'border-t border-gray-100' : ''}">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">${title}</h3>
                    ${notifications.map(notification => `
                        <div class="mb-4 p-3 bg-${getNotificationColor(notification.type)}-50 rounded-lg border border-${getNotificationColor(notification.type)}-100 relative group">
                            ${!notification.is_read ? `
                                <div class="absolute w-2 h-2 bg-blue-500 rounded-full top-2 right-2"></div>
                            ` : ''}
                            
                            <div class="cursor-pointer" onclick="markAsRead(${notification.id})">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-${getNotificationColor(notification.type)}-100 rounded-full p-2 mr-3">
                                        ${getNotificationIcon(notification.type)}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 ${!notification.is_read ? 'font-bold' : ''}">${notification.title || 'Notification'}</p>
                                        <p class="text-sm text-gray-600 mt-1">${notification.message}</p>
                                        <p class="mt-1 text-xs text-gray-500">${formatTime(notification.created_at)}</p>
                                        ${notification.is_read ? `
                                            <span class="text-xs text-gray-400">Read ${formatTime(notification.read_at)}</span>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;
        }

        // Function to get notification color based on type
        function getNotificationColor(type) {
            switch(type) {
                case 'unconfirmed': return 'yellow';
                case 'cancelled': return 'red';
                case 'upcoming_week':
                case 'upcoming_day':
                case 'upcoming_hour':
                    return 'blue';
                default: return 'gray';
            }
        }

        // Function to get notification icon based on type
        function getNotificationIcon(type) {
            switch(type) {
                case 'unconfirmed':
                    return `<svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>`;
                case 'cancelled':
                    return `<svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>`;
                case 'upcoming_week':
                case 'upcoming_day':
                case 'upcoming_hour':
                    return `<svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>`;
                default:
                    return `<svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>`;
            }
        }

        // Function to format time
        function formatTime(timestamp) {
            const date = new Date(timestamp);
            const now = new Date();
            const diff = now - date;
            const minutes = Math.floor(diff / 60000);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            if (minutes < 60) {
                return minutes <= 1 ? 'Just now' : `${minutes} minutes ago`;
            } else if (hours < 24) {
                return hours === 1 ? '1 hour ago' : `${hours} hours ago`;
            } else if (days < 7) {
                return days === 1 ? 'Yesterday' : `${days} days ago`;
            } else {
                return date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            }
        }

        // Add delete all notifications functionality
        const deleteAllBtn = document.getElementById('deleteAllNotifications');
        if (deleteAllBtn) {
            deleteAllBtn.addEventListener('click', function() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                fetch('/notifications/delete-all', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    return response.json().then(data => {
                        if (!response.ok) {
                            throw new Error(data.message || `HTTP error! status: ${response.status}`);
                        }
                        return data;
                    });
                })
                .then(data => {
                    if (data.success) {
                        // Refresh notifications
                        fetchNotifications();
                        
                        // Update badge count to 0
                        const notificationBadge = document.querySelector('#notificationButton .rounded-full');
                        if (notificationBadge) {
                            notificationBadge.textContent = '0';
                            notificationBadge.classList.add('hidden');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error details:', error);
                });
            });
        }
    </script>
</body>
</html>