<?php

namespace Tests\Feature;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MedicalRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_medical_record(): void
    {
        Storage::fake('local');
        Queue::fake();

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/records/upload', [
                'title'         => 'Blood Test Report',
                'document_type' => 'lab',
                'hospital_name' => 'Apollo Hospital',
                'visit_date'    => '2024-01-15',
                'file'          => UploadedFile::fake()->create('test.pdf', 500, 'application/pdf'),
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'title', 'document_type', 'file_url']]);
    }

    public function test_user_can_list_records(): void
    {
        $user = User::factory()->create();
        MedicalRecord::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/records')
            ->assertStatus(200)
            ->assertJsonStructure(['data', 'meta']);
    }

    public function test_user_can_get_record(): void
    {
        $user = User::factory()->create();
        $record = MedicalRecord::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->getJson("/api/records/{$record->id}")
            ->assertStatus(200)
            ->assertJsonPath('data.id', $record->id);
    }

    public function test_user_cannot_access_other_users_record(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $record = MedicalRecord::factory()->create(['user_id' => $user2->id]);

        $this->actingAs($user1, 'sanctum')
            ->getJson("/api/records/{$record->id}")
            ->assertStatus(404);
    }

    public function test_user_can_delete_record(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();
        $record = MedicalRecord::factory()->create([
            'user_id'   => $user->id,
            'file_path' => 'medical-records/test.pdf',
        ]);

        $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/records/{$record->id}")
            ->assertStatus(200)
            ->assertJson(['message' => 'Record deleted.']);
    }
}
