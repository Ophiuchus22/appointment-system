@foreach($calendar as $day)
    <div class="min-h-[90px] max-h-[120px] overflow-y-auto bg-white p-2 relative group hover:bg-gray-50 transition-colors">
        <div class="flex justify-between items-center mb-1">
            <span class="text-sm font-medium {{ $day['date']->isToday() ? 'text-blue-600' : 'text-gray-700' }} 
                {{ in_array($day['date']->dayOfWeek, [0, 6]) ? 'text-gray-400' : '' }}">
                {{ $day['date']->format('j') }}
            </span>
            @if($day['date']->isToday())
                <span class="text-xs px-1.5 py-0.5 rounded-full bg-blue-100 text-blue-800">Today</span>
            @endif
        </div>
        
        <div class="space-y-1">
            @foreach($day['appointments'] as $appointment)
                <div class="rounded-md p-1.5 text-xs transition-all hover:transform hover:scale-102
                    {{ $appointment->status === 'pending' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}
                    {{ $appointment->status === 'confirmed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                    {{ $appointment->status === 'completed' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                    {{ $appointment->status === 'cancelled' ? 'bg-red-50 text-red-700 border border-red-200' : '' }}">
                    <div class="font-medium">{{ Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</div>
                    <div class="truncate text-xs">{{ $appointment->purpose }}</div>
                    <div class="text-xs opacity-75 capitalize">{{ $appointment->status }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach