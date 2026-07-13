@props(['default' => 'pending'])

<div x-data="{ selectedStatus: '{{ $default }}' }" class="space-y-2">
    <div class="label">Status</div>
    <div class="flex gap-2">
        @foreach (['pending', 'in_progress', 'completed'] as $status)
        <button
        type="button"
        @click="selectedStatus = '{{ $status }}'"
        data-test="button-status-{{ $status }}"  <!-- ✅ EKLENDİ -->
        :class="selectedStatus === '{{ $status }}'
        ? 'bg-blue-600 text-white'
        : 'bg-gray-200 text-gray-700'"
        class="px-4 py-2 rounded transition capitalize"
        >
          {{ str_replace('_', ' ', $status) }}         </button>
        @endforeach
    </div>
    <input type="hidden" name="status" :value="selectedStatus">
</div>
