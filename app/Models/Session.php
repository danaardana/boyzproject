<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Session extends Model
{
    protected $table = 'sessions';
    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false; // Sessions table doesn't use standard timestamps

    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity'
    ];

    protected $casts = [
        'last_activity' => 'integer',
    ];

    /**
     * Create a new admin login session record
     */
    public static function logAdminLogin($admin, $request)
    {
        $sessionData = [
            'id' => session()->getId(),
            'user_id' => $admin->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'payload' => base64_encode(serialize([
                'admin_id' => $admin->id,
                'admin_email' => $admin->email,
                'admin_name' => $admin->name,
                'login_time' => now()->toDateTimeString(),
                'guard' => 'admin',
                '_token' => session()->token(),
                '_flash' => []
            ])),
            'last_activity' => now()->timestamp
        ];

        return self::updateOrCreate(
            ['id' => $sessionData['id']], 
            $sessionData
        );
    }

    /**
     * Get admin login history with proper admin data
     */
    public static function getAdminLoginHistory($adminId = null, $limit = 50)
    {
        $query = DB::table('sessions as s')
            ->leftJoin('admins as a', 's.user_id', '=', 'a.id')
            ->whereNotNull('s.user_id')
            ->whereNotNull('s.ip_address')
            ->select([
                's.id as session_id',
                's.user_id as admin_id', 
                's.ip_address',
                's.user_agent',
                's.last_activity',
                's.payload',
                'a.name as admin_name',
                'a.email as admin_email'
            ])
            ->orderBy('s.last_activity', 'desc');

        if ($adminId) {
            $query->where('s.user_id', $adminId);
        }

        return $query->limit($limit)->get()->map(function ($session) {
            // Try to get login time from payload
            $loginTime = null;
            if ($session->payload) {
                try {
                    $payload = @unserialize(base64_decode($session->payload));
                    $loginTime = $payload['login_time'] ?? null;
                } catch (\Exception $e) {
                    // If payload decoding fails, use last_activity as fallback
                    $loginTime = date('Y-m-d H:i:s', $session->last_activity);
                }
            }
            
            return [
                'session_id' => $session->session_id,
                'admin_id' => $session->admin_id,
                'admin_email' => $session->admin_email ?? 'Unknown',
                'admin_name' => $session->admin_name ?? 'Unknown Admin',
                'ip_address' => $session->ip_address,
                'user_agent' => $session->user_agent,
                'login_time' => $loginTime ?: date('Y-m-d H:i:s', $session->last_activity),
                'last_activity' => date('Y-m-d H:i:s', $session->last_activity),
                'browser' => self::parseBrowser($session->user_agent),
                'platform' => self::parsePlatform($session->user_agent)
            ];
        });
    }

    /**
     * Get current admin's sessions
     */
    public static function getCurrentAdminSessions()
    {
        if (!Auth::guard('admin')->check()) {
            return collect();
        }

        return self::getAdminLoginHistory(Auth::guard('admin')->id());
    }

    /**
     * Parse browser from user agent
     */
    private static function parseBrowser($userAgent)
    {
        if (str_contains($userAgent, 'Chrome')) return 'Chrome';
        if (str_contains($userAgent, 'Firefox')) return 'Firefox';
        if (str_contains($userAgent, 'Safari')) return 'Safari';
        if (str_contains($userAgent, 'Edge')) return 'Edge';
        if (str_contains($userAgent, 'Opera')) return 'Opera';
        
        return 'Unknown';
    }

    /**
     * Parse platform from user agent
     */
    private static function parsePlatform($userAgent)
    {
        if (str_contains($userAgent, 'Windows')) return 'Windows';
        if (str_contains($userAgent, 'Mac')) return 'Mac';
        if (str_contains($userAgent, 'Linux')) return 'Linux';
        if (str_contains($userAgent, 'Android')) return 'Android';
        if (str_contains($userAgent, 'iOS')) return 'iOS';
        
        return 'Unknown';
    }

    /**
     * Clean old sessions (older than 30 days)
     */
    public static function cleanOldSessions()
    {
        $thirtyDaysAgo = now()->subDays(30)->timestamp;
        
        return self::where('last_activity', '<', $thirtyDaysAgo)->delete();
    }

    /**
     * Get session statistics
     */
    public static function getSessionStats()
    {
        $sessions = self::getAdminLoginHistory(null, 500); // Get more data for stats
        
        return [
            'total_sessions' => $sessions->count(),
            'unique_admins' => $sessions->pluck('admin_id')->unique()->count(),
            'browsers' => $sessions->groupBy('browser')->map->count(),
            'platforms' => $sessions->groupBy('platform')->map->count(),
            'recent_logins' => $sessions->take(10)
        ];
    }

    /**
     * Logout and clean session
     */
    public static function logAdminLogout($sessionId = null)
    {
        $sessionId = $sessionId ?? session()->getId();
        
        return self::where('id', $sessionId)->delete();
    }
}
