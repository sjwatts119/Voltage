<div class="">
    @if($messageAttachment)
        <img src="{{ asset('storage/attachments/' . $messageAttachment->attachment_path) }}" alt="Attachment" class="max-h-[80dvh]"/>
    @endif
</div>


