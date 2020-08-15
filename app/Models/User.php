<?php


namespace App\Models;


class User extends Model
{
    const PRIVILEGES_ADMINISTRATOR = 2;

    public $id;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $active;
    public $privileges;

    private $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'active',
        'privileges',
        'created_at',
        'updated_at'
    ];

    public function create($attributes)
    {
        $sql = sprintf(
            'INSERT INTO %s (%s) values (%s)',
            'users',
            implode(',', array_keys($attributes)),
            ':' . implode(', :', array_keys($attributes))
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();

            $statement->execute($attributes);
            $lastInsertedId = $this->pdo->lastInsertId();

            $this->pdo->commit();

            return $this->find($lastInsertedId);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function update($attributes, $userId)
    {
        $fields = '';

        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable) && !empty($value)) {
                $fields .= "{$key} = :{$key}, ";
            }
        }

        $fields = rtrim(trim($fields), ',');

        $sql = sprintf(
            'UPDATE %s SET %s WHERE id = %s',
            'users',
            $fields,
            $userId
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();

            $statement->execute(array_filter($attributes));

            $this->pdo->commit();

            return $statement->rowCount();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function isAdmin()
    {
        if ($this->privileges == 0) {
            return false;
        }

        return $this->privileges % self::PRIVILEGES_ADMINISTRATOR === 0;
    }

    public function getNames()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function delete($bookId)
    {
        $sql = sprintf(
            'DELETE FROM %s WHERE id = (%s)',
            'books',
            $bookId
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $this->pdo->beginTransaction();

            $statement->execute();
            $deletedRecords = $statement->rowCount();

            $this->pdo->commit();

            return $deletedRecords;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function find($id)
    {
        $sql = sprintf('SELECT * FROM %s WHERE %s = %s', 'users', 'id', $id);

        $statement = $this->pdo->query($sql);

        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_CLASS, User::class)[0];
    }

    public function login($email)
    {
        $sql = sprintf('SELECT * FROM %s WHERE %s = \'%s\'', 'users', 'email', $email);

        $statement = $this->pdo->query($sql);

        if (!$statement->rowCount()) {
            return null;
        }

        return $statement->fetchAll(\PDO::FETCH_CLASS, User::class)[0];
    }

    public function list()
    {
        $sql =  sprintf('SELECT * FROM %s', 'books');
        $statement = $this->pdo->query($sql);

        return $statement->fetchAll(\PDO::FETCH_CLASS, Book::class);
    }

    public function getImage()
    {
        return str_replace('\\', '/', self::IMAGE_DIRECTORY . $this->id . DIRECTORY_SEPARATOR . $this->image);
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
