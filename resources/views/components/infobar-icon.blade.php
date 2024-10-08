{{--requires $activeConversation --}}

@if($activeConversation->is_group)
    {{-- when group chats can have images, do this here --}}
    <button wire:click="$dispatch('openModal', { component: 'ChatInfo', arguments: { conversation: {{ $activeConversation->id }} }})" class="flex items-center justify-center h-10 w-10 bg-purple-400 rounded-full antialiased">
        <svg class="svg-icon w-6" viewBox="0 0 20 20">
            <path fill="currentColor" d="M15.573,11.624c0.568-0.478,0.947-1.219,0.947-2.019c0-1.37-1.108-2.569-2.371-2.569s-2.371,1.2-2.371,2.569c0,0.8,0.379,1.542,0.946,2.019c-0.253,0.089-0.496,0.2-0.728,0.332c-0.743-0.898-1.745-1.573-2.891-1.911c0.877-0.61,1.486-1.666,1.486-2.812c0-1.79-1.479-3.359-3.162-3.359S4.269,5.443,4.269,7.233c0,1.146,0.608,2.202,1.486,2.812c-2.454,0.725-4.252,2.998-4.252,5.685c0,0.218,0.178,0.396,0.395,0.396h16.203c0.218,0,0.396-0.178,0.396-0.396C18.497,13.831,17.273,12.216,15.573,11.624 M12.568,9.605c0-0.822,0.689-1.779,1.581-1.779s1.58,0.957,1.58,1.779s-0.688,1.779-1.58,1.779S12.568,10.427,12.568,9.605 M5.06,7.233c0-1.213,1.014-2.569,2.371-2.569c1.358,0,2.371,1.355,2.371,2.569S8.789,9.802,7.431,9.802C6.073,9.802,5.06,8.447,5.06,7.233 M2.309,15.335c0.202-2.649,2.423-4.742,5.122-4.742s4.921,2.093,5.122,4.742H2.309z M13.346,15.335c-0.067-0.997-0.382-1.928-0.882-2.732c0.502-0.271,1.075-0.429,1.686-0.429c1.828,0,3.338,1.385,3.535,3.161H13.346z"></path>
        </svg>
    </button>
@else
    {{-- If there's only one user, the other user has deleted their account --}}
    @if($activeConversation->users->count() === 1)
        <div class="flex items-center justify-center h-10 w-10 min-w-10 rounded-full bg-gray-400"></div>
    @endif

    {{-- check if chat user that isn't the logged in user has an image --}}
    @foreach($activeConversation->users as $user)
        @if($user->id === auth()->id())
            @continue
        @endif

        <button wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $user->id }} }})" class="flex items-center justify-center h-10 w-10 min-w-10 rounded-full {{ $user->image ? '' : 'bg-purple-400' }}">
            @if($user->profile->profile_thumb)
                <img src="{{ asset('storage/' . $user->profile->profile_thumb) }}" alt="User Image" class="h-10 w-10 min-w-10 object-cover rounded-full">
            @else
                {{ $user->name[0] }}
            @endif
        </button>
    @endforeach
@endif
<button wire:click="$dispatch('openModal', { component: 'ChatInfo', arguments: { conversation: {{ $activeConversation->id }} }})" class="text-lg font-sans dark:text-gray-300 hidden lg:block hover:underline transition">
    {{ $activeConversation->getFriendlyName($activeConversation->id, 60)}}
</button>
<div wire:click="$dispatch('openModal', { component: 'ChatInfo', arguments: { conversation: {{ $activeConversation->id }} }})" class="text-lg font-sans dark:text-gray-300 lg:hidden hover:underline transition">
    {{ $activeConversation->getFriendlyName($activeConversation->id, 20)}}
</div>



