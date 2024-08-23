@if($attachments)
    @if($attachments->every(fn($attachment) => str_contains($attachment->type, 'image')))
        {{-- Is there only one attachment? Show a single image--}}
        @if($attachments->count() === 1)
            <x-view-attachments-image :attachments="$attachments"/>
        {{-- Are there two or more attachments? Show a gallery of images --}}
        @elseif($attachments->count() > 1)
            <x-view-attachments-gallery :attachments="$attachments"/>
        @endif
    @else

    @endif
@endif


