<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LeadsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        //$clients = Client::pluck('client_email', 'client_number', 'source_id', 'user_id', 'team_id', 'department_id')->toArray();
        ini_set('max_execution_time', 600);
        foreach ($rows as $row) {
            DB::table('clients')
                ->where('client_email', '=', (string) $row[2])
                ->orWhere('client_number', '=', (string) $row[3])
                ->update([
                    'source_id' => 16,
                    'user_id' => 8,
                    'team_id' => 19,
                    'import_from_zoho' => 1,
                    'department_id' => 1
                ]);
        }

    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
