<div class="col-start-2 lg:col-start-4 col-end-13 py-2 rounded-lg">
    <div class="flex items-center justify-start flex-row-reverse">
        <button wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $user->id }} }})" class="focus:outline-none rounded-full">
            <x-user-icon :user="$user" />
        </button>
        <div class="relative mr-3 text-sm bg-indigo-100 dark:bg-indigo-500 dark:text-slate-100 py-2 px-4 shadow rounded-xl">
            <div class="break-all">{{$message['message']}}</div>
        </div>
        <div class="relative mr-3 text-xs dark:text-slate-400 py-2 text-nowrap">
            @if($message['created_at']->isToday())
                <div>{{$message['created_at']->format('H:i')}}</div>
            @else
                <div>{{$message['created_at']->format('d-m')}}</div>
            @endif
        </div>
    </div>
</div>
