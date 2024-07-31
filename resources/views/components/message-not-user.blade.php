<div class="col-start-1 col-end-12 lg:col-end-9 py-2 rounded-lg">
    <div class="flex flex-row items-center">
        @php
            // We need to get the user from the model, as users can be removed as participants from the conversation
            $user = \App\Models\User::find($message['user_id']);
        @endphp
        <button wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $user->id }} }})" class="focus:outline-none rounded-xl justify-start">
            <x-user-icon :user="$user" />
        </button>
        <div class="relative ml-3 text-sm bg-white dark:bg-slate-700 dark:text-slate-100 py-2 px-4 shadow rounded-xl">
            <div class="break-all">{{$message['message']}}</div>
        </div>
        <div class="relative ml-3 text-xs dark:text-slate-400 py-2 text-nowrap">
            @if($message['created_at']->isToday())
                <div>{{$message['created_at']->format('H:i')}}</div>
            @else
                <div>{{$message['created_at']->format('d-m')}}</div>
            @endif
        </div>
    </div>
</div>
