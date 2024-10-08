<div class="form-group">
    <label for="current_image">Current Logo:</label><br>
    @if($logo)
        <img src="{{ asset('storage/logo/' . $logo) }}" alt="Current Logo" style="max-width: 200px;">
    @else
        <p>No current logo found.</p>
    @endif
</div>
