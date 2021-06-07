<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportImage extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "report_images";
    protected $guarded = [];
}
