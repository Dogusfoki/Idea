@props(['idea' => null])

<form method="POST"
      action="{{ $idea ? route('ideas.update', $idea) : route('ideas.store') }}"
      class="space-y-6"
      x-data="{
      links: {{ Js::from($idea->links ?? []) }},
      newLink: '',
      steps: {{ Js::from($idea?->steps->pluck('description') ?? []) }},
      newStep: ''
       }"
      enctype="multipart/form-data"
      >
    @csrf
    @if ($idea)
        @method('PUT')
    @endif

    <!-- Title -->
    <x-field type="text"
             name="title"
             label="Title"
             placeholder="Enter an idea"
             :value="$idea->title ?? ''"
             data-test="title-input" />

    <!-- Description -->
    <x-field type="textarea"
             name="description"
             label="Description"
             placeholder="Describe your idea"
             :value="$idea->description ?? ''"
             data-test="description-input" />

   <div x-data="{
        newImagePreview: null,
        removeImage: false
     }">
    @if($idea?->image_path)
        <div x-show="!newImagePreview && !removeImage">
            <img src="{{ asset('storage/' . $idea->image_path) }}"
                 class="w-200 h-50 object-cover rounded mb-2">
            <button type="button" @click="removeImage = true" class="border rounded-lg px-2 text-red-600 text-sm hover:underline">
                Remove Image
            </button>
        </div>
    @endif

    <div x-show="newImagePreview">
        <img :src="newImagePreview" class="w-200 h-50 object-cover rounded mb-2">
        <button type="button" @click="newImagePreview = null; $refs.imageInput.value = ''" class="text-red-600 text-sm hover:underline">
            Cancel New Image
        </button>
    </div>

    <div x-show="!newImagePreview && (removeImage || !{{ $idea?->image_path ? 'true' : 'false' }})">
        <input type="file"
               name="image"
               x-ref="imageInput"
               @change="newImagePreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null">
    </div>

    <input type="hidden" name="remove_image" :value="removeImage ? 1 : 0">
</div>


   <fieldset class="space-y-3">
    <legend class="text-sm font-medium text-gray-700">Actionable Steps</legend>

    <template x-for="(step, index) in steps" :key="index">
        <div class="flex gap-2 items-center">
            <input type="text"
                   name="steps[]"
                   x-model="steps[index]"
                   class="flex-1 border rounded p-2">
            <button type="button"
                    @click="steps.splice(index, 1)"
                    class="text-gray-400 hover:text-red-600"
                    aria-label="Remove step">✕</button>
        </div>
    </template>

    <div class="flex gap-2">
        <input type="text"
               id="new-step"
               x-model="newStep"
               placeholder="What needs to be done?"
               class="flex-1 border rounded p-2"
               autocomplete="off"
               spellcheck="false">
        <button type="button"
                @click="if (newStep.trim()) { steps.push(newStep.trim()); newStep = ''; }"
                :disabled="!newStep.trim()"
                :class="newStep.trim() ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-300 cursor-not-allowed'"
                class="px-4 py-2 rounded text-white transition"
                aria-label="Add step">+</button>
    </div>
</fieldset>

    <!-- Links -->
    <fieldset class="space-y-3">
        <legend class="text-sm font-medium text-gray-700">Links</legend>

        <!-- Mevcut linkler -->
        <template x-for="(link, index) in links" :key="index">
            <div class="flex gap-2 items-center">
                <input type="text"
                       name="links[]"
                       x-model="links[index]"
                       class="flex-1 border rounded p-2">
                <button type="button"
                        @click="links.splice(index, 1)"
                        class="text-gray-400 hover:text-red-600"
                        aria-label="Remove link">✕</button>
            </div>
        </template>

        <!-- Yeni link ekleme -->
        <div class="flex gap-2">
            <input type="url"
                   x-model="newLink"
                   placeholder="https://example.com"
                   class="flex-1 border rounded p-2"
                   spellcheck="false">
            <button type="button"
                    @click="if (newLink.trim()) { links.push(newLink.trim()); newLink = ''; }"
                    :disabled="!newLink.trim()"
                    :class="newLink.trim() ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-300 cursor-not-allowed'"
                    class="px-4 py-2 rounded text-white transition"
                    aria-label="Add link">+</button>
        </div>
    </fieldset>

    <!-- Status -->
    <x-status-selector :default="$idea->status->value ?? 'pending' " />

    <!-- Submit -->
    <div class="flex justify-center">
        <button type="submit"
                data-test="submit-button"
                @click="$dispatch('close-modal')"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            {{ $idea ? 'Update Idea' : 'Create Idea' }}
        </button>
    </div>
</form>
