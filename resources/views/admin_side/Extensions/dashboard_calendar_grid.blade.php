@foreach($calendar as $day)
    <div class="relative group hover:bg-gray-50 transition-colors bg-white p-2 w-full overflow-hidden
        {{ $viewType === 'week' 
            ? 'h-[calc(100vh-280px)] border-b border-gray-100 overflow-y-auto' 
            : 'min-h-[90px] max-h-[120px] overflow-y-auto' 
        }}">
        
        <div class="flex justify-between items-center mb-2 sticky top-0 bg-white z-10">
            <div>
                @if($viewType === 'week')
                    <div class="text-xs text-gray-500">{{ $day['date']->format('l') }}</div>
                @endif
                <span class="text-sm font-medium {{ $day['date']->isToday() ? 'text-blue-600' : 'text-gray-700' }} 
                    {{ in_array($day['date']->dayOfWeek, [0, 6]) ? 'text-gray-400' : '' }}">
                    {{ $day['date']->format('M j') }}
                </span>
            </div>
            @if($day['date']->isToday())
                <span class="text-xs px-1.5 py-0.5 rounded-full bg-blue-100 text-blue-800">Today</span>
            @endif
        </div>
        
        <div class="{{ $viewType === 'week' ? 'space-y-2' : 'space-y-1.5' }}">
            @foreach($day['appointments'] as $appointment)
                <div class="rounded-md transition-all hover:shadow-md
                    {{ $viewType === 'week' ? 'p-3' : 'p-1.5' }}
                    {{ $appointment->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                    {{ $appointment->status === 'confirmed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                    {{ $appointment->status === 'completed' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                    {{ $appointment->status === 'cancelled' ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                    
                    <div class="{{ $viewType === 'week' ? 'text-sm' : 'text-xs' }}">
                        <div class="font-medium">{{ Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</div>
                        <div class="{{ $viewType === 'week' ? 'mt-1 break-words' : 'truncate mt-1' }}">
                            {{ $appointment->purpose }}
                        </div>
                        @if($viewType === 'week')
                            <div class="mt-2 text-sm break-words">{{ $appointment->user->name }}</div>
                        @else
                            <div class="text-xs opacity-75 capitalize">{{ $appointment->status }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach