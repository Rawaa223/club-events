{{-- Partial shared by create and edit. Needs $event and $members. --}}
@if ($errors->any())
    <div class="alert alert-error">Please fix the errors below.</div>
@endif

<div class="field @error('title') has-error @enderror">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}">
    @error('title') <p class="error">{{ $message }}</p> @enderror
</div>

<div class="field @error('description') has-error @enderror">
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="4">{{ old('description', $event->description) }}</textarea>
    @error('description') <p class="error">{{ $message }}</p> @enderror
</div>

<div class="row">
    <div class="field @error('location') has-error @enderror">
        <label for="location">Location</label>
        <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}">
        @error('location') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field @error('starts_at') has-error @enderror">
        <label for="starts_at">Date and time</label>
        <input type="datetime-local" id="starts_at" name="starts_at"
               value="{{ old('starts_at', $event->starts_at?->format('Y-m-d\TH:i')) }}">
        @error('starts_at') <p class="error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="row">
    <div class="field @error('capacity') has-error @enderror">
        <label for="capacity">Capacity</label>
        <input type="number" id="capacity" name="capacity" min="1" value="{{ old('capacity', $event->capacity) }}">
        @error('capacity') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="field @error('organizer_id') has-error @enderror">
        <label for="organizer_id">Organizer</label>
        <select id="organizer_id" name="organizer_id">
            <option value="">— choose a member —</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}" @selected(old('organizer_id', $event->organizer_id) == $member->id)>
                    {{ $member->name }}
                </option>
            @endforeach
        </select>
        @error('organizer_id') <p class="error">{{ $message }}</p> @enderror
    </div>
</div>

@php
    // Members ticked: the old input after a failed validation, otherwise the saved attendees.
    $selected = collect(old('attendees', $event->exists ? $event->attendees->pluck('id')->all() : []))
        ->map(fn ($id) => (int) $id);
@endphp

<div class="field @error('attendees') has-error @enderror">
    <label for="attendees">Attendees <span class="muted">(Ctrl/Cmd + click to select several)</span></label>
    <select id="attendees" name="attendees[]" multiple size="8">
        @foreach ($members as $member)
            <option value="{{ $member->id }}" @selected($selected->contains($member->id))>{{ $member->name }}</option>
        @endforeach
    </select>
    @error('attendees') <p class="error">{{ $message }}</p> @enderror
    @error('attendees.*') <p class="error">{{ $message }}</p> @enderror
</div>
