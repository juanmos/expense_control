<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\CanResetPassword;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use App\Models\Alumno;
use App\Models\DatosFacturacion;
use App\Models\Institucion;
use App\Models\Tarjeta;
use App\Models\Transaccion;
use App\Models\Refrigerio;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','apellido', 'email', 'password','telefono','celular','facebook_id','token_and',
        'token_ios','institucion_id','foto','activo','primer_login','latitud','longitud','cedula',
        'fecha_nacimiento','saldo','credito','monto_credito'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','codigo','facebook_id','token_and','token_ios','email_verified_at',
        'saldo','credito','monto_credito'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    public function alumno()
    {
        return $this->hasOne(Alumno::class, 'usuario_id');
    }

    public function tarjetas()
    {
        return $this->hasMany(Tarjeta::class, 'usuario_id');
    }

    public function transacciones()
    {
        return $this->morphMany(Transaccion::class, 'transaccionable');
    }

    public function refrigerio()
    {
        return $this->morphMany(Refrigerio::class, 'userable');
    }

    public function datosFacturacion()
    {
        return $this->hasMany(DatosFacturacion::class, 'usuario_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function getTelefonosAttribute()
    {
        return "Cel: {$this->celular} Telf: {$this->telefono}";
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function routeNotificationForFcm()
    {
        return $this->token_and;
    }

    public function routeNotificationForApn()
    {
        return $this->token_ios;
    }
}
