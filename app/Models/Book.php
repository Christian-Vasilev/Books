<?php


namespace App\Models;


class Book extends Model
{
    const IMAGE_DIRECTORY = APP_ROOT . 'uploads' . DIRECTORY_SEPARATOR;

    public $description;
    public $name;
    public $id;
    protected $isbn;
    public $image;
    private $fillable = [
        'name',
        'isbn',
        'description',
        'image',
        'created_at',
        'updated_at'
    ];

    public function create($attributes)
    {
        $this->generateUniqueIsbn();
        $attributes = array_merge($attributes, ['isbn' => $this->isbn]);

        $sql = sprintf(
            'INSERT INTO %s (%s) values (%s)',
            'books',
            implode(',', array_keys($attributes)),
            ':' . implode(', :', array_keys($attributes))
        );

        $statement = $this->pdo->prepare($sql);

        $statement->execute($attributes);
        $lastInsertedId = $this->pdo->lastInsertId();

        return $this->find($lastInsertedId);
    }
    public function update($attributes, $bookId)
    {
        $updateValues = '';
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable) && !empty($value)) {
                $updateValues .= "{$key} = :{$key}, ";
            }
        }

        $updateValues = rtrim(trim($updateValues), ',');

        $sql = sprintf(
            'UPDATE %s SET %s WHERE id = %s',
            'books',
            $updateValues,
            $bookId
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array_filter($attributes));

        return $statement->rowCount();
    }

    public function delete($bookId)
    {
        $sql = sprintf(
            'DELETE FROM %s WHERE id = (%s)',
            'books',
            $bookId
        );

        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        return  $statement->rowCount();
    }

    public function find($id)
    {
        $sql =  sprintf('SELECT * FROM %s WHERE %s = %s', 'books', 'id', $id);
        $statement = $this->pdo->query($sql);

        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_CLASS, Book::class)[0];
    }

    public function list()
    {
        $sql =  sprintf('SELECT * FROM %s', 'books');
        $statement = $this->pdo->query($sql);

        return $statement->fetchAll(\PDO::FETCH_CLASS, Book::class);
    }

    public function getImage()
    {
        return str_replace('\\', '/', '/uploads/'. $this->id . DIRECTORY_SEPARATOR . $this->image);
    }

    /**
     * Generate Unique ISBN ID until there are no results matching the key
     *
     * @return $this
     * @throws \Exception
     */
    public function generateUniqueIsbn()
    {
        $isbn = null;

        do {
            $isbn = mt_rand(1000000000,9999999999);
            $statement = $this->pdo->prepare('SELECT COUNT(*) FROM books WHERE isbn = :isbn');
            $statement->execute(['isbn' => $isbn]);

        } while ($res = $statement->fetch()[0]);

        return $this->isbn = $isbn;
    }
}
