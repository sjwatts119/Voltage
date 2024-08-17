@foreach($messageGroup as $message)
    <div class="col-start-1 col-end-13 py-2">
        <div class="flex items-center justify-center dark:text-slate-300">
            <div class="relative text-md text-center py-2 px-4">
                <div class="break-words">
                    {{-- actioning user . action . target user --}}
                    @php
                        $actioningUser = \App\Models\User::find($message->actioned_by_user_id);
                        $targetUser = \App\Models\User::find($message->affects_user_id);
                    @endphp

                    <div class="text-sm dark:text-slate-300">
                        @switch($message->action)
                            @case('added')
                                @if($actioningUser && $targetUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> added
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $targetUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$targetUser->name}}</span> to the conversation
                                @elseif($actioningUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> added an unknown user to the conversation
                                @elseif($targetUser)
                                    An unknown user was added to the conversation by <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $targetUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$targetUser->name}}</span>
                                @else
                                    <span>An unknown user was added to the conversation by an unknown user</span>
                                @endif
                                @break
                            @case('removed')
                                @if($actioningUser && $targetUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> removed
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $targetUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$targetUser->name}}</span> from the conversation
                                @elseif($actioningUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> removed an unknown user from the conversation
                                @elseif($targetUser)
                                    An unknown user was removed from the conversation by <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $targetUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$targetUser->name}}</span>
                                @else
                                    <span>An unknown user was removed from the conversation by an unknown user</span>
                                @endif
                                @break
                            @case('name_change')
                                @if($actioningUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> changed the conversation name to <span class="font-bold">{{$message->message}}</span>
                                @else
                                    <span>An unknown user has changed the conversation name.</span>
                                @endif
                                @break
                            @case('left')
                                @if($actioningUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> left the conversation
                                @else
                                    <span>An unknown user has left the conversation.</span>
                                @endif
                                @break
                            @default
                                @if($actioningUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> performed an unknown action
                                @else
                                    <span>An action was performed by an unknown user.</span>
                                @endif
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
