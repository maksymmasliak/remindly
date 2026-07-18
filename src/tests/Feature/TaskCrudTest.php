<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    // "Щасливий шлях" — усе працює як задумано

    public function test_authenticated_user_can_view_own_task_list(): void
    {
        $user = User::factory()->create();
        Task::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/tasks');

        $response->assertOk();
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->count() === 3;
        });
    }

    public function test_authenticated_user_can_create_task(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'Buy groceries',
            'description' => 'Milk, eggs, bread',
            'due_at' => now()->addDay()->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Buy groceries',
            'user_id' => $user->id,
        ]);
    }

    public function test_authenticated_user_can_view_single_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/tasks/{$task->id}");

        $response->assertOk();
        $response->assertViewIs('tasks.show');
    }

    public function test_authenticated_user_can_update_own_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id, 'title' => 'Old title']);

        $response = $this->actingAs($user)->put("/tasks/{$task->id}", [
            'title' => 'Updated title',
            'description' => $task->description,
            'due_at' => $task->due_at->format('Y-m-d H:i:s'),
            'is_completed' => true,
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated title',
            'is_completed' => true,
        ]);
    }

    public function test_authenticated_user_can_delete_own_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete("/tasks/{$task->id}");

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    // Відмова для неавторизованого доступу (гість)

    public function test_guest_cannot_view_task_list(): void
    {
        $response = $this->get('/tasks');

        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_create_task(): void
    {
        $response = $this->post('/tasks', [
            'title' => 'Sneaky task',
            'due_at' => now()->addDay()->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('tasks', ['title' => 'Sneaky task']);
    }

    // Валідація вхідних даних

    public function test_creating_task_requires_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'due_at' => now()->addDay()->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_creating_task_requires_future_due_date(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'Past task',
            'due_at' => now()->subDay()->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHasErrors('due_at');
        $this->assertDatabaseMissing('tasks', ['title' => 'Past task']);
    }

    public function test_creating_task_allows_empty_description(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'Task without description',
            'due_at' => now()->addDay()->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Task without description',
            'description' => null,
        ]);
    }

    // Авторизація на рівні об'єкта (IDOR) — найважливіші тести в файлі

    public function test_user_cannot_view_other_users_task(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($intruder)->get("/tasks/{$task->id}");

        $response->assertForbidden();
    }

    public function test_user_cannot_edit_other_users_task(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($intruder)->get("/tasks/{$task->id}/edit");

        $response->assertForbidden();
    }

    public function test_user_cannot_update_other_users_task(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $owner->id, 'title' => 'Original']);

        $response = $this->actingAs($intruder)->put("/tasks/{$task->id}", [
            'title' => 'Hacked title',
            'due_at' => $task->due_at->format('Y-m-d H:i:s'),
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Original',
        ]);
    }

    public function test_user_cannot_delete_other_users_task(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($intruder)->delete("/tasks/{$task->id}");

        $response->assertForbidden();
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function test_user_only_sees_own_tasks_in_list(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Task::factory()->count(2)->create(['user_id' => $user->id]);
        Task::factory()->count(5)->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->get('/tasks');

        $response->assertOk();
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->count() === 2;
        });
    }
}
