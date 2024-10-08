<div class="form-group">
    <label for="current_image">Current Avatar:</label><br>
    @if($avatar)
        <img src="{{ asset('storage/images/' . $avatar) }}" alt="Current Avatar" style="max-width: 200px;">
    @else
        <p>No current avatar found.</p>
    @endif
</div>
