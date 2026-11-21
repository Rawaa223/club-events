<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * Validation for creating AND editing an event.
 * If validation fails, Laravel redirects back with the errors and the old input.
 */
class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // A new event must be in the future; an existing one may be edited even if it's past.
        $dateRules = ['required', 'date'];
        if ($this->isMethod('post')) {
            $dateRules[] = 'after:now';
        }

        return [
            'title' => ['required', 'string', 'min:3', 'max:120'],
            'description' => ['nullable', 'string', 'max:2000'],
            'location' => ['required', 'string', 'max:120'],
            'starts_at' => $dateRules,
            'capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'organizer_id' => ['required', 'exists:members,id'],
            'attendees' => ['nullable', 'array'],
            'attendees.*' => ['integer', 'distinct', 'exists:members,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please give the event a title.',
            'title.min' => 'The title must be at least :min characters.',
            'location.required' => 'Where does the event take place?',
            'starts_at.required' => 'Please choose a date and time.',
            'starts_at.after' => 'A new event must be in the future.',
            'capacity.min' => 'The capacity must be at least 1 person.',
            'organizer_id.required' => 'Please choose an organizer.',
            'organizer_id.exists' => 'This organizer does not exist.',
        ];
    }

    public function attributes(): array
    {
        return [
            'starts_at' => 'date and time',
            'organizer_id' => 'organizer',
        ];
    }

    /** Extra check that needs two fields at once: not more attendees than places. */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $capacity = (int) $this->input('capacity');
                $attendees = $this->input('attendees', []);
                $count = is_array($attendees) ? count($attendees) : 0;

                if ($capacity > 0 && $count > $capacity) {
                    $validator->errors()->add(
                        'attendees',
                        "You selected {$count} attendees but the capacity is only {$capacity}."
                    );
                }
            },
        ];
    }
}
