@component('profiles.activities.activity')
    @slot('heading')
        <a href="">
            {{ $profileUser->name }} favourited a reply
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->favourited->body }}
    @endslot
@endcomponent
