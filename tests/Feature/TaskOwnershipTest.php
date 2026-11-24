<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskOwnershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_tasks(): void
    {
        $response = $this->getJson('/api/tasks');

        $response->assertStatus(401);
    }

    public function test_user_cannot_view_another_users_task(): void
    {
        $user1 = \App\Models\User::factory()->create();
        $user2 = \App\Models\User::factory()->create();

        $task = $user2->tasks()->create([
            'title' => 'Private Task',
            'description' => 'This belongs to user 2',
            'completed' => false,
        ]);

        $response = $this->actingAs($user1)
            ->getJson('/api/tasks/' . $task->id);

        $response->assertStatus(404);
    }

    public function test_user_cannot_update_another_users_task(): void
    {
        $user1 = \App\Models\User::factory()->create();
        $user2 = \App\Models\User::factory()->create();

        $task = $user2->tasks()->create([
            'title' => 'Private Task',
            'description' => 'Original description',
            'completed' => false,
        ]);

        $response = $this->actingAs($user1)
            ->putJson('/api/tasks/' . $task->id, [
                'title' => 'Unauthorized Update',
                'description' => 'Changed by another user',
                'completed' => true,
            ]);

        $response->assertStatus(404);
    }

    public function test_user_cannot_delete_another_users_task(): void
    {
        $user1 = \App\Models\User::factory()->create();
        $user2 = \App\Models\User::factory()->create();

        $task = $user2->tasks()->create([
            'title' => 'Private Task',
            'description' => 'This belongs to user 2',
            'completed' => false,
        ]);

        $response = $this->actingAs($user1)
            ->deleteJson('/api/tasks/' . $task->id);

        $response->assertStatus(404);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
        ]);
    }
}
