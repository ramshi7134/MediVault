<?php

namespace Tests\Feature;

use App\Models\MedicalRecord;
use App\Models\SharedRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShareTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_share_link(): void
    {
        $user = User::factory()->create();
        $record = MedicalRecord::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')
            ->postJson("/api/share/{$record->id}", ['expires_in_hours' => 24])
            ->assertStatus(201)
            ->assertJsonStructure(['data' => ['token', 'share_url', 'expires_at']]);
    }

    public function test_shared_record_is_accessible_via_token(): void
    {
        $user = User::factory()->create();
        $record = MedicalRecord::factory()->create(['user_id' => $user->id]);

        $shared = SharedRecord::create([
            'medical_record_id' => $record->id,
            'user_id'           => $user->id,
            'expires_at'        => Carbon::now()->addHours(24),
            'is_active'         => true,
        ]);

        $this->getJson("/api/shared/{$shared->token}")
            ->assertStatus(200)
            ->assertJsonPath('data.id', $record->id);
    }

    public function test_expired_share_link_returns_404(): void
    {
        $user = User::factory()->create();
        $record = MedicalRecord::factory()->create(['user_id' => $user->id]);

        $shared = SharedRecord::create([
            'medical_record_id' => $record->id,
            'user_id'           => $user->id,
            'expires_at'        => Carbon::now()->subHour(),
            'is_active'         => true,
        ]);

        $this->getJson("/api/shared/{$shared->token}")
            ->assertStatus(404);
    }
}
