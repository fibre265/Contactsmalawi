<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;

class BulkImportController extends Controller
{
    public function index()
    {
        return view('admin.import');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:csv,txt|max:5120'
        ]);

        try {
            UsersImport::importFromCsv($request->file('excel_file')->getRealPath());
            return redirect()->back()->with('success', 'CSV file imported and user accounts created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}