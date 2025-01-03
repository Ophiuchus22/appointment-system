<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body class="bg-gray-100">
    @include('layouts.sidebar')
    <div class="flex justify-center min-h-screen p-6">
        <div class="w-full max-w-5xl">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Client Management</h2>
                </div>

                @if(session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($clients as $client)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $client->first_name }} {{ $client->last_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $client->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $client->phone_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $client->address }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex gap-4">
                                            <a href="{{route('admin.clients.edit', $client)}}" 
                                               class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <form action="{{ route('admin.clients.destroy', $client) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this client?');"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>