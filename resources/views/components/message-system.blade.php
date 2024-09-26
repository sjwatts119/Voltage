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
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $targetUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$targetUser->name}}</span> to the conversation.
                                @elseif($actioningUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> added a Deleted User to the conversation.
                                @elseif($targetUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $targetUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$targetUser->name}}</span> was added to the conversation by a Deleted User.
                                @else
                                    <span>A Deleted User was added to the conversation by a Deleted User</span>
                                @endif
                                @break
                            @case('removed')
                                @if($actioningUser && $targetUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $targetUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$targetUser->name}}</span> was removed from the conversation by
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span>.
                                @elseif($actioningUser)
                                    A Deleted User was removed from the conversation by
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span>.
                                @elseif($targetUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $targetUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$targetUser->name}}</span> was removed from the conversation by a Deleted User.
                                @else
                                    <span>A Deleted User was removed from the conversation by a Deleted User.</span>
                                @endif
                                @break
                            @case('name_change')
                                @if($actioningUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> changed the conversation name to <span class="font-bold">{{$message->message}}</span>
                                @else
                                    <span>A Deleted User has changed the conversation name.</span>
                                @endif
                                @break
                            @case('left')
                                @if($actioningUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> left the conversation
                                @else
                                    <span>A Deleted User has left the conversation.</span>
                                @endif
                                @break
                            @default
                                @if($actioningUser)
                                    <span wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $actioningUser->id }} }})" class="font-bold cursor-pointer hover:underline">{{$actioningUser->name}}</span> performed an deleted action
                                @else
                                    <span>An unknown action was performed by an Deleted User.</span>
                                @endif
                        @endswitch
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
