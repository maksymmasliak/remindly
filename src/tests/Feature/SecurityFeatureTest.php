<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SecurityFeatureTest extends TestCase
{
    use RefreshDatabase;

    // Mass Assignment — юзер не може підмінити user_id при створенні таски

    public function test_user_cannot_spoof_user_id_on_task_creation(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user)->post('/tasks', [
            'title' => 'Spoofed task',
            'due_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'user_id' => $otherUser->id, // спроба підмінити власника
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Spoofed task',
            'user_id' => $user->id, // має належати реальному автору, не $otherUser
        ]);
    }

    // CSRF — middleware підключений до web-маршрутів tasks

    public function test_csrf_middleware_is_active_on_task_routes(): void
    {
        $middlewares = Route::getRoutes()->getByName('tasks.store')->middleware();

        $this->assertContains('web', $middlewares);
    }

    // Session Fixation — session ID змінюється після логіну

    public function test_session_id_regenerates_after_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $this->get('/login');
        $sessionIdBeforeLogin = session()->getId();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $sessionIdAfterLogin = session()->getId();

        $this->assertNotEquals($sessionIdBeforeLogin, $sessionIdAfterLogin);
    }

    // IDOR pair-test — контрольний позитивний тест поруч із негативним
    // (негативні вже є в TaskCrudTest, тут — явний позитивний контроль)

    public function test_user_can_view_own_task_after_creating_it(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get("/tasks/{$task->id}");

        $response->assertOk();
    }
}
