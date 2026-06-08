<div class="space-y-5">

    <div>

        <label class="block mb-2">
            Judul Goal
        </label>

        <input
            type="text"
            name="title"
            value="{{ old('title', $goal->title ?? '') }}"
            class="w-full border rounded-lg px-4 py-2">
    </div>

    <div>

        <label class="block mb-2">
            Target Lamaran
        </label>

        <input
            type="number"
            name="target_application_count"
            value="{{ old('target_application_count', $goal->target_application_count ?? 20) }}"
            class="w-full border rounded-lg px-4 py-2">
    </div>

    <div>

        <label class="block mb-2">
            Deadline
        </label>

        <input
            type="date"
            name="deadline"
            value="{{ old('deadline', $goal->deadline ?? '') }}"
            class="w-full border rounded-lg px-4 py-2">

    </div>

    <div>

        <label class="block mb-2">
            Status
        </label>

        <select
            name="status"
            class="w-full border rounded-lg px-4 py-2">

            <option value="active">Active</option>
            <option value="achieved">Achieved</option>
            <option value="archived">Archived</option>

        </select>

    </div>

</div>