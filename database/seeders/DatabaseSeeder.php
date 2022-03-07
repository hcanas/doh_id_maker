<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $rows = fopen(storage_path('app/csv/regular1.csv'), 'r');

        while (($row = fgetcsv($rows, 255, ',')) !== false) {
            Employee::create([
                'given_name' => trim($row[0]),
                'middle_name' => empty(trim($row[1])) ? null : trim($row[1]),
                'family_name' => trim($row[2]),
                'name_suffix' => empty(trim($row[3])) ? null : trim($row[3]),
                'position' => trim($row[4]),
            ]);
        }

        fclose($rows);

        $rows = fopen(storage_path('app/csv/regular2.csv'), 'r');

        while (($row = fgetcsv($rows, 255, ',')) !== false) {
            Employee::create([
                'given_name' => trim($row[0]),
                'middle_name' => empty(trim($row[1])) ? null : trim($row[1]),
                'family_name' => trim($row[2]),
                'name_suffix' => empty(trim($row[3])) ? null : trim($row[3]),
                'position' => trim($row[4]),
            ]);
        }

        fclose($rows);

        $rows = fopen(storage_path('app/csv/jcs.csv'), 'r');

        while (($row = fgetcsv($rows, 255, ',')) !== false) {
            Employee::create([
                'given_name' => trim($row[0]),
                'middle_name' => empty(trim($row[1])) ? null : trim($row[1]),
                'family_name' => trim($row[2]),
                'name_suffix' => empty(trim($row[3])) ? null : trim($row[3]),
                'position' => trim($row[4]),
            ]);
        }

        fclose($rows);

        User::create([
            'name' => 'ICT',
            'email' => 'ict@doh.local',
            'password' => Hash::make('ictadmin'),
        ]);

        User::create([
            'name' => 'HRMDS',
            'email' => 'hrmds@doh.local',
            'password' => Hash::make('hraccess'),
        ]);
    }
}
