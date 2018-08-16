@extends('layout')

@section('title', 'Open Source Charitable Giving')

@section('content')
    <section class="card">
        <div class="card-header">
            <h2>Select your repository</h2>
        </div>
        <div class="card-list">
            @foreach ($repos as $repo)
                @if ($repo['size'] > 0)
                    <div class="list-item">

                        <div class="details">
                            {{ $repo['full_name'] }}
                            <br/>
                            @if ($repo['description'])
                                <small>{{ $repo['description'] }}</small>
                            @endif

                            @if ($repo['topics'])
                                <div class="topics">
                                    @foreach ($repo['topics'] as $topic)
                                        <span class="topic">{{ $topic }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="status">
                            <a href="" class="btn btn-green btn-icon">
                                <i class="fas fa-fw fa-thumbs-up"></i>
                            </a>
                        </div>

                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection