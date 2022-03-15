<?php

namespace App\Imports;

use App\Agency;
use Illuminate\Support\Facades\Auth;
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


class AgenciesImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    public function __construct()
    {

    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Agency([
            'name'          => $row['name'] ?? '',
            'in_charge'     => $row['agent'] ?? '',
            'phone'         => $row['phone_number'],
            'email'         => $row['email'],
            'user_id'       => 1,
            'department_id' => 1,
            'note'          => $row['note'] . '<br><br>' . '<strong>Phone/Status:</strong> ' . $row['phone_number_2'],
            'created_by'    => Auth::id(),
            'updated_by'    => Auth::id(),
        ]);
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
