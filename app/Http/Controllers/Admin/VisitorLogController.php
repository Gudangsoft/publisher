<?php

namespace App\Http\Controllers\Admin;

use App\Exports\VisitorLogsExport;
use App\Exports\VisitorLogsTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\VisitorLogsImport;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VisitorLogController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitorLog::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('identity_type')) {
            $query->where('identity_type', $request->identity_type);
        }

        if ($request->filled('from')) {
            $query->whereDate('checked_in_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('checked_in_at', '<=', $request->to);
        }

        $visitorLogs = $query->orderByDesc('checked_in_at')->paginate(15)->withQueryString();

        return view('admin.visitor-logs.index', [
            'visitorLogs' => $visitorLogs,
            'identityTypes' => VisitorLog::IDENTITY_TYPES,
        ]);
    }

    public function export(Request $request)
    {
        $filters = $request->only(['search', 'identity_type', 'from', 'to']);
        $filename = 'data-pengunjung-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new VisitorLogsExport($filters), $filename);
    }

    public function template()
    {
        return Excel::download(new VisitorLogsTemplateExport(), 'template-data-pengunjung.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $import = new VisitorLogsImport();
        Excel::import($import, $request->file('file'));

        if ($import->failures()->isNotEmpty()) {
            $messages = $import->failures()->take(5)->map(function ($failure) {
                return 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            })->implode(' | ');

            return back()->with('import_warning', 'Sebagian baris gagal diimpor. ' . $messages);
        }

        return back()->with('success', 'Data pengunjung berhasil diimpor.');
    }
}
