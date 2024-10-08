<div class="form-group">
    <label for="current_image">Current Image:</label><br>
    @if($image)
        <img src="{{ asset('storage/image/' . $image) }}" alt="Current Image" style="max-width: 200px;">
    @else
        <p>No current image found.</p>
    @endif
</div>
