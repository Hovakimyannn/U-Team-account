<?php

namespace App\Services\Auth;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Closure;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Support\Arrayable;

class MultiUserProvider extends EloquentUserProvider
{
    public function __construct(HasherContract $hasher, $model = null)
    {
        parent::__construct($hasher, $model);
    }

    public function retrieveById($credentials)
    {
        $this->setModel($credentials['role']);
        $model = $this->createModel();

        return $this->newModelQuery($model)
            ->where($model->getAuthIdentifierName(), $credentials['id'])
            ->first();
    }

    public function retrieveByToken($identifier, $token)
    {
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $this->setModel($credentials['role']);

        $credentials = array_filter(
            $credentials,
            fn($key) => !preg_match('/^(password|role)/', $key),
            ARRAY_FILTER_USE_KEY
        );

        if (empty($credentials)) {
            return null;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } elseif ($value instanceof Closure) {
                $value($query);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }

    /**
     * Sets the name of the Eloquent user model.
     *
     * @param string $model
     *
     * @return $this
     */
    public function setModel($model) : static
    {
        $this->model = match ($model) {
            'student' => Student::class,
            'teacher' => Teacher::class,
            'admin' => Admin::class
        };

        return $this;
    }

    /**
     * get current user role
     *
     * @return string
     */
    public function getRole(): string
    {
        return strtolower(last(explode('\\',$this->model)));
    }
}
