<div class="col-start-2 lg:col-start-4 col-end-13 p-3 rounded-lg">
    <div class="flex items-center justify-start flex-row-reverse">
        <button wire:click="$dispatch('showUserProfile', { userId: {{ $user->id }} })" class="focus:outline-none rounded-full">
            <x-user-icon :user="$user" />
        </button>
        <div class="relative mr-3 text-sm bg-indigo-100 dark:bg-indigo-500 dark:text-slate-100 py-2 px-4 shadow rounded-xl">
            <div class="break-words">{{$message['message']}}</div>
        </div>
        <div class="relative mr-3 text-xs dark:text-slate-400 py-2">
            <div>{{$message['created_at']}}</div>
        </div>
    </div>
</div>
