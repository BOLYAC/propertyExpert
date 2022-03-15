<?php

namespace App\Imports;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Throwable;

class ClientsImport implements
    ToModel,
    WithHeadingRow,
    WithBatchInserts,
    WithChunkReading,
    WithValidation,
    SkipsOnError,
    SkipsOnFailure

{
    use Importable, SkipsErrors, SkipsFailures;

    private $user;
    private $source;
    private $team;


    public function __construct($user, $source, $team)
    {
        $this->user = $user;
        $this->source = $source;
        $this->team = $team;
    }

    /**
     * Transform a date value into a Carbon object.
     *
     * @return \Carbon\Carbon|null
     */
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Client([
            'public_id'      => strtoupper(substr(uniqid(mt_rand(), true), 16, 8)),
            'full_name'      => $row['full_name'] ?? '',
            'last_name'      => $row['last_name'] ?? '',
            'first_name'     => $row['first_name'] ?? '',
            'client_email'   => $row['email'],
            'client_number'  => $row['phone_number'],
            'client_number_2'  => $row['phone_number_2'],
            'city'           => $row['city'] ?? '',
            'country'        => $row['country'] ?? '',
            'campaigne_name' => $row['campaign_name'] ?? '',
            'adset_name'     => $row['adset_name'] ?? '',
            'ad_name'        => $row['ad_name'] ?? '',
            'form_name'      => $row['form_name'] ?? '',
            'description'    => $row['description'] ?? '',
            'created_at'     => $row['created_time'],
            'updated_at'     => $row['modified_time'],
            'status'         => 1,
            'user_id'        => $this->user ?? Auth::id(),
            'source_id'      => $this->source,
            'team_id'        => $this->team,
            'created_by'     => Auth::id(),
            'updated_by'     => Auth::id()
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

    public function rules(): array
    {
        return [
            '*.email'           => ['nullable','string', 'email', 'max:255', 'unique:clients,client_email,deleted_at'],
            '*.phone_number'    => ['nullable','max:255', 'unique:clients,client_number,deleted_at'],
        ];
    }
}
