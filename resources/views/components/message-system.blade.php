@foreach($messageGroup as $message)
    <div class="col-start-1 col-end-13 py-2">
        <div class="flex items-center justify-center dark:text-slate-300">
            <div class="relative text-md text-center py-2 px-4">
                <div class="break-words">{{$message['message']}}</div>
            </div>
        </div>
    </div>
@endforeach
