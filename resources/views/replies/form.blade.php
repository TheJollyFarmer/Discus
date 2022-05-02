<form method="POST" action="{{ $thread->path() . '/replies' }}">
    {{ csrf_field() }}

    {{-- <div v-if="creating"> --}}
        <div class="form-group">
            @if (isset($parentId))
                <input name="parent_id" type="hidden" value="{{ $parentId }}"/>
            @endif

            <label for="body">Reply:</label>
            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
        </div>

        <div>
            <button type="submit" class="btn btn-default">Post</button>
        </div>
</form>
