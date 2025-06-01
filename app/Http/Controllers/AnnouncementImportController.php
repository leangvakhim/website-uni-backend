<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\Controller;
use App\Imports\AnnouncementImport;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class AnnouncementImportController extends Controller
{
    public function import(Request $request)
    {
        // Validate file
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        // Import using AnnouncementImport
        // Excel::import(new AnnouncementImport, $request->file('file'));
        $amID = $request->input('amID');
        Excel::import(new AnnouncementImport($amID), $request->file('file'));

        return response()->json(['message' => 'File Imported Successfully!']);
    }

    public function setVisibility(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'integer'
        ]);

        DB::table('tbstudentscore')
            ->whereIn('student_id', $request->student_ids)
            ->update(['active' => 0]);

        return response()->json(['message' => 'delete records successfully.']);
    }

    // public function fetchStudents()
    // {
    //     $studentsRaw = DB::table('tbstudentscore as sc')
    //         ->join('tbstudents as s', 'sc.student_id', '=', 's.student_id')
    //         ->join('tbsubjects as sub', 'sc.subject_id', '=', 'sub.subject_id')
    //         ->select(
    //             's.student_id',
    //             's.student_identity',
    //             'sub.subject_name',
    //             'sc.score',
    //             's.result'
    //         )
    //         ->where('sc.active', 1)
    //         ->get();

    //     $students = [];
    //     foreach ($studentsRaw as $row) {
    //         if (!isset($students[$row->student_id])) {
    //             $students[$row->student_id] = [
    //                 'student_id' => $row->student_id,
    //                 'student_identity' => $row->student_identity,
    //                 'SE' => null,
    //                 'MIS' => null,
    //                 'WEB' => null,
    //                 'LINUX' => null,
    //                 'OOAD' => null,
    //                 'result' => $row->result,
    //             ];
    //         }
    //         $subjectName = strtoupper($row->subject_name);
    //         if (array_key_exists($subjectName, $students[$row->student_id])) {
    //             $students[$row->student_id][$subjectName] = $row->score;
    //         }
    //     }

    //     // Reindex the array
    //     $students = array_values($students);

    //     return response()->json($students);
    // }

    public function fetchStudents()
    {
        $studentsRaw = DB::table('tbstudentscore as sc')
            ->join('tbstudents as s', 'sc.student_id', '=', 's.student_id')
            ->join('tbsubjects as sub', 'sc.subject_id', '=', 'sub.subject_id')
            ->select(
                's.student_id',
                's.student_am',
                's.student_identity',
                'sub.subject_name',
                'sc.score',
                's.result'
            )
            ->where('sc.active', 1)
            ->get();

        $students = [];

        foreach ($studentsRaw as $row) {
            $subjectName = strtoupper($row->subject_name);

            if (!isset($students[$row->student_id])) {
                $students[$row->student_id] = [
                    'student_id' => $row->student_id,
                    'student_identity' => $row->student_identity,
                    'result' => $row->result,
                    'student_am' => $row->student_am,
                ];
            }

            $students[$row->student_id][$subjectName] = $row->score;
        }

        $students = array_values($students);

        return response()->json($students);
    }
}
