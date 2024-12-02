<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['login', 'pass', 'email', 'roleid', 'avatar'];
    protected $returnType = 'array';

    protected $validationRules = [
        'login' => 'required|alpha_numeric|min_length[3]|is_unique[users.login,id,{id}]',
        'pass'  => 'required|min_length[8]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
    ];

    protected $validationMessages = [
        'login' => [
            'required' => 'Login is required.',
            'alpha_numeric' => 'Login can only contain alphanumeric characters.',
            'min_length' => 'Login must be at least 3 characters long.',
            'is_unique' => 'This login is already taken.'
        ],
        'pass' => [
            'required' => 'Password is required.',
            'min_length' => 'Password must be at least 8 characters long.'
        ],
        'email' => [
            'required' => 'Email is required.',
            'valid_email' => 'Please provide a valid email address.',
            'is_unique' => 'This email is already registered.'
        ],
    ];

    public function findByLogin(string $login)
    {
        return $this->where('login', $login)->first();
    }

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    public function updateRole(int $userId, int $roleId)
    {
        return $this->update($userId, ['roleid' => $roleId]);
    }

    protected function beforeInsert(array $data)
    {
        if (isset($data['data']['pass']) && !empty($data['data']['pass'])) {
            $data['data']['pass'] = password_hash($data['data']['pass'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        if (isset($data['data']['pass']) && !empty($data['data']['pass'])) {
            $data['data']['pass'] = password_hash($data['data']['pass'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}