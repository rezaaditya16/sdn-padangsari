<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengaduan;
use App\Models\ComplaintResponse;

class PengaduanResponseController extends Controller
{
    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['student', 'category', 'complaintResponses.user']);
        
        // Periksa apakah user memiliki akses ke pengaduan ini
        $user = Auth::user();
        if ($user->role !== 'admin' && $pengaduan->assigned_to !== $user->id) {
            // Periksa berdasarkan role kategori
            if ($pengaduan->category->assigned_role !== $user->role) {
                abort(403, 'Anda tidak memiliki akses ke pengaduan ini.');
            }
        }

        return view('admin.pengaduan.detail', compact('pengaduan'));
    }

    public function store(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'response_text' => 'required|string|min:10',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'status' => 'required|in:Diajukan,Dalam Proses,Selesai'
        ]);

        $user = Auth::user();
        
        // Periksa akses
        if ($user->role !== 'admin' && $pengaduan->assigned_to !== $user->id) {
            if ($pengaduan->category->assigned_role !== $user->role) {
                abort(403, 'Anda tidak memiliki akses untuk merespons pengaduan ini.');
            }
        }

        $data = [
            'pengaduan_id' => $pengaduan->id,
            'user_id' => $user->id,
            'response_text' => $request->response_text,
            'response_date' => now(),
        ];

        // Handle file upload jika ada
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('complaint-responses', $fileName, 'public');
            $data['attachment_path'] = $filePath;
            $data['attachment_name'] = $file->getClientOriginalName();
        }

        ComplaintResponse::create($data);

        // Update status pengaduan
        $pengaduan->update([
            'status' => $request->status,
            'assigned_to' => $user->id // Assign ke user yang merespons
        ]);

        return redirect()->back()->with('success', 'Respons berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:Diajukan,Dalam Proses,Selesai'
        ]);

        $user = Auth::user();
        
        // Periksa akses
        if ($user->role !== 'admin' && $pengaduan->assigned_to !== $user->id) {
            if ($pengaduan->category->assigned_role !== $user->role) {
                abort(403, 'Anda tidak memiliki akses untuk mengubah status pengaduan ini.');
            }
        }

        $pengaduan->update([
            'status' => $request->status,
            'assigned_to' => $user->id
        ]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
