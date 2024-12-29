<!-- View All Activities Modal -->
<div id="viewAllActivitiesModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50 transition-opacity"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-xl shadow-lg max-w-4xl w-full max-h-[80vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Activity Logs</h3>
                <button onclick="closeViewAllActivitiesModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 overflow-y-auto max-h-[60vh]">
                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-start space-x-3 pb-4 border-b border-gray-100 last:border-0">
                            <div class="mt-1">
                                <div class="p-2 bg-blue-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 011 1v3h3a1 1 0 110 2H6a1 1 0 01-1-1V8a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <p class="text-sm text-gray-800">{{ $activity['action'] }}</p>
                                    <span class="text-xs text-gray-500">{{ $activity['time'] }}</span>
                                </div>
                                @if(isset($activity['details']))
                                    <p class="mt-1 text-sm text-gray-600">{{ $activity['details'] }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-gray-500 text-sm">No recent activities found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-100 p-4 bg-gray-50">
                <button 
                    onclick="closeViewAllActivitiesModal()" 
                    class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openViewAllActivitiesModal() {
        document.getElementById('viewAllActivitiesModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeViewAllActivitiesModal() {
        document.getElementById('viewAllActivitiesModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('viewAllActivitiesModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeViewAllActivitiesModal();
        }
    });

    // Close modal on escape key press
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('viewAllActivitiesModal').classList.contains('hidden')) {
            closeViewAllActivitiesModal();
        }
    });
</script> 