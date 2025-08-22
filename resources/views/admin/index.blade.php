@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h2>Articles</h2>
                        </div>
                        <div class="col d-flex justify-content-end">
                            <a href="{{ route('admin.create') }}" class="btn btn-primary">Create</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach ($articles as $article)
                    <div class="card mb-3"> 
                        <div class="card-header">
                            <h5>{{ $article->title }}</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('admin.show', $article->id) }}" class="btn btn-link">Selengkapnya</a>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <a href="{{ route('admin.edit', $article->id) }}" class="btn btn-outline-success">Edit</a>
                                </div>
                                <div class="col">
                                    <form id="delete-form-{{ $article->id }}" action="{{ route('admin.destroy', $article->id) }}" method="POST" style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $article->id }})">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>      
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function confirmDelete(articleId) {
        if (confirm('Are you sure you want to delete this article?')) {
            document.getElementById('delete-form-' + articleId).submit();
        }
    }
</script>
