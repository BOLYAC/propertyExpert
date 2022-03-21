<?php

namespace App\Imports;

use App\Models\Marketing;
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

class MarketingImport implements ToModel,
    WithHeadingRow,
    WithBatchInserts,
    WithChunkReading,
    WithValidation,
    SkipsOnError,
    SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    private $source;

    public function __construct($source)
    {
        $this->source = $source;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Marketing([
            'lead_name' => $row['lead_name'],
            'email' => $row['email'],
            'phone_number' => $row['phone_number'],
            'country' => $row['country'],
            'created_dat' => $row['created_date'],
            'ad_name' => $row['ad_name'],
            'adset_name' => $row['adset_name'],
            'campaign_name' => $row['campaign_name'],
            'form_name' => $row['form_name'],
            'platform' => $row['platform'],
            'description' => $row['when_are_you_planning_to_buy'],
            'source' => $this->source,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id()
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

        ];
    }

}
