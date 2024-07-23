<div class="col-start-1 col-end-11 lg:col-end-9 p-3 rounded-lg">
    <div class="flex flex-row items-center">
        @php
            //participants collection passed in by parent, we need to find the user that sent this message;
            $user = $participants->where('id', $message['user_id'])->first();
        @endphp
        <button wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ $user->id }} }})" class="focus:outline-none rounded-xl">
            <x-user-icon :user="$user" />
        </button>
        <div class="relative ml-3 text-sm bg-white dark:bg-slate-700 dark:text-slate-100 py-2 px-4 shadow rounded-xl">
            <div class="break-words">{{$message['message']}}</div>
        </div>
        <div class="relative ml-3 text-xs dark:text-slate-400 py-2">
            <div>{{$message['created_at']->format('H:i · d-m')}}</div>
        </div>
    </div>
</div>
