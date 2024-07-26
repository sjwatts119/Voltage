<?php

namespace App\Livewire;

use App\Events\CreatedConversation;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use LivewireUI\Modal\ModalComponent;

class CreateConversation extends ModalComponent
{
    public $search = '';
    public $chatType;
    public $selectedUsers = [];
    public $selectedUserIds = [];
    public $count;

    public static function modalMaxWidth(): string
    {
        return '6xl';
    }

    public function mount() : void
    {
        $this->chatType = 'start';
        $this->count = 0;
    }

    public function selectChatType($type)
    {
        $this->chatType = $type;
    }

    public function getSelectedIds() : void
    {
        // Extract the IDs from the selectedUsers array
        $this->selectedUserIds = array_map(function ($user) {
            return $user->id;
        }, $this->selectedUsers);
    }

    public function addUser($userId) : void
    {
        if ($userId === auth()->id()) {
            return;
        }

        $user = User::find($userId);

        $this->selectedUsers[] = $user;

        $this->getSelectedIds();
    }


    public function removeUser($userId) : void
    {
        $this->selectedUsers = array_filter($this->selectedUsers, function ($user) use ($userId) {
            return $user->id !== $userId;
        });

        $this->getSelectedIds();
    }

    public function createGroupConversation() : void
    {
        // Is there a user selected?
        if(count($this->selectedUsers) === 0) {
            return;
        }

        // Create a new group conversation and attach the selected users
        $conversation = auth()->user()->conversations()->create([
            'is_group' => true
        ]);
        foreach($this->selectedUsers as $user) {
            $conversation->users()->attach($user);
        }

        // Dispatch CreatedChat event to pusher
        CreatedConversation::dispatch($conversation);

        $this->dispatch('conversation.open', $conversation->id);

        // Close the modal
        $this->dispatch('closeModal');
    }

    public function createConversation($userId) : void
    {
        // Check if a non-group conversation already exists between the two users
        $existingConversation = auth()->user()->conversations()
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->where('is_group', false)
            ->first();

        if($existingConversation) {
            // Fire an event to open the conversation.
            $this->dispatch('conversation.open', $existingConversation->id);

            $this->closeModal();
        }
        else {
            // Is the user trying to create a conversation with themselves? Shouldn't be possible but just in case
            if($userId == auth()->id()) {
                return;
            }

            $newConversation = Conversation::create(['is_group' => false]);
            $newConversation->users()->attach([auth()->id(), $userId]);

            // Dispatch CreatedChat event to pusher
            CreatedConversation::dispatch($newConversation);

            // Fire an event to open the conversation.
            $this->dispatch('conversation.open', $newConversation->id);

            // Close the modal
            $this->dispatch('closeModal');
        }

        // Fire an event with target user id to create the conversation.
        $this->dispatch('conversation.create', $userId);
    }

    public function render()
    {
        $results = [];

        if(strlen($this->search) > 0) {
            $results = User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('username', 'like', '%' . $this->search . '%')
                ->limit(10)
                ->get();

            // Exclude the current user from the results
            $results = $results->filter(function ($user) {
                return $user->id !== auth()->id();
            });
        }

        return view('livewire.create-conversation', [
            'results' => $results
        ]);
    }
}


