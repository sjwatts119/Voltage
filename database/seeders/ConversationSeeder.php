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
        $user1 = User::where('email', 'sam@example.com')->first();
        $user2 = User::where('email', 'test@example.com')->first();

        $conversation = Conversation::create([
            'name' => 'Test Conversation',
            'is_group' => false,
        ]);

        $conversation->users()->attach([$user1->id, $user2->id]);

        for ($i = 0; $i < 5; $i++) {
            Message::create([
                'conversation_id' => $conversation->id,
                'user_id' => $i % 2 == 0 ? $user1->id : $user2->id,
                'message' => 'Test message ' . ($i + 1),
            ]);
        }
    }
}
