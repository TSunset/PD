<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_is_available(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_guest_cannot_open_user_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_user_cannot_open_admin_panel(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertForbidden();
    }

    public function test_user_cannot_download_foreign_contract(): void
    {
        $owner = User::factory()->create();
        $foreignUser = User::factory()->create();
        $course = Course::factory()->create();

        $order = Order::create([
            'user_id' => $owner->id,
            'course_id' => $course->id,
            'full_name' => 'Иван Иванов',
            'email' => 'ivan@example.com',
            'status' => 'documents_ready',
            'contract_pdf_path' => 'contracts/test.pdf',
            'student_csv_path' => 'csv/student_order_1.csv',
            'agreement_accepted' => true,
        ]);

        $response = $this->actingAs($foreignUser)->get("/orders/{$order->id}/download-contract");

        $response->assertForbidden();
    }
}
