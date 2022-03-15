<?php
namespace App\Services\Deal;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Dealable
{
    public function deals(): MorphMany;
    public function getCreateDealEndpoint(): String;
}
