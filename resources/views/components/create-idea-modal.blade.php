<form method="POST"
      action="{{ route('ideas.store') }}"
      class="space-y-6"
        x-data="{ links: [], newLink: '', steps: [], newStep: '' }">

    @csrf

    <!-- Title -->
    <x-field type="text"
             name="title"
             label="Title"
             placeholder="Enter an idea"
             data-test="title-input" />

    <!-- Description -->
    <x-field type="textarea"
             name="description"
             label="Description"
             placeholder="Describe your idea"
             data-test="description-input" />

   <fieldset class="space-y-3">
    <legend class="text-sm font-medium text-gray-700">Actionable Steps</legend>

    <template x-for="(step, index) in steps" :key="step">
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
        <template x-for="(link, index) in links" :key="link">
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
    <x-status-selector default="pending" />

    <!-- Submit -->
    <div class="flex justify-center">
        <button type="submit"
                data-test="submit-button"
                @click="dispatch('close-modal')"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Create Idea
        </button>
    </div>
</form>
