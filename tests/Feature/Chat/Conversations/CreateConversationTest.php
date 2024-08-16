<?php

namespace Tests\Feature\Chat\Conversations;

use App\Livewire\CreateConversation;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateConversationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper function to create users
     */
    private function createUsers(array $emails)
    {
        return collect($emails)->map(fn($email) => User::factory()->create(['email' => $email]));
    }

    /**
     * Helper function to assert conversation details.
     */
    private function assertConversationDetails(Conversation $conversation, array $expectedUsers, array $unexpectedUsers, bool $isGroup)
    {
        $this->assertNotNull($conversation);
        $this->assertNotNull($conversation->profile);
        $this->assertEquals($isGroup, $conversation->is_group);
        $this->assertEquals(count($expectedUsers), $conversation->users->count());

        foreach ($expectedUsers as $user) {
            $this->assertTrue($conversation->users->contains($user));
        }

        foreach ($unexpectedUsers as $user) {
            $this->assertFalse($conversation->users->contains($user));
        }
    }

    public function test_create_private_conversation(): void
    {
        // Create users
        [$user1, $user2, $user3] = $this->createUsers(['user1@example.com', 'user2@example.com', 'user3@example.com']);

        // Authenticate as user1
        $this->actingAs($user1);

        // Create a private conversation
        Livewire::test(CreateConversation::class)
            ->call('createConversation', $user2->id);

        // Get and assert the private conversation
        $conversation = Conversation::where('is_group', false)->first();
        $this->assertConversationDetails($conversation, [$user1, $user2], [$user3], false);
    }

    public function test_create_group_conversation(): void
    {
        // Create users
        [$user1, $user2, $user3, $user4] = $this->createUsers(['user1@example.com', 'user2@example.com', 'user3@example.com', 'user4@example.com']);

        // Authenticate as user1
        $this->actingAs($user1);

        // Test Livewire component and create group conversation
        Livewire::test(CreateConversation::class)
            ->set('selectedUsers', [$user2, $user3])
            ->call('createGroupConversation');

        // Get and assert the group conversation
        $conversation = Conversation::where('is_group', true)->first();
        $this->assertConversationDetails($conversation, [$user1, $user2, $user3], [$user4], true);
    }
}
