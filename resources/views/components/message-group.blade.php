<div class="pt-3">
    <div class="px-6 w-full hover:bg-black/10 dark:hover:bg-white/10 transition group">
        <div class="flex items-start space-x-4">
            {{-- User Icon --}}
            <div class="flex-shrink-0 pt-1.5">
                <button wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $messageGroup[0]->user->id }} }})" class="focus:outline-none rounded-full">
                    <x-user-icon :user="$messageGroup[0]->user" class="h-10 w-10"/>
                </button>
            </div>

            {{-- User Info and Messages --}}
            <div class="flex-grow">
                <div class="flex items-baseline space-x-2 pt-1">
                    {{-- User's name --}}
                    <div wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $messageGroup[0]->user->id }} }})" class="text-sm text-black dark:text-white break-all hover:underline cursor-pointer transition">
                        {{$messageGroup[0]->user->name}}
                    </div>

                    {{-- Timestamp --}}
                    <div class="text-xs dark:text-slate-400">
                        @if($messageGroup[0]->created_at->isToday())
                            <div>{{$messageGroup[0]->created_at->format('H:i')}}</div>
                        @else
                            <div>{{$messageGroup[0]->created_at->format('d-m')}}</div>
                        @endif
                    </div>
                </div>
                {{--for the first message include it on the same row as the user info--}}
                @if($currentlyEditingId && $currentlyEditingId === $messageGroup[0]->id)
                    <x-edit-message-input :message="$messageGroup[0]"/>
                @else
                    <div class="text-sm dark:text-slate-300 py-1 break-all relative group">
                        @if($messageGroup[0]->message)
                            {{ $messageGroup[0]->message }}
                            @if($messageGroup[0]->edited_at)
                                <span class="text-xs dark:text-slate-400 cursor-default" title="Last edited at {{ $messageGroup[0]->edited_at }}"> (edited)</span>
                            @endif
                        @endif
                        @if($messageGroup[0]->attachments)
                            <x-view-attachments :attachments="$messageGroup[0]->attachments"/>
                        @endif
                    </div>
                @endif
            </div>
            @if($messageGroup[0]->user_id === auth()->id())
                <div class="transition min-w-8 max-w-8 text-xs dark:text-slate-400 my-auto">
                    <x-message-dropdown-menu :message="$messageGroup[0]"/>
                </div>
            @else
                <div class="invisible transition inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 hover:text-gray-700 rounded-lg focus:outline-none dark:text-gray-200 dark:hover:text-gray-500">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                </div>
            @endif
        </div>
    </div>

    {{-- Messages --}}
    @foreach($messageGroup as $message)
        @if($loop->first)
            @continue
        @endif
        <div class="px-6 group flex items-center space-x-4 hover:bg-black/10 dark:hover:bg-white/10 transition">
            {{-- Timestamp --}}
            <div class="opacity-0 group-hover:opacity-100 transition min-w-10 max-w-10 text-xs dark:text-slate-400 text-center">
                @if($message->created_at->isToday())
                    {{$message->created_at->format('H:i')}}
                @else
                    {{$message->created_at->format('d-m')}}
                @endif
            </div>

            {{-- Message --}}
            <div class="text-sm dark:text-slate-300 py-1 break-all relative group flex-grow">
                @if($currentlyEditingId && $currentlyEditingId === $message->id)
                    <x-edit-message-input :message="$message"/>
                @else
                    <div>
                        @if($message->message)
                            {{ $message->message }}
                            @if($message->edited_at)
                                <span class="text-xs dark:text-slate-400 cursor-default" title="Last edited at {{ $message->edited_at }}"> (edited)</span>
                            @endif
                        @endif
                        @if($message->attachments)
                            <x-view-attachments :attachments="$message->attachments"/>
                        @endif
                    </div>
                @endif
            </div>

            @if($message->user_id === auth()->id())
                <div class="transition min-w-8 max-w-8 text-xs dark:text-slate-400">
                    <x-message-dropdown-menu :message="$message"/>
                </div>
            @else
                <div class="invisible transition inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 hover:text-gray-700 rounded-lg focus:outline-none dark:text-gray-200 dark:hover:text-gray-500">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                </div>
            @endif
        </div>
    @endforeach
</div>

