<?php

namespace App\Http\Requests;

class AnalyzeStudentRequest extends BaseRequest
{
    protected function prepareForValidation()
    {
        $this->setRules([
            'student_id' => 'required|exists:users,id',
            'exam_id' => 'required|exists:exams,id'
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
