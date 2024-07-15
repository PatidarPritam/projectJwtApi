<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    // Specify the table associated with the model
    protected $table = 'password_resets';

    // Specify the primary key (use 'email' as the key if it's unique)
    protected $primaryKey = 'email'; // If using composite keys, adjust accordingly

    // Indicate that the primary key is not an incrementing integer
    public $incrementing = false;

    // Set the key type to string (if using 'email' as primary key, it's typically a string)
    protected $keyType = 'string';

    // Allow mass assignment for these attributes
    protected $fillable = ['email', 'token', 'created_at'];

    // Disable timestamps if you don't want to use created_at and updated_at
    public $timestamps = false;
}
