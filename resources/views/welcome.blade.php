<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Academic Affairs Office - Internal Portal</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-white">
            <!-- Header -->
            <header class="bg-white shadow-sm sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <svg class="icon-lg text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"/>
                            </svg>
                            <div class="ml-3">
                                <h1 class="text-xl font-bold text-gray-900">Academic Affairs Office</h1>
                                <p class="text-sm text-gray-600">Internal Management System</p>
                            </div>
                        </div>
                        
                        @if (Route::has('login'))
                            <nav class="flex items-center space-x-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn-primary">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn-primary">
                                        Login to Portal
                                    </a>
                                @endauth
                            </nav>
                        @endif
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="max-w-5xl mx-auto px-4 py-16">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Academic Affairs Management Portal
                    </h2>
                    <p class="text-gray-600">
                        Internal system for academic affairs management and operations
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                    <div class="text-center p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Appointments</h3>
                        <p class="text-gray-600">Manage and track appointments efficiently</p>
                    </div>
                    <div class="text-center p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Schedule</h3>
                        <p class="text-gray-600">View and organize daily activities</p>
                    </div>
                    <div class="text-center p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Reports</h3>
                        <p class="text-gray-600">Access and generate reports</p>
                    </div>
                </div>
            </main>

            <!-- Simple Footer -->
            <footer class="border-t border-gray-200 bg-white">
                <div class="max-w-5xl mx-auto px-4 py-8">
                    <div class="text-center text-gray-600">
                        <p class="mb-2">Office Hours: Monday - Friday, 8:00 AM - 5:00 PM</p>
                        <p>Contact: academic.affairs@university.edu</p>
                        <p class="mt-6 text-sm text-gray-500">
                            © {{ date('Y') }} Academic Affairs Office. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
