<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Saran;
use Illuminate\Http\Request;

class SaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Saran::query();

        if ($request->filled('status')) {
            $query->where('is_read', $request->status === 'dibaca' ? true : false);
        }
        if ($request->filled('pengirim')) {
            $query->where('pengirim', $request->pengirim);
        }

        $sarans        = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $belumDibaca   = Saran::where('is_read', false)->count();

        return view('admin.saran.index', compact('sarans', 'belumDibaca'));
    }

    public function show(int $id)
    {
        $saran = Saran::findOrFail($id);
        if (!$saran->is_read) {
            $saran->update(['is_read' => true]);
        }
        return view('admin.saran.show', compact('saran'));
    }

    public function tandaiBaca(int $id)
    {
        Saran::findOrFail($id)->update(['is_read' => true]);
        return back()->with('success', 'Saran ditandai sebagai sudah dibaca.');
    }

    public function destroy(int $id)
    {
        Saran::findOrFail($id)->delete();
        return redirect()->route('admin.saran.index')->with('success', 'Saran berhasil dihapus.');
    }
}