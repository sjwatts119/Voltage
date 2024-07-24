{{-- Requires $user --}}
<div class="h-32 w-32 bg-white dark:bg-gray-800 p-2 rounded-full">
    <div class="h-28 w-28 flex items-center justify-center rounded-full {{ $user->image ? '' : 'bg-purple-400' }}">
        @if($user->profile->profile_photo)
            <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" alt="User Image" class="w-full w-full rounded-full object-cover">
        @else
            <div class="text-5xl">{{ $user->name[0] }}</div>
        @endif
    </div>
</div>
