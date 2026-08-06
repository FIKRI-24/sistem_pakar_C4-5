<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DecisionTree;
use App\Services\C45Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DecisionTreeController extends Controller
{
    protected C45Client $client;

    public function __construct(C45Client $client)
    {
        $this->client = $client;
    }

    public function index(): View
    {
        $activeTree = DecisionTree::query()
            ->where('status_aktif', true)
            ->with('dibuatOleh')
            ->orderByDesc('versi')
            ->first();

        $rules = [];
        $error = null;

        if ($activeTree) {
            try {
                $rulesResponse = $this->client->getRules();
                $rules = $rulesResponse['rules'] ?? [];
            } catch (\Throwable $e) {
                $error = 'Layanan C4.5 Python saat ini offline. Menampilkan struktur pohon dari basis data lokal.';
            }
        }

        $careers = \App\Models\Karir::pluck('nama_karir', 'id')->all();

        $history = DecisionTree::query()
            ->with('dibuatOleh')
            ->orderByDesc('versi')
            ->take(10)
            ->get();

        return view('admin.decision-tree.index', compact('activeTree', 'rules', 'history', 'error', 'careers'));
    }

    public function train(): RedirectResponse
    {
        try {
            $response = $this->client->train(auth()->id());
            $accuracyPercent = number_format($response['akurasi'] * 100, 2, ',', '.');

            return redirect()->route('admin.decision-tree.index')
                ->with('success', "Latih ulang berhasil! Pohon Keputusan Versi #{$response['versi']} terbentuk dengan Akurasi: {$accuracyPercent}%.");
        } catch (\Throwable $e) {
            logger()->error('C4.5 Rebuild failed: ' . $e->getMessage());

            return redirect()->route('admin.decision-tree.index')
                ->with('error', 'Gagal melatih ulang pohon keputusan. Pastikan service Python C4.5 berjalan. Detail: ' . $e->getMessage());
        }
    }
}
