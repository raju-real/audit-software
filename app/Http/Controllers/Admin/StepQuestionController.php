<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditStep;
use App\Models\AuditStepQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StepQuestionController extends Controller
{
    public function questionList($step_slug = Null)
    {
        $audit_step = AuditStep::whereSlug($step_slug)->firstOrFail();
        $step_id = $audit_step->id;
        $questions = AuditStepQuestion::where('audit_step_id', $step_id)->oldest('sorting_serial')->get();
        return view('admin.step-questions.question_list', compact('audit_step', 'questions'));
    }

    public function addQuestion($step_slug)
    {
        $audit_step = AuditStep::whereSlug($step_slug)->firstOrFail();
        $route = route('admin.store-question');
        return view('admin.step-questions.question_add_edit', compact('audit_step', 'route'));
    }

    public function storeQuestion(Request $request)
    {
        $this->validate($request, [
            'audit_step_id' => 'required|exists:audit_steps,id',
            'question' => ['required',
                'max:100',
                Rule::unique('audit_step_questions') // Your table name
                ->where(function ($query) use ($request) {
                    return $query->where('audit_step_id', $request->input('audit_step_id'));
                })->ignore($request->audit_step_id)
            ],
            'status' => 'required|in:active,inactive',
            'is_closed_ended' => 'required|in:yes,no',
            'is_boolean_answer_required' => 'required|in:yes,no',
            'has_text_answer' => 'required|in:yes,no',
            'is_text_answer_required' => 'required|in:yes,no',
            'has_document' => 'required|in:yes,no',
            'is_document_required' => 'required|in:yes,no'
        ]);

        $question = new AuditStepQuestion();
        $question->audit_step_id = $request->audit_step_id;
        $question->question = $request->question;
        $question->slug = time().'-'.Str::slug($request->question);
        $question->is_closed_ended = $request->is_closed_ended ;
        $question->is_boolean_answer_required = $request->is_boolean_answer_required ;
        $question->has_text_answer = $request->has_text_answer ;
        $question->is_text_answer_required = $request->is_text_answer_required ;
        $question->has_document = $request->has_document ;
        $question->is_document_required = $request->is_document_required ;
        $question->status = $request->status;
        $question->sorting_serial = AuditStepQuestion::where('audit_step_id', $request->audit_step_id)->max('sorting_serial') + 1;
        $question->save();
        return redirect()->route('admin.question-list', stepSlugById($question->audit_step_id))->with(successMessage());
    }

    public function editQuestion($slug) {
        $question = AuditStepQuestion::whereSlug($slug)->firstOrFail();
        $audit_step = AuditStep::findOrFail($question->audit_step_id);
        $route = route('admin.update-question',$question->id);
        return view('admin.step-questions.question_add_edit',compact('question','audit_step','route'));
    }

    public function updateQuestion(Request $request, $id)
    {
        $this->validate($request, [
            'audit_step_id' => 'required|exists:audit_steps,id',
            'question' => ['required',
                'max:100',
                Rule::unique('audit_step_questions')
                ->where(function ($query) use ($request) {
                    return $query->where('audit_step_id', $request->input('audit_step_id'));
                })->ignore($id)
            ],
            'status' => 'required|in:active,inactive',
            'is_closed_ended' => 'required|in:yes,no',
            'is_boolean_answer_required' => 'required|in:yes,no',
            'has_text_answer' => 'required|in:yes,no',
            'is_text_answer_required' => 'required|in:yes,no',
            'has_document' => 'required|in:yes,no',
            'is_document_required' => 'required|in:yes,no'
        ]);

        $question = AuditStepQuestion::findOrFail($id);
        $question->audit_step_id = $request->audit_step_id;
        $question->question = $request->question;
        $question->is_closed_ended = $request->is_closed_ended ;
        $question->is_boolean_answer_required = $request->is_boolean_answer_required ;
        $question->has_text_answer = $request->has_text_answer ;
        $question->is_text_answer_required = $request->is_text_answer_required ;
        $question->has_document = $request->has_document ;
        $question->is_document_required = $request->is_document_required ;
        $question->status = $request->status;
        $question->save();
        return redirect()->route('admin.question-list', stepSlugById($question->audit_step_id))->with(infoMessage());
    }

    public function deleteQuestion($id) {
        $question = AuditStepQuestion::findOrFail($id);
        $redirect_route = route('admin.question-list', stepSlugById($question->audit_step_id));
        $question->update(['deleted_by' => Auth::id()]);
        $question->delete();
        return redirect()->route($redirect_route)->with(deleteMessage());
    }

    public function updateQuestionStatus($id): \Illuminate\Http\JsonResponse
    {
        $question = AuditStepQuestion::findOrFail($id);
        $question->status = $question->status === 'active' ? 'inactive' : 'active';
        if ($question->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Audit step question status updated successfully.',
            ]);
        }
        // Optional: Handle failure case if needed
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update step question status.',
        ], 500);
    }

    public function sortQuestions(Request $request)
    {
        $step_id = $request->input('step_id');
        if ($request->has('ids')) {
            $arr = $request->input('ids');
            foreach ($arr as $sortOrder => $id) {
                $row = AuditStepQuestion::where('audit_step_id', $step_id)->find($id);
                if ($row) {
                    $row->sorting_serial = $sortOrder + 1;
                    $row->save();
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Sorting updated successfully.'
            ]);
        }
    }
}
