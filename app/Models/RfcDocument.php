<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RfcDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rfc_documents';

    protected $fillable = [
        'code',
        'change_name',
        'request_date',
        'required_date',
        'requester_name',
        'requester_unit',
        'requester_role',
        'requester_phone',
        'requester_email',
        'manager_name',
        'manager_unit',
        'manager_role',
        'manager_phone',
        'manager_email',
        'is_scheduled',
        'priority',
        'status',
        'summary_description',
        'risk_assessments',
        'characteristics',
        'work_plan_roles',
        'work_schedule',
        'work_schedule_total_time',
        'work_schedule_observations',
        'acceptance_tests',
        'rollback_plan_description',
        'rollback_criteria',
        'rollback_responsible',
        'rollback_schedule',
        'rollback_total_time',
        'general_observations',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'is_scheduled' => 'boolean',
        'request_date' => 'datetime',
        'required_date' => 'datetime',
        'approved_at' => 'datetime',
        'risk_assessments' => 'array',
        'characteristics' => 'array',
        'work_plan_roles' => 'array',
        'work_schedule' => 'array',
        'acceptance_tests' => 'array',
        'rollback_schedule' => 'array',
    ];

    /**
     * Scope para filtrar por estado
     */
    public function scopeByStatus($query, ?string $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope para filtrar por prioridad
     */
    public function scopeByPriority($query, ?string $priority)
    {
        if ($priority && $priority !== 'all') {
            return $query->where('priority', $priority);
        }
        return $query;
    }

    /**
     * Scope para búsqueda por término
     */
    public function scopeSearch($query, ?string $term)
    {
        if (!empty($term)) {
            return $query->where(function ($q) use ($term) {
                $q->where('code', 'like', "%{$term}%")
                  ->orWhere('change_name', 'like', "%{$term}%")
                  ->orWhere('requester_name', 'like', "%{$term}%")
                  ->orWhere('manager_name', 'like', "%{$term}%")
                  ->orWhere('summary_description', 'like', "%{$term}%");
            });
        }
        return $query;
    }
}
