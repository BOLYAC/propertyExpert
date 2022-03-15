<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid;

class CommentController extends Controller
{
    /**
     * Create a comment for tasks and leads
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
        ]);

        $modelsMapping = [
            'task' => 'App\Models\Task',
            'lead' => 'App\Models\Lead',
            'project' => 'App\Models\Project',
            'event' => 'App\Models\Event',
        ];

        if (!array_key_exists($request->type, $modelsMapping)) {
            Session::flash('flash_message_warning', __('Could not create comment, type not found! Please contact support'));
            throw new Exception("Could not create comment with type " . $request->type);
            return redirect()->back();
        }


        $model = $modelsMapping[$request->type];
        if ($request->type === 'event'){
            $source = $model::findOrFail($request->external_id);
        } else {
            $source = $model::whereExternalId($request->external_id)->first();
        }
        $source->comments()->create(
            [
                'description' => $request->description,
                'user_id' => auth()->user()->id,
                'external_id' => Uuid::uuid4()->toString()
            ]
        );

        Session::flash('flash_message', __('Comment successfully added')); //Snippet in Master.blade.php
        return redirect()->back();
    }
}
