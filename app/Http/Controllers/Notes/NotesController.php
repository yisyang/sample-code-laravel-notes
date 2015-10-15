<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotesModel;

/**
 * Notes controller that contains methods for the RESTful API
 *
 * Class NotesController
 */
class NotesController extends Controller
{
    /**
     * Gets previously set note using note ID
     *
     * @param int $noteId
     * @return string
     */
    public function getNote($noteId)
    {
        // Try to get notes by ID
        $note = NotesModel::find($noteId);

        // Not found
        if (empty($note)) {
            // TODO: extend ResponseFactory and use success() and fail() to handle JSON success and JSON fail
            return response()->json('Not found.', 404);
        }

        return response()->json($note->toArray());
    }

    /**
     * Create new note
     *
     * @param Request $request
     * @return string
     */
    public function postNote(Request $request)
    {
        // TODO: extend exception handler to output JSON message on validation failure
        try {
            $this->validate($request, [
                'title' => 'required|max:50',
                'note' => 'max:1000',
            ]);
        } catch (\Exception $e) {
            // TODO: actually show the errors... in JSON (see note above)
            return response()->json('Bad parameters.', 400);
        }

        $note = NotesModel::create([
            'title' => $request->input('title'),
            'note' => $request->input('note', ''),
        ]);

        return response()->json($note->toArray());
    }

    /**
     * Overwrites a note
     *
     * @param Request $request
     * @param int $noteId
     * @return string
     */
    public function putNote(Request $request, $noteId)
    {
        // TODO: extend exception handler to output JSON message on validation failure
        try {
            $this->validate($request, [
                'title' => 'required|max:50',
                'note' => 'max:1000',
            ]);
        } catch (\Exception $e) {
            // TODO: actually show the errors... in JSON (see note above)
            return response()->json('Bad parameters.', 400);
        }

        // Try to get notes by ID
        $note = NotesModel::find($noteId);

        // Not found
        // Assume we do not want users to insert at arbitrary IDs, return failure
        if (empty($note)) {
            return response()->json('Not found.', 404);
        }

        // Update the thing
        $note->update([
            'title' => $request->input('title'),
            'note' => $request->input('note', ''),
        ]);

        return response()->json($note->toArray());
    }

    /**
     * Deletes a note
     *
     * @return string
     */
    public function deleteNote($noteId)
    {
        // Try to get notes by ID
        $note = NotesModel::find($noteId);

        // Not found
        if (empty($note)) {
            return response()->json('Not found.', 404);
        }

        // Delete the note
        $note->delete();

        return response()->json('OK');
    }
}
