<?php

namespace Database\Factories;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MedicalRecord>
 */
class MedicalRecordFactory extends Factory
{
    protected $model = MedicalRecord::class;

    public function definition(): array
    {
        return [
            'user_id'       => User::factory(),
            'title'         => $this->faker->sentence(3),
            'hospital_name' => $this->faker->company() . ' Hospital',
            'doctor_name'   => 'Dr. ' . $this->faker->name(),
            'visit_date'    => $this->faker->dateTimeBetween('-2 years', 'now'),
            'document_type' => $this->faker->randomElement(['prescription', 'lab', 'invoice', 'report', 'other']),
            'file_path'     => 'medical-records/' . $this->faker->uuid() . '.pdf',
            'file_mime'     => 'application/pdf',
            'file_size'     => $this->faker->numberBetween(50000, 5000000),
            'ocr_status'    => 'pending',
            'tags'          => [],
        ];
    }
}
