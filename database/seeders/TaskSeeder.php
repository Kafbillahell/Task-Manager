<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('task')->insert([
      [
        'title' => 'Design Homepage Layout',
        'description' => 'Create wireframes and mockups for the new homepage design',
        'project_id' => 1,
        'assigned_to' => 1,
        'created_by' => 1,
        'status' => 'todo',
        'order' => 1,
        'likes_count' => 2,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'title' => 'Develop API Endpoints',
        'description' => 'Implement RESTful API for user authentication and tasks',
        'project_id' => 1,
        'assigned_to' => 2,
        'created_by' => 1,
        'status' => 'in_progress',
        'order' => 2,
        'likes_count' => 1,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'title' => 'Testing and QA',
        'description' => 'Perform unit and integration testing for all modules',
        'project_id' => 1,
        'assigned_to' => 3,
        'created_by' => 1,
        'status' => 'done',
        'order' => 3,
        'likes_count' => 0,
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ]);
  }
}
