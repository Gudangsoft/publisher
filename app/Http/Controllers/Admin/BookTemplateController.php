<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookTemplateController extends Controller
{
    public function index()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $templates = BookTemplate::withCount('submissions')
            ->orderBy('display_order')
            ->orderBy('name')
            ->paginate(15);
        
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $bookTypes = BookTemplate::bookTypes();
        $pageSizes = BookTemplate::pageSizes();
        
        return view('admin.templates.form', compact('bookTypes', 'pageSizes'));
    }

    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'book_type' => 'required|string|max:50',
            'page_size' => 'required|string|max:20',
            'orientation' => 'required|in:portrait,landscape',
            'margin_top' => 'nullable|numeric|min:0|max:10',
            'margin_bottom' => 'nullable|numeric|min:0|max:10',
            'margin_left' => 'nullable|numeric|min:0|max:10',
            'margin_right' => 'nullable|numeric|min:0|max:10',
            'font_family' => 'nullable|string|max:100',
            'font_size' => 'nullable|integer|min:8|max:24',
            'line_spacing' => 'nullable|numeric|min:1|max:3',
            'description' => 'nullable|string',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'template_file' => 'nullable|mimes:doc,docx,pdf|max:10240',
            'specifications' => 'nullable|string',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        // Handle margins
        $validated['margins'] = [
            'top' => $request->margin_top ?? 2.5,
            'bottom' => $request->margin_bottom ?? 2.5,
            'left' => $request->margin_left ?? 3,
            'right' => $request->margin_right ?? 2.5,
        ];

        // Handle specifications JSON
        if ($request->specifications) {
            $specs = [];
            $lines = explode("\n", $request->specifications);
            foreach ($lines as $line) {
                $line = trim($line);
                if (strpos($line, ':') !== false) {
                    [$key, $value] = explode(':', $line, 2);
                    $specs[trim($key)] = trim($value);
                }
            }
            $validated['specifications'] = $specs;
        }

        // Handle preview image upload
        if ($request->hasFile('preview_image')) {
            $validated['preview_image'] = $request->file('preview_image')
                ->store('templates/previews', 'public');
        }

        // Handle template file upload
        if ($request->hasFile('template_file')) {
            $validated['template_file'] = $request->file('template_file')
                ->store('templates/files', 'public');
        }

        // Remove margin fields
        unset($validated['margin_top'], $validated['margin_bottom'], 
              $validated['margin_left'], $validated['margin_right']);

        BookTemplate::create($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template buku berhasil ditambahkan!');
    }

    public function show(BookTemplate $template)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $template->load('submissions');
        
        return view('admin.templates.show', compact('template'));
    }

    public function edit(BookTemplate $template)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $bookTypes = BookTemplate::bookTypes();
        $pageSizes = BookTemplate::pageSizes();
        
        return view('admin.templates.form', compact('template', 'bookTypes', 'pageSizes'));
    }

    public function update(Request $request, BookTemplate $template)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'book_type' => 'required|string|max:50',
            'page_size' => 'required|string|max:20',
            'orientation' => 'required|in:portrait,landscape',
            'margin_top' => 'nullable|numeric|min:0|max:10',
            'margin_bottom' => 'nullable|numeric|min:0|max:10',
            'margin_left' => 'nullable|numeric|min:0|max:10',
            'margin_right' => 'nullable|numeric|min:0|max:10',
            'font_family' => 'nullable|string|max:100',
            'font_size' => 'nullable|integer|min:8|max:24',
            'line_spacing' => 'nullable|numeric|min:1|max:3',
            'description' => 'nullable|string',
            'preview_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'template_file' => 'nullable|mimes:doc,docx,pdf|max:10240',
            'specifications' => 'nullable|string',
            'is_active' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        // Handle margins
        $validated['margins'] = [
            'top' => $request->margin_top ?? 2.5,
            'bottom' => $request->margin_bottom ?? 2.5,
            'left' => $request->margin_left ?? 3,
            'right' => $request->margin_right ?? 2.5,
        ];

        // Handle specifications JSON
        if ($request->specifications) {
            $specs = [];
            $lines = explode("\n", $request->specifications);
            foreach ($lines as $line) {
                $line = trim($line);
                if (strpos($line, ':') !== false) {
                    [$key, $value] = explode(':', $line, 2);
                    $specs[trim($key)] = trim($value);
                }
            }
            $validated['specifications'] = $specs;
        } else {
            $validated['specifications'] = null;
        }

        // Handle preview image upload
        if ($request->hasFile('preview_image')) {
            // Delete old image
            if ($template->preview_image) {
                Storage::disk('public')->delete($template->preview_image);
            }
            $validated['preview_image'] = $request->file('preview_image')
                ->store('templates/previews', 'public');
        }

        // Handle template file upload
        if ($request->hasFile('template_file')) {
            // Delete old file
            if ($template->template_file) {
                Storage::disk('public')->delete($template->template_file);
            }
            $validated['template_file'] = $request->file('template_file')
                ->store('templates/files', 'public');
        }

        // Remove margin fields
        unset($validated['margin_top'], $validated['margin_bottom'], 
              $validated['margin_left'], $validated['margin_right']);

        $template->update($validated);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template buku berhasil diperbarui!');
    }

    public function destroy(BookTemplate $template)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        // Check if template is in use
        if ($template->submissions()->exists()) {
            return redirect()->route('admin.templates.index')
                ->with('error', 'Template tidak dapat dihapus karena masih digunakan oleh pengajuan.');
        }

        // Delete files
        if ($template->preview_image) {
            Storage::disk('public')->delete($template->preview_image);
        }
        if ($template->template_file) {
            Storage::disk('public')->delete($template->template_file);
        }

        $template->delete();

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template buku berhasil dihapus!');
    }

    public function download(BookTemplate $template)
    {
        if (!$template->template_file) {
            abort(404, 'File template tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $template->template_file);
        
        if (!file_exists($path)) {
            abort(404, 'File template tidak ditemukan.');
        }

        return response()->download($path);
    }

    public function toggleActive(BookTemplate $template)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        $template->update(['is_active' => !$template->is_active]);

        return redirect()->back()
            ->with('success', 'Status template berhasil diubah!');
    }
}
