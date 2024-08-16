<?php

namespace Tests\Feature\Chat\Messages;

use App\Livewire\Chat;
use App\Livewire\CreateConversation;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    private function createUsers(array $emails)
    {
        return collect($emails)->map(fn($email) => User::factory()->create(['email' => $email]));
    }

    public function createGroupConversation(array $emails = ['user1@example.com', 'user2@example.com']): Conversation
    {
        // Create users based on the provided emails
        [$user1, $user2] = $this->createUsers($emails);

        // Authenticate as user1
        $this->actingAs($user1);

        // Test Livewire component and create group conversation
        Livewire::test(CreateConversation::class)
            ->set('selectedUsers', [$user2])
            ->call('createGroupConversation');

        // Get and assert the group conversation
        return Conversation::where('is_group', true)->first();
    }

    public function test_conversation_can_be_loaded(): void
    {
        // Create group conversation
        $conversation = $this->createGroupConversation();

        // Authenticate as user1
        $this->actingAs($conversation->users->first());

        // Test Livewire component and load conversation
        $component = Livewire::test(Chat::class)
            ->call('loadConversation', $conversation->id)
            ->assertSet('activeConversation.id', $conversation->id);
    }

    public function test_selected_conversation_can_be_switched(): void
    {
        // Create first group conversation with different users
        $conversation1 = $this->createGroupConversation(['user1@example.com', 'user2@example.com']);

        // Create second group conversation with different users
        $conversation2 = $this->createGroupConversation(['user3@example.com', 'user4@example.com']);

        // Authenticate as user1
        $this->actingAs($conversation1->users->first());

        // Test Livewire component and load conversation
        $component = Livewire::test(Chat::class)
            ->call('loadConversation', $conversation1->id)
            ->assertSet('activeConversation.id', $conversation1->id);

        // Switch to another conversation
        $component->call('loadConversation', $conversation2->id)
            ->assertSet('activeConversation.id', $conversation2->id);
    }

    public function test_selected_conversation_can_be_closed(): void
    {
        // Create group conversation
        $conversation = $this->createGroupConversation();

        // Authenticate as user1
        $this->actingAs($conversation->users->first());

        // Test Livewire component and load conversation
        $component = Livewire::test(Chat::class)
            ->call('loadConversation', $conversation->id)
            ->assertSet('activeConversation.id', $conversation->id);

        // Close the conversation
        $component->call('closeChat')
            ->assertSet('activeConversation', null)
            ->assertSet('messages', null)
            ->assertSet('messageInput', null);
    }

    public function test_user_message_can_be_sent(): void
    {
        // Create group conversation
        $conversation = $this->createGroupConversation();

        // Authenticate as user1
        $this->actingAs($conversation->users->first());

        // Test Livewire component and send message
        Livewire::test(Chat::class)
            ->call('loadConversation', $conversation->id)
            ->set('messageInput', 'Hello World')
            ->call('sendMessage');

        // Get and assert the message
        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'message' => 'Hello World',
            'type' => 'user',
        ]);
    }

    public function test_sent_message_is_marked_as_read(): void
    {
        // Create group conversation
        $conversation = $this->createGroupConversation();

        // Authenticate as user1
        $this->actingAs($conversation->users->first());

        // Test Livewire component and send message
        Livewire::test(Chat::class)
            ->call('loadConversation', $conversation->id)
            ->set('messageInput', 'Hello World')
            ->call('sendMessage');

        // Get and assert the message
        $message = $conversation->messages->first();
        $this->assertTrue($message->isRead());
    }
}
