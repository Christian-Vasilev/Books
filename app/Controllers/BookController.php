<?php


namespace App\Controllers;

use App\Libraries\ValidateRequest;
use App\Libraries\ValidationRules;
use App\Models\Book;

class BookController
{
    public function __construct()
    {

    }

    public function create()
    {
        return view('books/create');
    }

    public function store()
    {
        if (!$this->validate(array_merge($_POST,['file' => $_FILES]))) {
            return redirect('/books/create');
        }

        try {
            $imageName = strtolower(str_replace(' ', '_', basename($_FILES['image']['name'])));

            // Create a new booking record
            $book = (new Book())->create([
                'name' => sanitize($_POST['name']),
                'description' => sanitize($_POST['description']),
                'image' => $imageName,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);

            $directory = Book::IMAGE_DIRECTORY . $book->id . DIRECTORY_SEPARATOR;

            // Create directory if not exist
            file_exists($directory) ? $directory :  mkdir($directory);

            // Create file name and upload it to directory
            $uploadedFile = $directory . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
                throw new \LogicException('File could not be saved!');
            }
        } catch (\Exception $e){
            dd($e->getMessage());
        }

        return view('books/create', ['success' => 'Booking was created successfully!']);
    }

    public function destroy()
    {
        if (!isValidCsrf($_POST['token'])) {
            return redirect('/');
        }

        $deleted = (new Book())->delete($_POST['book_id']);

        if ($deleted) {
            return redirect('/');
        }

        return redirect('/');
    }

    public function show()
    {
        $book = (new Book())->find($_GET['book_id']);

        if (!is_null($book)) {
            return view('/books/show', ['book' => $book]);
        }

        return redirect('/');
    }

    public function edit()
    {
        $book = (new Book())->find($_GET['book_id']);

        if (!is_null($book)) {
            return view('/books/edit', ['book' => $book]);
        }

        return redirect('/');
    }


    public function update()
    {
        $bookId = $_POST['book_id'];

        if (!$this->validate($_POST, true)) {
            return redirect("/books/edit?book_id={$bookId}");
        }

        try {
            $imageName = strtolower(str_replace(' ', '_', basename($_FILES['image']['name'])));

            // Create a new booking record
            $updated = (new Book())->update([
                'name' => sanitize($_POST['name']),
                'description' => sanitize($_POST['description']),
                'image' => $imageName,
                'updated_at' => date('Y-m-d H:i:s', time()),
            ], $bookId);

            $directory = Book::IMAGE_DIRECTORY . $bookId . DIRECTORY_SEPARATOR;

            if(!empty($_FILES['image']['tmp_name']) && $updated) {
                // Delete all files within directory if exists, otherwise create a new directory.
                if (file_exists($directory)) {
                    $files = glob($directory . '*');
                    unlink($files[0]);
                } else {
                    mkdir($directory);
                }

                // Create file name and upload it to directory
                $uploadedFile = $directory . $imageName;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
                    throw new \LogicException('File could not be saved!');
                }
            }

        } catch (\Exception $e){
            dd($e->getMessage());
        }

        return redirect("/books/edit?book_id={$bookId}");
    }

    private function validate($fields, $update = false)
    {
        if (!$update) {
            $image = [
                ValidationRules::mime($fields['file']['image'], ['image/png', 'image/jpeg', 'image/gif']),
                ValidationRules::image($fields['file']['image']),
            ];
        }

        $description = $fields['description'];
        $name = $fields['name'];
        $token = $fields['token'];

        return ValidateRequest::validate([
            'token' => [
                ValidationRules::isValidToken($token)
            ],
            'name' => [
                ValidationRules::required($name),
                ValidationRules::min($name, 3)
            ],
            'description' => [
                ValidationRules::required($description),
                ValidationRules::min($description, 5)
            ],
            'image' => isset($image) ? $image : [],
        ]);
    }
}