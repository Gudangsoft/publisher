<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BookLoansTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\BookLoansImport;
use App\Models\BookLoan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BookLoanController extends Controller
{
    public function index(Request $request)
    {
        $query = BookLoan::with('book');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('borrower_name', 'like', "%{$search}%")
                  ->orWhere('borrower_identity_number', 'like', "%{$search}%")
                  ->orWhere('book_title_snapshot', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('loaned_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('loaned_at', '<=', $request->to);
        }

        $bookLoans = $query->orderByDesc('loaned_at')->paginate(15)->withQueryString();

        return view('admin.book-loans.index', [
            'bookLoans' => $bookLoans,
            'statuses' => BookLoan::STATUSES,
        ]);
    }

    public function template()
    {
        return Excel::download(new BookLoansTemplateExport(), 'template-data-peminjaman.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $import = new BookLoansImport();
        Excel::import($import, $request->file('file'));

        if ($import->failures()->isNotEmpty()) {
            $messages = $import->failures()->take(5)->map(function ($failure) {
                return 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            })->implode(' | ');

            return back()->with('import_warning', 'Sebagian baris gagal diimpor. ' . $messages);
        }

        return back()->with('success', 'Data peminjaman berhasil diimpor.');
    }
}
