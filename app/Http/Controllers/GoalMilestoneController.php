<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGoalMilestoneRequest;
use App\Models\CareerGoal;
use App\Models\GoalMilestone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GoalMilestoneController extends Controller
{
    /**
     * Tambahkan milestone baru ke dalam sebuah target karir.
     *
     * Milestone merupakan sub-target yang membantu user memecah target besar
     * menjadi langkah-langkah yang lebih terukur.
     * Contoh: Goal = 20 lamaran → Milestone = 5 lamaran pertama.
     */
    public function store(StoreGoalMilestoneRequest $request, CareerGoal $goal): RedirectResponse
    {
        $this->authorize('update', $goal);

        // Tentukan urutan posisi otomatis berdasarkan milestone terakhir
        $lastPosition = $goal->milestones()->max('order_position') ?? 0;

        $goal->milestones()->create([
            ...$request->validated(),
            'order_position' => $lastPosition + 1,
            'is_achieved'    => false,
        ]);

        return back()->with('success', 'Milestone berhasil ditambahkan.');
    }

    /**
     * Perbarui data milestone, termasuk menandai sebagai tercapai.
     * Saat is_achieved diubah menjadi true, achieved_at diisi otomatis.
     */
    public function update(StoreGoalMilestoneRequest $request, CareerGoal $goal, GoalMilestone $milestone): RedirectResponse
    {
        $this->authorize('update', $goal);

        abort_if($milestone->goal_id !== $goal->id, 404);

        $data = $request->validated();

        // Jika milestone ditandai tercapai, catat waktu pencapaian
        if (isset($data['is_achieved']) && $data['is_achieved'] && ! $milestone->is_achieved) {
            $data['achieved_at'] = now();
        }

        // Jika milestone di-uncheck dari tercapai, bersihkan waktu pencapaian
        if (isset($data['is_achieved']) && ! $data['is_achieved']) {
            $data['achieved_at'] = null;
        }

        $milestone->update($data);

        return back()->with('success', 'Milestone berhasil diperbarui.');
    }

    /**
     * Perbarui urutan milestone secara batch.
     * Dipanggil saat user melakukan drag-and-drop reorder di UI.
     */
    public function reorder(Request $request, CareerGoal $goal): RedirectResponse
    {
        $this->authorize('update', $goal);

        $request->validate([
            'order'   => ['required', 'array'],
            'order.*' => ['integer', 'exists:goal_milestones,id'],
        ]);

        foreach ($request->order as $position => $milestoneId) {
            $goal->milestones()
                ->where('id', $milestoneId)
                ->update(['order_position' => $position + 1]);
        }

        return back()->with('success', 'Urutan milestone berhasil disimpan.');
    }

    /**
     * Hapus milestone dari target karir.
     */
    public function destroy(CareerGoal $goal, GoalMilestone $milestone): RedirectResponse
    {
        $this->authorize('update', $goal);

        abort_if($milestone->goal_id !== $goal->id, 404);

        $milestone->delete();

        return back()->with('success', 'Milestone berhasil dihapus.');
    }
}