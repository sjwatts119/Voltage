<?php

namespace Tests\Feature\Chat\Conversations;

use App\Livewire\ChatInfo;
use App\Livewire\CreateConversation;
use App\Livewire\ManageConversationUsers;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ConversationProfileTest extends TestCase
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

    public function test_if_conversation_profile_renders() : void
    {
        // Create group conversation
        $conversation = $this->createGroupConversation();

        // Test Livewire component and render conversation profile
        Livewire::test(ChatInfo::class, ['conversation' => $conversation])
            ->assertSee($conversation->name)
            ->assertSee($conversation->users->first()->name);
    }

    public function test_user_can_rename_group_conversation(): void
    {
        // Create group conversation
        $conversation = $this->createGroupConversation();

        // Test Livewire component and rename group conversation
        Livewire::test(ChatInfo::class, ['conversation' => $conversation])
            ->set('newGroupName', 'New Group Name')
            ->call('saveGroupName');

        // Get the updated conversation
        $conversation = $conversation->fresh();

        // Assert the group conversation has been renamed
        $this->assertEquals('New Group Name', $conversation->name);
    }
}
