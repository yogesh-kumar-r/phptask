<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function borrow(Request $request, $bookId, $userId)
    {
        // Check if the user has already borrowed 3 books
        $user = User::findOrFail($userId);
        if ($user->borrowedBooks()->count() >= 3) {
            return response()->json(['message' => 'User cannot borrow more than 3 books.'], 403);
        }

        // Check if the book is already borrowed
        $book = Book::findOrFail($bookId);
        if ($book->borrowers()->count() > 0) {
            return response()->json(['message' => 'Book is already borrowed.'], 403);
        }

        // Borrow the book
        $user->borrowedBooks()->attach($bookId, ['borrowed_at' => now()]);

        return response()->json(['message' => 'Book borrowed successfully.']);
    }

    public function return(Request $request, $bookId)
    {
        // Find the book
        $book = Book::findOrFail($bookId);

        // Mark the book as returned
        $book->borrowers()->detach($userId, ['returned_at' => now()]);

        return response()->json(['message' => 'Book returned successfully.']);
    }
}