@if($attachments)
    @if($attachments->every(fn($attachment) => str_contains($attachment->type, 'image')))
        {{-- Is there only one attachment? Show a single image--}}
        @if($attachments->count() === 1)
            <x-view-attachments-image :attachment="$attachments[0]"/>
        {{-- Are there two or more attachments? Show a gallery of images --}}
        @elseif($attachments->count() > 1)
            <x-view-attachments-gallery :attachments="$attachments"/>
        @endif
    @else
        @foreach($attachments as $attachment)
            {{-- If the attachments is an image, display the image itself and not the file preview --}}
            @if(str_contains($attachment->type, 'image'))
                <x-view-attachments-image :attachment="$attachment"/>
            @else
                <x-view-attachments-file :attachment="$attachment" :loop="$loop"/>
            @endif
        @endforeach
    @endif
@endif


