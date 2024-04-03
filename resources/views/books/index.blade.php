@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-10 text-2x1">Books</h1>
        <hr class="mb-10">
        <div class="mb-10">
            <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
        </div>
        <hr class="mb-10">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Rating</th>
                <th colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr class="book-item">
                    <td><a href="{{ route('books.show', $book) }}">{{$book->title}}</a></td>
                    <td>{{ $book->author }}</td>
                    <td>
                        <div class="book-rating">
                            {{ number_format($book->reviews_avg_rating, 1) }}
                        </div>
                        <div class="book-review-count">
                            out of {{ $book->reviews_count ?? 0 }} {{ Str::plural('review', $book->reviews_count) }}
                        </div>
                    </td>
                    <td colspan="2">
                        <a href="{{ route('books.edit', $book) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @empty($books)
                <tr>
                    <td colspan="4">
                        <div class="empty-book-item">
                            <p class="empty-text>">No books found.</p>
                            <a href="{{ route('books.index') }}" class="reset-link">Reset criteria.</a>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
