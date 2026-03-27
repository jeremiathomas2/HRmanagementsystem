<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $employees = [];
        $employeeId = 1;

        // HR Management System Employees (Company ID: 1)
        $hrEmployees = [
            ['John', 'Michael', 'Smith', 'john.smith@hrsystem.co.tz', '+255 754 123 456', '1990-05-15', 'male', 'married', '1990123456789012', 'P123456', 'citizen', null, null, 'permanent', '2020-01-15', '2020-04-15', null, null, 'HR Manager', 'Oversee HR operations', 'CEO', 'Full-time', 2500000, '{"housing": 500000, "transport": 300000}', '{"health": "Family", "bonus": "Annual"}', 'CRDB Bank', '01JH1234567', '101234567890', 'NSSF001234', 'WCF001234', 'Kinondoni, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11101', 'Mary Smith', '+255 754 987 654', 'Wife'],
            ['Sarah', 'Elizabeth', 'Johnson', 'sarah.johnson@hrsystem.co.tz', '+255 754 234 567', '1988-08-22', 'female', 'single', '1988082234567890', 'P234567', 'citizen', null, null, 'permanent', '2019-03-10', '2019-06-10', null, null, 'Payroll Officer', 'Manage payroll processing', 'HR Manager', 'Full-time', 1800000, '{"transport": 250000}', '{"health": "Individual", "pension": "Yes"}', 'NMB Bank', '01SJ2345678', '102345678901', 'NSSF002345', 'WCF002345', 'Ubungo, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11102', 'Robert Johnson', '+255 754 876 543', 'Father'],
            ['David', 'James', 'Wilson', 'david.wilson@hrsystem.co.tz', '+255 754 345 678', '1992-12-10', 'male', 'married', '1992121034567890', 'P345678', 'citizen', null, null, 'permanent', '2021-06-01', '2021-09-01', null, null, 'Compliance Officer', 'Ensure legal compliance', 'HR Manager', 'Full-time', 2200000, '{"housing": 400000, "transport": 300000}', '{"health": "Family", "training": "Annual"}', 'CRDB Bank', '01DW3456789', '103456789012', 'NSSF003456', 'WCF003456', 'Masaki, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11103', 'Jennifer Wilson', '+255 754 765 432', 'Wife'],
            ['Emily', 'Rose', 'Brown', 'emily.brown@hrsystem.co.tz', '+255 754 456 789', '1991-03-18', 'female', 'single', '1991031845678901', 'P456789', 'citizen', null, null, 'permanent', '2020-09-15', '2021-03-15', null, null, 'Recruitment Specialist', 'Manage recruitment process', 'HR Manager', 'Full-time', 1600000, '{"transport": 200000}', '{"health": "Individual", "leave": "24 days"}', 'NMB Bank', '01EB4567890', '104567890123', 'NSSF004567', 'WCF004567', 'Mikocheni, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11104', 'Thomas Brown', '+255 754 654 321', 'Father'],
        ];

        foreach ($hrEmployees as $emp) {
            $employees[] = $this->createEmployee($emp, 1, $employeeId++);
        }

        // Tanzania Cigarette Company Employees (Company ID: 2)
        $tccEmployees = [
            ['Ali', 'Hassan', 'Mkapa', 'ali.mkapa@tcc.co.tz', '+255 754 567 890', '1985-06-25', 'male', 'married', '1985062556789012', 'P567890', 'citizen', null, null, 'permanent', '2018-02-01', '2018-05-01', null, null, 'Production Manager', 'Oversee tobacco production', 'Operations Director', 'Full-time', 3500000, '{"housing": 800000, "transport": 400000, "meals": 150000}', '{"health": "Family", "bonus": "Performance"}', 'CRDB Bank', '01AH5678901', '105678901234', 'NSSF005678', 'WCF005678', 'Industrial Area, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11105', 'Fatuma Mkapa', '+255 754 543 210', 'Wife'],
            ['Grace', 'Michael', 'Mwangi', 'grace.mwangi@tcc.co.tz', '+255 754 678 901', '1987-11-30', 'female', 'married', '1987113067890123', 'P678901', 'citizen', null, null, 'permanent', '2019-07-15', '2019-10-15', null, null, 'Quality Assurance Manager', 'Ensure product quality', 'Production Manager', 'Full-time', 2800000, '{"housing": 600000, "transport": 350000}', '{"health": "Family", "training": "Quarterly"}', 'NMB Bank', '01GM6789012', '106789012345', 'NSSF006789', 'WCF006789', 'Kariakoo, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11106', 'Joseph Mwangi', '+255 754 432 109', 'Husband'],
            ['Peter', 'John', 'Kimaro', 'peter.kimaro@tcc.co.tz', '+255 754 789 012', '1990-02-14', 'male', 'single', '1990021478901234', 'P789012', 'citizen', null, null, 'contract', '2020-11-01', null, null, null, 'Machine Operator', 'Operate production machinery', 'Production Supervisor', 'Contract', 1200000, '{"transport": 200000}', '{"health": "Individual", "overtime": "Available"}', 'CRDB Bank', '01PK7890123', '107890123456', 'NSSF007890', 'WCF007890', 'Temeke, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11107', 'Anna Kimaro', '+255 754 321 098', 'Mother'],
            ['Rehema', 'Abdallah', 'Said', 'rehema.said@tcc.co.tz', '+255 754 890 123', '1993-07-08', 'female', 'married', '1993070889012345', 'P890123', 'citizen', null, null, 'permanent', '2021-04-10', '2021-10-10', null, null, 'HR Administrator', 'Handle HR administration', 'HR Manager', 'Full-time', 1500000, '{"transport": 250000}', '{"health": "Family", "leave": "21 days"}', 'NMB Bank', '01RS8901234', '108901234567', 'NSSF008901', 'WCF008901', 'Mbagala, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11108', 'Mohammed Said', '+255 754 210 987', 'Husband'],
        ];

        foreach ($tccEmployees as $emp) {
            $employees[] = $this->createEmployee($emp, 2, $employeeId++);
        }

        // Tanzania Breweries Limited Employees (Company ID: 3)
        $tblEmployees = [
            ['Michael', 'George', 'Mushi', 'michael.mushi@tbl.co.tz', '+255 754 901 234', '1984-09-20', 'male', 'married', '1984092090123456', 'P901234', 'citizen', null, null, 'permanent', '2017-05-15', '2017-08-15', null, null, 'Brew Master', 'Oversee brewing process', 'Operations Director', 'Full-time', 4000000, '{"housing": 1000000, "transport": 500000, "meals": 200000}', '{"health": "Family", "bonus": "Annual", "car": "Company"}', 'CRDB Bank', '01MM9012345', '109012345678', 'NSSF009012', 'WCF009012', 'Mikocheni, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11109', 'Grace Mushi', '+255 754 109 876', 'Wife'],
            ['Joyce', 'Paul', 'Masanja', 'joyce.masanja@tbl.co.tz', '+255 754 012 345', '1986-04-12', 'female', 'single', '1986041201234567', 'P012345', 'citizen', null, null, 'permanent', '2018-08-20', '2019-02-20', null, null, 'Marketing Manager', 'Lead marketing initiatives', 'Sales Director', 'Full-time', 3200000, '{"housing": 700000, "transport": 400000}', '{"health": "Individual", "bonus": "Performance", "phone": "Company"}', 'NMB Bank', '01JM0123456', '110123456789', 'NSSF010123', 'WCF010123', 'Masaki, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11110', 'Paul Masanja', '+255 754 098 765', 'Father'],
            ['Frank', 'Charles', 'Mtega', 'frank.mtega@tbl.co.tz', '+255 754 123 456', '1991-10-05', 'male', 'married', '1991100512345678', 'P123456', 'citizen', null, null, 'permanent', '2019-12-01', '2020-06-01', null, null, 'Sales Representative', 'Manage sales operations', 'Sales Manager', 'Full-time', 1800000, '{"transport": 300000, "commission": "Variable"}', '{"health": "Family", "car": "Company", "phone": "Company"}', 'CRDB Bank', '01FM1234567', '111234567890', 'NSSF011234', 'WCF011234', 'Kinondoni, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11111', 'Anna Mtega', '+255 754 987 654', 'Wife'],
            ['Esther', 'David', 'Kileo', 'esther.kileo@tbl.co.tz', '+255 754 234 567', '1992-06-28', 'female', 'single', '1992062823456789', 'P234567', 'citizen', null, null, 'probation', '2021-09-01', null, null, null, 'Quality Control Technician', 'Test product quality', 'QA Manager', 'Probation', 1000000, '{"transport": 150000}', '{"health": "Individual", "training": "On-job"}', 'NMB Bank', '01EK2345678', '112345678901', 'NSSF012345', 'WCF012345', 'Ubungo, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11112', 'David Kileo', '+255 754 876 543', 'Father'],
        ];

        foreach ($tblEmployees as $emp) {
            $employees[] = $this->createEmployee($emp, 3, $employeeId++);
        }

        // NMB Bank Employees (Company ID: 4)
        $nmbEmployees = [
            ['James', 'Peter', 'Mwalimu', 'james.mwalimu@nmbbank.co.tz', '+255 754 345 678', '1983-12-15', 'male', 'married', '1983121534567890', 'P345678', 'citizen', null, null, 'permanent', '2016-03-10', '2016-09-10', null, null, 'Branch Manager', 'Manage bank branch', 'Regional Manager', 'Full-time', 4500000, '{"housing": 1200000, "transport": 600000, "meals": 250000}', '{"health": "Family", "bonus": "Performance", "car": "Company"}', 'NMB Bank', '01JM3456789', '113456789012', 'NSSF013456', 'WCF013456', 'Ohio Street, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11113', 'Mary Mwalimu', '+255 754 765 432', 'Wife'],
            ['Agnes', 'Michael', 'Mcharo', 'agnes.mcharo@nmbbank.co.tz', '+255 754 456 789', '1987-08-03', 'female', 'married', '1987080345678901', 'P456789', 'citizen', null, null, 'permanent', '2018-11-15', '2019-05-15', null, null, 'Senior Credit Officer', 'Evaluate loan applications', 'Credit Manager', 'Full-time', 2800000, '{"housing": 800000, "transport": 400000}', '{"health": "Family", "training": "Annual", "phone": "Company"}', 'CRDB Bank', '01AM4567890', '114567890123', 'NSSF014567', 'WCF014567', 'Kaweya Street, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11114', 'Michael Mcharo', '+255 754 654 321', 'Husband'],
            ['Robert', 'John', 'Mlay', 'robert.mlay@nmbbank.co.tz', '+255 754 567 890', '1990-01-22', 'male', 'single', '1990012256789012', 'P567890', 'citizen', null, null, 'permanent', '2019-07-01', '2020-01-01', null, null, 'Relationship Manager', 'Manage client relationships', 'Branch Manager', 'Full-time', 2200000, '{"transport": 350000, "commission": "Variable"}', '{"health": "Individual", "phone": "Company", "laptop": "Company"}', 'NMB Bank', '01RM5678901', '115678901234', 'NSSF015678', 'WCF015678', 'Upanga, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11115', 'Grace Mlay', '+255 754 543 210', 'Mother'],
            ['Sophia', 'Abdallah', 'Kassim', 'sophia.kassim@nmbbank.co.tz', '+255 754 678 901', '1992-09-10', 'female', 'married', '1992091067890123', 'P678901', 'citizen', null, null, 'permanent', '2020-02-15', '2020-08-15', null, null, 'Teller', 'Process customer transactions', 'Operations Manager', 'Full-time', 1200000, '{"transport": 200000}', '{"health": "Family", "uniform": "Provided"}', 'CRDB Bank', '01SK6789012', '116789012345', 'NSSF016789', 'WCF016789', 'Mikocheni, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11116', 'Abdallah Kassim', '+255 754 432 109', 'Husband'],
        ];

        foreach ($nmbEmployees as $emp) {
            $employees[] = $this->createEmployee($emp, 4, $employeeId++);
        }

        // CRDB Bank Employees (Company ID: 5)
        $crdbEmployees = [
            ['Hassan', 'Ali', 'Mwanga', 'hassan.mwanga@crdbbank.co.tz', '+255 754 789 012', '1982-07-18', 'male', 'married', '1982071878901234', 'P789012', 'citizen', null, null, 'permanent', '2015-09-20', '2016-03-20', null, null, 'Regional Manager', 'Oversee regional operations', 'Director of Operations', 'Full-time', 5000000, '{"housing": 1500000, "transport": 700000, "meals": 300000}', '{"health": "Family", "bonus": "Performance", "car": "Company"}', 'CRDB Bank', '01HM7890123', '117890123456', 'NSSF017890', 'WCF017890', 'Kaweya Street, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11117', 'Fatuma Mwanga', '+255 754 321 098', 'Wife'],
            ['Zainab', 'Mohammed', 'Juma', 'zainab.juma@crdbbank.co.tz', '+255 754 890 123', '1988-05-25', 'female', 'married', '1988052589012345', 'P890123', 'citizen', null, null, 'permanent', '2019-01-10', '2019-07-10', null, null, 'Head of IT', 'Manage IT infrastructure', 'CTO', 'Full-time', 3800000, '{"housing": 1000000, "transport": 500000}', '{"health": "Family", "training": "International", "laptop": "Company"}', 'NMB Bank', '01ZJ8901234', '118901234567', 'NSSF018901', 'WCF018901', 'Masaki, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11118', 'Mohammed Juma', '+255 754 210 987', 'Husband'],
            ['Thomas', 'George', 'Nyerere', 'thomas.nyerere@crdbbank.co.tz', '+255 754 901 234', '1991-03-08', 'male', 'single', '1991030890123456', 'P901234', 'citizen', null, null, 'permanent', '2020-06-15', '2020-12-15', null, null, 'Business Analyst', 'Analyze business requirements', 'IT Manager', 'Full-time', 2500000, '{"housing": 600000, "transport": 350000}', '{"health": "Individual", "training": "Annual", "phone": "Company"}', 'CRDB Bank', '01TN9012345', '119012345678', 'NSSF019012', 'WCF019012', 'Kinondoni, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11119', 'Anna Nyerere', '+255 754 109 876', 'Mother'],
            ['Aisha', 'Ramadhan', 'Mkenda', 'aisha.mkenda@crdbbank.co.tz', '+255 754 012 345', '1993-11-12', 'female', 'married', '1993111201234567', 'P012345', 'citizen', null, null, 'permanent', '2021-03-01', '2021-09-01', null, null, 'Customer Service Officer', 'Handle customer inquiries', 'Branch Manager', 'Full-time', 1400000, '{"transport": 200000}', '{"health": "Family", "uniform": "Provided"}', 'NMB Bank', '01AM0123456', '120123456789', 'NSSF020123', 'WCF020123', 'Ubungo, Dar es Salaam', 'Dar es Salaam', 'Dar es Salaam', '11120', 'Ramadhan Mkenda', '+255 754 987 654', 'Husband'],
        ];

        foreach ($crdbEmployees as $emp) {
            $employees[] = $this->createEmployee($emp, 5, $employeeId++);
        }

        // Add more companies with fewer employees for demonstration
        $this->addCompanyEmployees(6, 'Tigo Tanzania', $employees, $employeeId, 5); // Tigo
        $this->addCompanyEmployees(7, 'Vodacom Tanzania', $employees, $employeeId, 6); // Vodacom
        $this->addCompanyEmployees(8, 'Airtel Tanzania', $employees, $employeeId, 4); // Airtel
        $this->addCompanyEmployees(9, 'TANESCO', $employees, $employeeId, 8); // TANESCO
        $this->addCompanyEmployees(10, 'Twiga Cement', $employees, $employeeId, 3); // Twiga
        $this->addCompanyEmployees(11, 'Azam Tanzania', $employees, $employeeId, 7); // Azam
        $this->addCompanyEmployees(12, 'Yara Tanzania', $employees, $employeeId, 2); // Yara

        DB::table('employees')->insert($employees);
    }

    private function createEmployee($data, $companyId, $employeeId)
    {
        return [
            'id' => $employeeId,
            'company_id' => $companyId,
            'department_id' => rand(1, 10), // Assuming departments exist
            'employee_number' => 'EMP' . str_pad($employeeId, 6, '0', STR_PAD_LEFT),
            'first_name' => $data[0],
            'middle_name' => $data[1],
            'last_name' => $data[2],
            'email' => $data[3],
            'phone' => $data[4],
            'date_of_birth' => $data[5],
            'gender' => $data[6],
            'marital_status' => $data[7],
            'national_id' => $data[8],
            'passport_number' => $data[9],
            'citizenship' => $data[10],
            'work_permit_number' => $data[11],
            'work_permit_expiry' => $data[12] ? Carbon::parse($data[12])->format('Y-m-d') : null,
            'employment_category' => $data[13],
            'hire_date' => $data[14],
            'confirmation_date' => $data[15],
            'termination_date' => $data[16],
            'termination_reason' => $data[17],
            'job_title' => $data[18],
            'job_description' => $data[19],
            'reporting_to' => $data[20],
            'employment_type' => $data[21],
            'basic_salary' => $data[22],
            'allowances' => $data[23],
            'benefits' => $data[24],
            'bank_name' => $data[25],
            'bank_account' => $data[26],
            'tax_number' => $data[27],
            'nssf_number' => $data[28],
            'wcf_number' => $data[29],
            'address' => $data[30],
            'city' => $data[31],
            'region' => $data[32],
            'postal_code' => $data[33],
            'emergency_contact_name' => $data[34],
            'emergency_contact_phone' => $data[35],
            'emergency_contact_relationship' => $data[36],
            'medical_information' => json_encode(['blood_type' => ['A+', 'B+', 'O+', 'AB+'][rand(0, 3)], 'allergies' => 'None', 'conditions' => 'None']),
            'dependents' => json_encode(['spouse' => $data[7] === 'married', 'children' => rand(0, 3)]),
            'education_history' => json_encode([['degree' => 'Bachelor', 'field' => 'Business', 'year' => rand(2010, 2020)]]),
            'employment_history' => json_encode([['company' => 'Previous Company', 'position' => 'Previous Role', 'years' => rand(1, 5)]]),
            'skills' => json_encode(['Communication', 'Leadership', 'Technical Skills']),
            'certifications' => json_encode(['Professional Certification']),
            'languages' => json_encode(['English', 'Swahili']),
            'is_active' => true,
            'is_on_probation' => $data[13] === 'probation',
            'probation_end_date' => $data[13] === 'probation' ? Carbon::parse($data[14])->addMonths(6)->format('Y-m-d') : null,
            'last_login' => now()->subHours(rand(1, 24)),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function addCompanyEmployees($companyId, $companyName, &$employees, &$employeeId, $count)
    {
        $positions = [
            'Manager', 'Supervisor', 'Specialist', 'Coordinator', 'Officer', 
            'Technician', 'Administrator', 'Analyst', 'Consultant', 'Executive'
        ];
        
        $firstNames = ['John', 'Mary', 'James', 'Sarah', 'Michael', 'Jennifer', 'David', 'Lisa', 'Robert', 'Patricia'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];

        for ($i = 0; $i < $count; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $position = $positions[array_rand($positions)];
            
            $employees[] = [
                'id' => $employeeId,
                'company_id' => $companyId,
                'department_id' => rand(1, 10),
                'employee_number' => 'EMP' . str_pad($employeeId, 6, '0', STR_PAD_LEFT),
                'first_name' => $firstName,
                'middle_name' => '',
                'last_name' => $lastName,
                'email' => strtolower($firstName . '.' . $lastName) . '@' . strtolower(str_replace(' ', '', $companyName)) . '.co.tz',
                'phone' => '+255 754 ' . rand(100, 999) . ' ' . rand(100, 999),
                'date_of_birth' => now()->subYears(rand(22, 55))->format('Y-m-d'),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'marital_status' => ['single', 'married', 'divorced'][rand(0, 2)],
                'national_id' => rand(1980, 2000) . str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT),
                'passport_number' => null,
                'citizenship' => 'citizen',
                'work_permit_number' => null,
                'work_permit_expiry' => null,
                'employment_category' => ['permanent', 'contract', 'probation'][rand(0, 2)],
                'hire_date' => now()->subYears(rand(0, 5))->subMonths(rand(0, 11))->format('Y-m-d'),
                'confirmation_date' => null,
                'termination_date' => null,
                'termination_reason' => null,
                'job_title' => $position,
                'job_description' => 'Responsible for ' . strtolower($position) . ' duties',
                'reporting_to' => 'Department Head',
                'employment_type' => 'Full-time',
                'basic_salary' => rand(800000, 4000000),
                'allowances' => json_encode(['transport' => rand(100000, 500000)]),
                'benefits' => json_encode(['health' => 'Individual']),
                'bank_name' => ['CRDB Bank', 'NMB Bank'][rand(0, 1)],
                'bank_account' => '01' . strtoupper(substr($firstName, 0, 2) . substr($lastName, 0, 2)) . rand(1000000, 9999999),
                'tax_number' => 'TIN' . rand(100000000, 999999999),
                'nssf_number' => 'NSSF' . rand(100000, 999999),
                'wcf_number' => 'WCF' . rand(100000, 999999),
                'address' => 'Dar es Salaam, Tanzania',
                'city' => 'Dar es Salaam',
                'region' => 'Dar es Salaam',
                'postal_code' => '11101',
                'emergency_contact_name' => 'Family Member',
                'emergency_contact_phone' => '+255 754 ' . rand(100, 999) . ' ' . rand(100, 999),
                'emergency_contact_relationship' => 'Family',
                'medical_information' => json_encode(['blood_type' => ['A+', 'B+', 'O+', 'AB+'][rand(0, 3)]]),
                'dependents' => json_encode(['children' => rand(0, 3)]),
                'education_history' => json_encode([['degree' => 'Bachelor', 'field' => 'Business', 'year' => rand(2010, 2020)]]),
                'employment_history' => json_encode([['company' => 'Previous Company', 'position' => 'Previous Role', 'years' => rand(1, 5)]]),
                'skills' => json_encode(['Communication', 'Leadership']),
                'certifications' => json_encode(['Professional Certification']),
                'languages' => json_encode(['English', 'Swahili']),
                'is_active' => true,
                'is_on_probation' => false,
                'probation_end_date' => null,
                'last_login' => now()->subHours(rand(1, 24)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $employeeId++;
        }
    }
}
