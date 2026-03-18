<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function personal()
    {
        return $this->hasOne(Personal::class, 'userID', 'id');
    }

    /**
     * AdminLTE methods for user profile menu
     */
    public function adminlte_image()
    {
        if ($this->personal && $this->personal->fotoPersonal) {
            return asset($this->personal->fotoPersonal);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    public function adminlte_desc()
    {
        if ($this->personal) {
            return $this->personal->tipoPersonal . ($this->personal->profesionPersonal ? ' - ' . $this->personal->profesionPersonal : '');
        }
        return $this->roles->pluck('name')->first() ?? 'Usuario del Sistema';
    }

    public function adminlte_profile_url()
    {
        if ($this->personal) {
            return 'admin/personal/show/' . $this->personal->idPersonal;
        }
        return 'admin/configuraciones';
    }
}
