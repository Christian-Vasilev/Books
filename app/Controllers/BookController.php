<?php


namespace App\Controllers;

use App\Libraries\ValidateRequest;
use App\Libraries\ValidationRules;
use App\Models\Book;

class BookController
{
    public function create()
    {
        return view('books/create');
    }

    public function store()
    {
        if (!$this->validate($_POST)) {
            return redirect('/books/create');
        }

        try {
            $imageName = basename($_FILES['image']['name']);

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

    private function validate($fields)
    {
        $fields = array_merge($fields,['file' => $_FILES]);

        $description = $fields['description'];
        $name = $fields['name'];
        $image = $fields['file']['image'];

        return ValidateRequest::validate([
            'name' => [
                ValidationRules::required($name),
                ValidationRules::min($name, 3)
            ],
            'description' => [
                ValidationRules::required($description),
                ValidationRules::min($description, 5)
            ],
            'image' => [
                ValidationRules::mime($image, ['image/png', 'image/jpeg', 'image/gif']),
                ValidationRules::image($image),
            ]
        ]);
    }
}