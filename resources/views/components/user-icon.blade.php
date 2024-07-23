{{-- Requires $user --}}
<div class="flex items-center justify-center h-10 w-10 rounded-full {{ $user->image ? '' : 'bg-purple-400' }}">
    @if($user->image)
        <img src="{{ $user->image }}" alt="User Image" class="h-10 w-10 rounded-full">
    @else
        {{ $user->name[0] }}
    @endif
</div>
