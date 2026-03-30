<?php

namespace Database\Seeders;

use App\Models\FamilyMember;
use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name'        => 'Rahul Sharma',
            'email'       => 'rahul@example.com',
            'phone'       => '+919876543210',
            'password'    => Hash::make('password'),
            'blood_group' => 'O+',
            'gender'      => 'male',
            'address'     => '12, MG Road, Bangalore, Karnataka 560001',
        ]);

        $mother = FamilyMember::create([
            'user_id'      => $user->id,
            'name'         => 'Sunita Sharma',
            'relationship' => 'mother',
            'blood_group'  => 'A+',
            'gender'       => 'female',
        ]);

        MedicalRecord::create([
            'user_id'       => $user->id,
            'title'         => 'Annual Health Check-up',
            'hospital_name' => 'Apollo Hospitals, Bangalore',
            'doctor_name'   => 'Dr. Priya Menon',
            'visit_date'    => now()->subMonths(3),
            'document_type' => 'report',
            'file_path'     => 'medical-records/sample.pdf',
            'ocr_status'    => 'completed',
            'tags'          => ['checkup', 'annual'],
        ]);

        MedicalRecord::create([
            'user_id'            => $user->id,
            'family_member_id'   => $mother->id,
            'title'              => 'Diabetic Consultation',
            'hospital_name'      => 'Fortis Hospital, Bangalore',
            'doctor_name'        => 'Dr. Rajan Iyer',
            'visit_date'         => now()->subMonths(1),
            'document_type'      => 'prescription',
            'file_path'          => 'medical-records/sample2.pdf',
            'ocr_status'         => 'completed',
            'tags'               => ['diabetes', 'prescription'],
        ]);
    }
}
