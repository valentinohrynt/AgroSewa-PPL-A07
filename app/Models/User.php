<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'email',
        'role_id',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected $attributes = [
        'role_id' => 3,
    ];

    public static function getDataUserbyId($id)
    {
        $DataUserbyId = static::findOrFail($id);
        return $DataUserbyId;
    }

    public static function getDataNewUser()
    {
        $DataNewVerifiedUser = static::whereDate('created_at', now()->toDateString())->get();
        return $DataNewVerifiedUser;
    }

    public static function getAllDataUser()
    {
        $AllDataUser = static::all();
        return $AllDataUser;
    }

    public static function putDataUser($id, $newUsername, $newPassword, $newEmail)
    {
        $user = static::where('id', $id)->first();
        $data = [
            'username' => $newUsername,
            'email' => $newEmail
        ];

        if (!empty($newPassword)) {
            $data['password'] = Hash::make($newPassword);
        }

        $user->update($data);
    }
    public static function postDataUser($username, $password, $email, $role_id)
    {
        $user = static::create(
            [
                'username' => $username,
                'password' => Hash::make($password),
                'email' => $email,
                'role_id' => $role_id
            ]
        );
        return $user->id;
    }

    public static function patchStatustoInactive($id)
    {
        $user = static::findOrFail($id);
        $user->update(
            [
                'status' => 'inactive'
            ]
        );
    }

    public function borrowers()
    {
        return $this->hasMany(Borrower::class, 'user_id');
    }
}
