<?php

namespace Tests\Feature\Chat\Conversations;

use App\Livewire\CreateConversation;
use App\Livewire\ManageConversationUsers;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ConversationUsersTest extends TestCase
{
    use RefreshDatabase;

    private function createUsers(array $emails)
    {
        return collect($emails)->map(fn($email) => User::factory()->create(['email' => $email]));
    }

    public function createGroupConversation(): Conversation
    {
        // Create users
        [$user1, $user2] = $this->createUsers(['user1@example.com', 'user2@example.com']);

        // Authenticate as user1
        $this->actingAs($user1);

        // Test Livewire component and create group conversation
        Livewire::test(CreateConversation::class)
            ->set('selectedUsers', [$user2])
            ->call('createGroupConversation');

        // Get and assert the group conversation
        return Conversation::where('is_group', true)->first();
    }

    public function test_add_user_to_group_conversation(): void
    {
        // Create group conversation
        $conversation = $this->createGroupConversation();

        // Create a new user
        $user3 = User::factory()->create(['email' => 'user3@example.com']);

        // Assert the group conversation starting with 2 users
        $this->assertEquals(2, $conversation->users->count());

        // Add user to group conversation
        Livewire::test(ManageConversationUsers::class, ['conversation' => $conversation])
            ->call('addToConversation', $user3->id);

        // Get the updated conversation
        $conversation = $conversation->fresh();

        // Assert the group conversation now has 3 users
        $this->assertEquals(3, $conversation->users->count());

        // Assert the group conversation contains the new user
        $this->assertTrue($conversation->users->contains($user3));
    }

    public function test_remove_user_from_group_conversation(): void
    {
        // Create group conversation
        $conversation = $this->createGroupConversation();

        // Get the second user
        $user2 = $conversation->users->last();

        // Assert the group conversation starts with 2 users
        $this->assertEquals(2, $conversation->users->count());

        // Remove user from group conversation
        Livewire::test(ManageConversationUsers::class, ['conversation' => $conversation])
            ->call('removeFromConversation', $user2->id);

        // Get the updated conversation
        $conversation = $conversation->fresh();

        // Assert the group conversation now has 1 user
        $this->assertEquals(1, $conversation->users->count());

        // Assert the group conversation does not contain the removed user
        $this->assertFalse($conversation->users->contains($user2));
    }
}