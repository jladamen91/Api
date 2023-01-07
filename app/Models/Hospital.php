<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Hospital
 * 
 * @property int $id
 * @property string $Nombre
 * @property string $direccion
 * @property string $telefono
 * @property string $estado
 *
 * @package App\Models
 */
class Hospital extends Model
{
	protected $table = 'hospital';
	public $timestamps = false;

	protected $fillable = [
		'Nombre',
		'direccion',
		'telefono',
		'estado'
	];
}
