<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::where('email', 'test@example.com')->first();
        $user2 = User::where('email', 'sam@example.com')->first();
        $user3 = User::where('email', '1@example.com')->first();
        $user4 = User::where('email', '2@example.com')->first();

        //private conversation between user 1 and 2
        $conversation1 = Conversation::create([
            'is_group' => false,
        ]);
        $conversation1->users()->attach([$user1->id, $user2->id]);
        for ($i = 0; $i < 20; $i++) {
            Message::create([
                'conversation_id' => $conversation1->id,
                'user_id' => $i % 2 == 0 ? $user1->id : $user2->id,
                'message' => 'Test message ' . ($i + 1),
            ]);
        }

        //private conversation between user 2 and 3
        $conversation2 = Conversation::create([
            'is_group' => false,
        ]);
        $conversation2->users()->attach([$user2->id, $user3->id]);
        for ($i = 0; $i < 15; $i++) {
            Message::create([
                'conversation_id' => $conversation2->id,
                'user_id' => $i % 2 == 0 ? $user2->id : $user3->id,
                'message' => 'Test message ' . ($i + 1),
            ]);
        }

        //group convo with user 2, 3 and 4
        $conversation3 = Conversation::create([
            'is_group' => true,
        ]);
        $conversation3->users()->attach([$user2->id, $user3->id, $user4->id]);
        for ($i = 0; $i < 10; $i++) {
            Message::create([
                'conversation_id' => $conversation3->id,
                'user_id' => $i % 3 == 0 ? $user2->id : ($i % 3 == 1 ? $user3->id : $user4->id),
                'message' => 'Test message ' . ($i + 1),
            ]);
        }

        //group convo with user 1, 2, 3 and 4 with a name
        $conversation4 = Conversation::create([
            'name' => 'Group chat',
            'is_group' => true,
        ]);
        $conversation4->users()->attach([$user1->id, $user2->id, $user3->id, $user4->id]);
        for ($i = 0; $i < 15; $i++) {
            Message::create([
                'conversation_id' => $conversation4->id,
                'user_id' => $i % 4 == 0 ? $user1->id : ($i % 4 == 1 ? $user2->id : ($i % 4 == 2 ? $user3->id : $user4->id)),
                'message' => 'Test message ' . ($i + 1),
            ]);
        }
    }
}
