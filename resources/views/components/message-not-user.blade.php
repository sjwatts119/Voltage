<div class="col-start-1 col-end-11 lg:col-end-9 p-3 rounded-lg">
    <div class="flex flex-row items-center">
        <img src="https://placehold.jp/150x150.png" alt="" class="flex items-center justify-center h-10 w-10 rounded-full flex-shrink-0"/>
        <div class="relative ml-3 text-sm bg-white dark:bg-slate-700 dark:text-slate-100 py-2 px-4 shadow rounded-xl">
            <div class="break-words">{{$message['message']}}</div>
        </div>
        <div class="relative ml-3 text-xs dark:text-slate-400 py-2">
            <div>{{date('H:i' , $message['time'])}}</div>
        </div>
    </div>
</div>
