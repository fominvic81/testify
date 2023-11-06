<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TestingSession extends Model
{
    use HasFactory;

    protected $hidden = [

    ];

    protected $fillable = [
        'student_name',
        'exam_id',
        'test_id',
        'testing_session_settings_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function settings(): BelongsTo
    {
        return $this->belongsTo(TestingSessionSettings::class, 'testing_session_settings_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function stats()
    {
        $questions = $this->test->questions;
        $settings = $this->settings;

        $max = 0;
        $correct = 0;
        $unanswered = 0;
        foreach ($questions as $question) {
            $answer = $this->answers()->whereBelongsTo($question)->first();

            $max += $question->points;
            if ($answer) {
                $correct += $answer->points;
            } else {
                $unanswered += $question->points;
            }
        }
        $wrong = $max - $correct - $unanswered;

        $range = $settings->points_max - $settings->points_min;

        $points = $correct * $range / $max + $settings->points_min;

        return [
            'max' => $max,
            'correct' => $correct,
            'wrong' => $wrong,
            'unanswered' => $unanswered,
            'points' => $points,
        ];
    }
}
