<div class="flex antialiased text-gray-800">
    <div class="flex flex-row h-full w-full overflow-x-hidden">
        <x-side-list :conversations="$conversations" :activeConversation="$activeConversation"  />
        <x-chat-area :messageGroups="$messageGroups" :activeConversation="$activeConversation" :currentlyEditingId="$currentlyEditingId" :loadedMessages="$loadedMessages"/>
    </div>
</div>

