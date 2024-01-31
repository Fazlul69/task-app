<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller

{
    public function handleDynamicRequest(Request $request, $id = null)
    {
        $model = new Task;
        $recordData = ($id) ? $model->findOrFail($id)->toArray() : [];

        if ($request->isMethod('post')) {
            $data = $request->all();
            unset($data['_token']);

            if ($data['id']) {
                $fields = $data['fields'];
                unset($data['fields']);
                $id = $data['id'];

                foreach ($fields as $key => $value) {
                    $data['field' . ($key + 1)] = $value;
                    // dd('field' . ($key + 1));
                    $update = Task::where('id', $id)->update(
                        [
                            'field' . ($key + 1) => $value,
                        ]
                    );
                }
            } else {
                $fields = $data['fields'];
                unset($data['fields']);

                foreach ($fields as $key => $value) {
                    $data['field' . ($key + 1)] = $value;
                }

                $model->create($data);
            }
            return redirect()->back();
        } elseif ($request->isMethod('delete')) {
            Task::destroy($request->id);

            return redirect()->back();
        }

        $existingRecords = Task::all();
        return view('welcome', compact('existingRecords', 'recordData'));
    }
}
