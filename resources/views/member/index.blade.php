@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h2 class="text-center mb-4">Articles</h2>

            @foreach ($articles as $article)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ $article->title }}</h5>
                    </div>
                    <div class="card-body">
                        <p>{!! nl2br(e(Str::limit(strip_tags($article->content), 300))) !!}</p>
                        <a href="{{ route('member.article.show', $article->id) }}" class="btn btn-outline-primary btn-sm">Selengkapnya</a>
                    </div>
                    <div class="card-footer bg-light">
                        <h6>Komentar</h6>
                        @forelse ($article->comments as $comment)
                            <div class="mb-2 p-2 border rounded bg-white">
                                <strong>{{ $comment->user->name }}</strong>
                                <small class="text-muted ml-2">{{ $comment->created_at->diffForHumans() }}</small>
                                <p class="mb-0">{{ $comment->comment }}</p>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Belum ada komentar.</p>
                        @endforelse

                        {{-- Form komentar baru --}}
                        <form action="{{ route('comment.store') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <textarea name="comment" class="form-control mb-2" rows="2" placeholder="Tulis komentar..."></textarea>
                            <button class="btn btn-primary btn-sm">Kirim</button>
                        </form>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
