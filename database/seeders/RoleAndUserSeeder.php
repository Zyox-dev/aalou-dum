<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Workshop;
use App\Models\Instructor;
use App\Models\CourseSyllabus;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Admin']);
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@navyajewellers.com',
            'password' => Hash::make('1234567890'),
        ]);
        $admin->roles()->attach($adminRole);
    }
}
