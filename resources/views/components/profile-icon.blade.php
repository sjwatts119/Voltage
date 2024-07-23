{{-- Requires $user --}}
<div class="h-32 w-32 bg-white dark:bg-gray-800 p-2 rounded-full">
    <div class="h-28 w-28 flex items-center justify-center rounded-full {{ $user->image ? '' : 'bg-purple-400' }}">
        @if($user->image)
            <img src="{{ $user->image }}" alt="User Image" class="rounded-full">
        @else
            <div class="text-5xl">{{ $user->name[0] }}</div>
        @endif
    </div>
</div>
