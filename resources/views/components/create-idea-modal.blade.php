<form method="POST" action="{{ route('ideas.store') }}" class="space-y-6">
    @csrf
    <x-field
    data-test="title-input"
    type="text"
    name="title"
    label="Title"
    placeholder="Enter an idea" />

    <x-field
    data-test="description-input"
    type="textarea"
    name="description"
    label="Description"
    placeholder="Describe your idea" />

    <div class="space-y-2">
      <x-status-selector default="pending" />

      <div class="flex justify-center">
        <button data-test="submit-button" type="submit" class="px-6 py-2 bg-blue-600 text-white rounded"> Create Idea</button>
      </div>
    </div>
</form>
