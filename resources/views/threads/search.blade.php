@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <ais-index
                    app-id="{{ config('scout.algolia.id') }}"
                    api-key="{{ config('scout.algolia.key') }}"
                    index-name="threads"
                    query="{{ request('q') }}"
            >
                <div class="col-md-8">
                    <h1 style="color: black">Search Results</h1>
                    <ais-results>
                        <template slot-scope="{ result }">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a :href="result.path">
                                        <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                    </a>
                                </div>

                                <div class="panel-body">
                                    <ais-highlight :result="result" attribute-name="body"></ais-highlight>
                                </div>
                            </div>
                        </template>
                    </ais-results>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Search
                        </div>

                        <div class="panel-body">
                            <ais-search-box>
                                <div class="input-group">
                                    <ais-input
                                        placeholder="Search threads..."
                                        :class-names="{'ais-input': 'form-control'}">
                                    </ais-input>

                                    <span class="input-group-btn">
                                        <ais-clear :class-names="{'ais-clear': 'btn btn-primary'}">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </ais-clear>
                                    </span>
                                </div>
                            </ais-search-box>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Filter By Channel
                        </div>

                        <div class="panel-body">
                            <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Trending Threads
                        </div>

                        <ul class="list-group">
                            @foreach ($trending as $thread)
                                <li class="list-group-item">
                                    <a href="{{ url($thread->path) }}">
                                        {{ $thread->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </ais-index>
        </div>
    </div>
@endsection
