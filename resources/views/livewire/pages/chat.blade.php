<div class="flex antialiased text-gray-800">
    <div class="flex flex-row h-full w-full overflow-x-hidden">
        <x-side-list :conversations="$conversations" />
        <x-chat-area :messages="$messages" :conversation="$conversation" />
    </div>
</div>

