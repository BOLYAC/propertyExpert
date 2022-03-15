<?php
namespace App\Services\Document;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Documentable
{
    public function documents(): MorphMany;
    public function getCreateDocumentEndpoint(): String;
}
