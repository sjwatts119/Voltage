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
            $message = Message::create([
                'conversation_id' => $conversation1->id,
                'user_id' => $i % 2 == 0 ? $user1->id : $user2->id,
                'message' => 'Test message ' . ($i + 1),
            ]);
            // Mark the message as read by the other user
            $message->reads()->create([
                'user_id' => $i % 2 == 0 ? $user2->id : $user1->id,
                'read_at' => now(),
            ]);
        }

        //private conversation between user 1 and 2
        $conversation2 = Conversation::create([
            'is_group' => false,
        ]);
        $conversation2->users()->attach([$user1->id, $user2->id]);
        for ($i = 0; $i < 15; $i++) {
            $message = Message::create([
                'conversation_id' => $conversation2->id,
                'user_id' => $i % 2 == 0 ? $user1->id : $user2->id,
                'message' => 'Test message ' . ($i + 1),
            ]);
            // Mark the message as NOT read by the other user
            $message->reads()->create([
                'user_id' => $i % 2 == 0 ? $user2->id : $user1->id,
            ]);

        }
    }
}
