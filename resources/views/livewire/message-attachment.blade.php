<div class="container rounded-2xl max-w-2xl">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl">
        <div class="flex flex-col min-h-[50dvh]">
            <div class="flex items-center justify-center w-full p-5 relative">
                <label for="dropzone-file" class="transition relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-900 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                    </div>
                    <input wire:model="newAttachments" id="dropzone-file" type="file" multiple="multiple" class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer"/>
                </label>
            </div>
                <div class="flex flex-col flex-auto h-32 w-full">
                    <div class="flex flex-auto overflow-x-auto w-full">
                        <div class="mb-5">
                            <div class="flex items-center w-full px-5 space-x-3 overflow-x-auto">
                                @if($attachments)
                                    @foreach($attachments as $attachment)
                                        <div class="relative w-28 h-28">
                                            <img src="{{ $attachment->temporaryUrl() }}" alt="Attachment" class="w-full h-full rounded-lg object-cover"/>
                                            <button wire:click="removeAttachment({{ $loop->index }})" class="transition absolute top-1 right-1 text-white bg-red-500 rounded-md hover:bg-red-700 hover:text-gray-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- if there's no attachments placeholders, add an empty placeholder prompting to upload an attachments --}}
                                    <div class="w-28 h-28 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Send button --}}
                <div class="flex items-center justify-center w-full p-5">
                    <button
                        wire:click="sendMessage"
                        class="flex items-center justify-center rounded-lg text-white border dark:border-gray-700 px-4 py-1.5 flex-shrink-0 transition
                        {{ !$attachments ? 'bg-gray-400 cursor-not-allowed' : 'bg-indigo-500 hover:bg-indigo-600' }}"
                        {{ !$attachments ? 'disabled' : '' }}
                    >
                        <span class="flex items-center">
                            <span>
                                <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </span>
                            <span class="ml-2">Send</span>
                        </span>
                    </button>
                </div>
        </div>
    </div>
</div>
