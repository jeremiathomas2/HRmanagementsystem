<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        // Create departments for each company
        $companies = DB::table('companies')->pluck('id');
        
        $baseDepartments = [
            ['name' => 'Human Resources', 'code' => 'HR', 'description' => 'Manage employee relations and HR operations', 'type' => 'support'],
            ['name' => 'Finance', 'code' => 'FIN', 'description' => 'Handle financial operations and accounting', 'type' => 'support'],
            ['name' => 'Operations', 'code' => 'OPS', 'description' => 'Oversee daily business operations', 'type' => 'operational'],
            ['name' => 'Information Technology', 'code' => 'IT', 'description' => 'Manage IT infrastructure and systems', 'type' => 'support'],
            ['name' => 'Marketing', 'code' => 'MKT', 'description' => 'Handle marketing and sales activities', 'type' => 'operational'],
            ['name' => 'Administration', 'code' => 'ADM', 'description' => 'General administrative functions', 'type' => 'administrative'],
            ['name' => 'Legal & Compliance', 'code' => 'LGL', 'description' => 'Legal matters and regulatory compliance', 'type' => 'support'],
            ['name' => 'Customer Service', 'code' => 'CS', 'description' => 'Handle customer inquiries and support', 'type' => 'operational'],
            ['name' => 'Quality Assurance', 'code' => 'QA', 'description' => 'Ensure product and service quality', 'type' => 'support'],
            ['name' => 'Procurement', 'code' => 'PUR', 'description' => 'Manage purchasing and vendor relations', 'type' => 'support'],
        ];

        $departments = [];
        $departmentId = 1;

        foreach ($companies as $companyId) {
            foreach ($baseDepartments as $baseDept) {
                $departments[] = [
                    'id' => $departmentId++,
                    'company_id' => $companyId,
                    'name' => $baseDept['name'],
                    'code' => $baseDept['code'] . '-' . $companyId,
                    'description' => $baseDept['description'],
                    'parent_department_id' => null,
                    'manager_id' => null,
                    'type' => $baseDept['type'],
                    'employee_count' => rand(5, 50),
                    'budget' => rand(1000000, 10000000),
                    'cost_centers' => json_encode(['main' => $baseDept['code']]),
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('departments')->insert($departments);
    }
}
