{{-- Requires $user --}}
<div {{ $attributes->merge(['class' => 'flex items-center justify-center h-10 w-10 rounded-full ' . ($user->image ? '' : 'bg-purple-400')]) }}>
    @if($user->profile->profile_photo)
        <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" alt="User Image" {{ $attributes->merge(['class' => 'h-10 w-10 rounded-full object-cover']) }}>
    @else
        {{ $user->name[0] }}
    @endif
</div>
