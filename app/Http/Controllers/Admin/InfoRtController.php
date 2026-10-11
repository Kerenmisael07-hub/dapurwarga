<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RtAnnouncement;
use App\Models\RtContact;
use App\Models\RtGallery;
use App\Models\RtSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InfoRtController extends Controller
{
    public function index(Request $request)
    {
        $active = $request->query('tab', 'overview');
        $settings = RtSetting::all()->pluck('value', 'key');
        $announcements = RtAnnouncement::latest()->paginate(10);
        $contacts = RtContact::latest()->paginate(10);
        $gallery = RtGallery::latest()->paginate(10);

        return view('admin.info-rt.index', compact('active', 'settings', 'announcements', 'contacts', 'gallery'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'status_text' => ['nullable', 'string', 'max:255'],
            'lapak_aktif' => ['nullable', 'string', 'max:50'],
            'total_warga' => ['nullable', 'string', 'max:50'],
            'kegiatan_bulan_ini' => ['nullable', 'string', 'max:50'],
        ]);

        foreach ($data as $key => $value) {
            RtSetting::set($key, $value === '' ? null : $value);
        }

        return back()->with('success', 'Pengaturan Info RT diperbarui.');
    }

    public function storeAnnouncement(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string', 'max:2000'],
            'category' => ['nullable', 'string', 'max:100'],
            'tanggal' => ['nullable', 'date'],
            'is_urgent' => ['nullable', 'boolean'],
        ]);

        $data['is_urgent'] = $request->boolean('is_urgent');
        RtAnnouncement::create($data);

        return back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function updateAnnouncement(Request $request, RtAnnouncement $announcement)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string', 'max:2000'],
            'category' => ['nullable', 'string', 'max:100'],
            'tanggal' => ['nullable', 'date'],
            'is_urgent' => ['nullable', 'boolean'],
        ]);

        $data['is_urgent'] = $request->boolean('is_urgent');
        $announcement->update($data);

        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroyAnnouncement(RtAnnouncement $announcement)
    {
        $announcement->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function storeContact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $data['icon'] = $data['icon'] ?: 'person';
        RtContact::create($data);

        return back()->with('success', 'Kontak berhasil ditambahkan.');
    }

    public function updateContact(Request $request, RtContact $contact)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        $data['icon'] = $data['icon'] ?: 'person';
        $contact->update($data);

        return back()->with('success', 'Kontak berhasil diperbarui.');
    }

    public function destroyContact(RtContact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Kontak berhasil dihapus.');
    }

    public function storeGallery(Request $request)
    {
        $data = $request->validate([
            'image' => ['required', 'url', 'max:1000'],
        ]);

        RtGallery::create($data);

        return back()->with('success', 'Gambar galeri berhasil ditambahkan.');
    }

    public function destroyGallery(RtGallery $gallery)
    {
        $gallery->delete();

        return back()->with('success', 'Gambar galeri berhasil dihapus.');
    }
}