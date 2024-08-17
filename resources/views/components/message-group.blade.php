{{-- Get user associated with this message group --}}
@php($user = \App\Models\User::find($messageGroup[0]->user_id))

<div class="px-2 py-3 rounded-lg">
    <div class="flex items-start space-x-4">
        {{-- User Icon --}}
        <div class="flex-shrink-0">
            <button wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $user->id }} }})" class="focus:outline-none rounded-full">
                <x-user-icon :user="$user" class="h-10 w-10"/>
            </button>
        </div>

        {{-- User Info and Messages --}}
        <div class="flex-grow">
            <div class="flex items-baseline space-x-2">
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

            {{-- Messages --}}
            @foreach($messageGroup as $message)
                <div class="text-sm dark:text-slate-300 py-1 break-all">
                    {{$message->message}}
                </div>
            @endforeach
        </div>
    </div>
</div>
