<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Create a comment for tasks and leads
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->all();


        if ($request->hasFile('full')) {
            $imagePath = $data['full']->store('clients', 'public');
        }

        $modelsMapping = [
            'agency' => 'App\Agency',
            'client' => 'App\Models\Client'
        ];

        if (!array_key_exists($request->type, $modelsMapping)) {
            Session::flash('flash_message_warning', __('Could not create document, type not found! Please contact support'));
            throw new Exception("Could not create comment with type " . $request->type);
            return redirect()->back();
        }

        $model = $modelsMapping[$request->type];
        $source = $model::where('id', '=', $request->external_id)->first();
        $source->documents()->create(
            [
                'title' => $request->get('title'),
                'excerpt' => $request->get('excerpt'),
                'user_id' => auth()->user()->id,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'full' => $imagePath
            ]
        );

        //ClientDocument::create($data);

        return redirect()->back()
            ->with('toast_success', __('File add successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $clientDocument = ClientDocument::findOrFail($id);
        try {
            $clientDocument->delete();
            Session()->flash('toast_message', __('File successfully deleted'));
        } catch (\Exception $e) {
            Session()->flash('toast_warning', __('File could not be deleted, contact for support'));
        }

        return redirect()->back();
    }
}
