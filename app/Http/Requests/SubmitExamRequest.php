<?php

namespace App\Http\Requests;


class SubmitExamRequest extends BaseRequest
{
    protected function prepareForValidation()
    {
        $this->setRules([
            'student_id' => 'required|exists:users,id',
            'exam_id' => 'required|exists:exams,id',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|integer|exists:questions,id',
            'answers.*.selected_option' => 'required|in:A,B,C,D'
        ]);

        $this->setMessages([]);
    }

    private function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    private function setMessages(array $messages)
    {
        $this->messages = $messages;
    }
}
