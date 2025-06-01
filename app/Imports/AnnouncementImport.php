<?php

namespace App\Imports;

use App\Models\Announcement;
use App\Models\Student;
use App\Models\Studentscore;
use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AnnouncementImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $amID;

    public function __construct($amID)
    {
        $this->amID = $amID;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // 1. Insert or update Student
            $student = Student::updateOrCreate(
                [
                    'student_identity' => $row->get('student_identity'),
                    'student_am' => $this->amID,
                ],
                [
                    'result' => $row->get('result'),
                    'display' => 1,
                    'active' => 1,
                ]
            );

            // 2. Loop through subjects dynamically
            foreach ($row->except(['student_id', 'result'])->toArray() as $subjectName => $score) {
                if ($score !== null && $score !== '') {
                    // 2.1 Insert or update Subject
                    $subject = Subject::firstOrCreate(
                        ['subject_name' => $subjectName],
                        ['display' => 1, 'active' => 1]
                    );

                    // 2.2 Insert Student Score
                    if (is_numeric($score)) {
                        // Save to database
                        Studentscore::create([
                            'student_id' => $student->student_id,
                            'subject_id' => $subject->subject_id,
                            'score' => $score,
                            'display' => 1,
                            'active' => 1
                        ]);
                    }
                }
            }
        }
    }
}
