<?php
namespace App\Services\Note;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Noteable
{
    public function notes(): MorphMany;
    public function getCreateNoteEndpoint(): String;
}
