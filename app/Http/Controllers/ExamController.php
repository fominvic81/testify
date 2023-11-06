<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use App\Models\Test;
use App\Models\TestingSession;
use App\Models\TestingSessionSettings;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('exam.index', [
            'exams' => $request->user()->exams()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Test $test)
    {
        return view('exam.create', [
            'test' => $test,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Test $test, ExamRequest $request)
    {
        $data = $request->validated();

        $settings = new TestingSessionSettings($data);
        $settings->save();

        $code = 0;
        do {
            $code = mt_rand(1000000, 9999999);
        } while (Exam::query()->where('code', '=', $code)->where('end_at', '>', now())->count() > 0);

        $exam = new Exam($data);
        $exam->code = $code;
        $exam->test()->associate($test);
        $exam->settings()->associate($settings);
        $exam->user()->associate($request->user());

        $exam->save();

        return redirect()->route('exam.show', $exam->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        return view('exam.show', [
            'exam'=> $exam,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        return view('exam.edit', [
            'exam' => $exam,
            'test' => $exam->test,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExamRequest $request, Exam $exam)
    {
        // TODO: check if exam has ended

        $data = $request->validated();
        
        $exam->settings->fill($data);
        $exam->settings->save();
        
        $exam = $exam->fill($data);
        $exam->save();

        return redirect()->route('exam.show', $exam->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        //
    }

    public function join(Request $request)
    {
        return view('exam.join', [
            'code' => $request->query('code'),
        ]);
    }

    public function start(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'code' => ['required', 'integer', 'digits:7'],
        ]);

        $exam = Exam::query()->where('code', '=', $data['code'])->where('end_at', '>', now())->first();

        if (!$exam) {
            return redirect()->back()->withInput()->withErrors('Тест таким кодом не знайдено');
        }

        $session = new TestingSession([
            'student_name' => $data['name'],
            'exam_id' => $exam->id,
            'test_id' => $exam->test->id,
            'testing_session_settings_id' => $exam->settings->id,
            'user_id' => $request->user()?->id,
        ]);

        $session->save();

        return redirect()->route('testing.show', $session->id);
    }
}
