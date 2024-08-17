{{-- Get user associated with this message group --}}
@php($user = \App\Models\User::find($messageGroup[0]->user_id))

<div class="pt-3">
    <div class="px-6 w-full hover:bg-black/10 dark:hover:bg-white/10 transition group">
        <div class="flex items-start space-x-4">
            {{-- User Icon --}}
            <div class="flex-shrink-0 pt-1.5">
                <button wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $user->id }} }})" class="focus:outline-none rounded-full">
                    <x-user-icon :user="$user" class="h-10 w-10"/>
                </button>
            </div>

            {{-- User Info and Messages --}}
            <div class="flex-grow">
                <div class="flex items-baseline space-x-2 pt-1">
                    {{-- User's name --}}
                    <div wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $user->id }} }})" class="text-sm text-black dark:text-white break-all hover:underline cursor-pointer transition">
                        {{$user->name}}
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
                <div class="text-sm dark:text-slate-300 py-1 break-all relative group">
                    {{ $messageGroup[0]->message }}
                </div>
            </div>
            @if($messageGroup[0]->user_id === auth()->id())
                <div class="flex-shrink-0 flex flex-col items-center justify-center my-auto">
                    <button wire:click="deleteMessage({{ $messageGroup[0]->id }})" class="text-red-500 text-xl text-center justify-center invisible group-hover:visible transition">x</button>
                </div>
            @else
                <div class="flex-shrink-0 flex flex-col items-center justify-center my-auto">
                    <div class="text-red-500 text-xl text-center justify-center invisible group-hover:visible transition">x</div>
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
                {{ $message->message }}
            </div>

            @if($message->user_id === auth()->id())
                <div class="flex-shrink-0 flex flex-col items-center justify-center my-auto">
                    <button wire:click="deleteMessage({{ $message->id }})" class="text-red-500 text-xl text-center justify-center invisible group-hover:visible transition">x</button>
                </div>
            @else
                <div class="flex-shrink-0 flex flex-col items-center justify-center my-auto">
                    <div class="text-red-500 text-xl text-center justify-center invisible group-hover:visible transition">x</div>
                </div>
            @endif
        </div>
    @endforeach
</div>
