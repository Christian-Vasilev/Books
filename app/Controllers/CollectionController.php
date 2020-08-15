<?php


namespace App\Controllers;

use App\Libraries\Auth;
use App\Libraries\ValidateRequest;
use App\Libraries\ValidationRules;
use App\Models\BookUser;
use App\Models\User;

class CollectionController
{
    public function store()
    {
        if (!Auth::user()) {
            return redirect('/');
        }

        $bookId = $_POST['book_id'];

        if (!$this->validate($_POST)) {
            return redirect("/books/show?book_id={$bookId}");
        }

        // Create a new booking record
        (new BookUser())->create([
            'user_id' => Auth::user()->id,
            'book_id' => $bookId,
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);


        return redirect("/books/show?book_id={$bookId}");
    }

    public function show()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/');
        }

        $books = (new User())->books();

        return view('collections/show', [
            'books' => $books,
            'user' => $user
        ]);
    }

    public function delete()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/');
        }

        (new BookUser())->delete($_POST['book_id']);

        return redirect('/collection/show');
    }

    private function validate($fields)
    {
        $bookId = $fields['book_id'];
        $token = $fields['token'];

        return ValidateRequest::validate([
            'token' => [
                ValidationRules::isValidToken($token)
            ],
            'book_id' => [
                ValidationRules::required($bookId),
            ]
        ]);
    }
}