<?php
namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default roles
        $roles = [
            ['name' => 'admin', 'description' => 'Administrador del sistema'],
            ['name' => 'editor', 'description' => 'Editor de contenido'],
            ['name' => 'user', 'description' => 'Usuario regular']
        ];
        
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
