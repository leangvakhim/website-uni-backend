<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\Controller;
use App\Imports\AnnouncementImport;
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
        Excel::import(new AnnouncementImport, $request->file('file'));

        return response()->json(['message' => 'File Imported Successfully!']);
    }

    public function fetchStudents()
    {
        $studentsRaw = DB::table('tbstudentscore as sc')
            ->join('tbstudents as s', 'sc.student_id', '=', 's.student_id')
            ->join('tbsubjects as sub', 'sc.subject_id', '=', 'sub.subject_id')
            ->select(
                's.student_id',
                'sub.subject_name',
                'sc.score',
                's.result'
            )
            ->get();

        $students = [];
        foreach ($studentsRaw as $row) {
            if (!isset($students[$row->student_id])) {
                $students[$row->student_id] = [
                    'student_id' => $row->student_id,
                    'SE' => null,
                    'MIS' => null,
                    'Web' => null,
                    'Linux' => null,
                    'OOAD' => null,
                    'result' => $row->result,
                ];
            }
            $subjectName = strtoupper($row->subject_name);
            if (array_key_exists($subjectName, $students[$row->student_id])) {
                $students[$row->student_id][$subjectName] = $row->score;
            }
        }

        // Reindex the array
        $students = array_values($students);

        return response()->json($students);
    }
}
