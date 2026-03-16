<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if (!Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->boolean('remember'))) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $request->session()->regenerate();
            $user = Auth::user();

            return response()->json([
                'user' => $user,
                'message' => 'Login successful'
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Login failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        $this->logAuditTrail($request, 'logout', 'success', 'User logged out');
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout successful']);
    }

    /**
     * Get authenticated user details.
     */
    public function me(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        
        try {
            // Try to load relationships, but handle if they don't exist
            $userWithRelations = $user->load(['roles', 'company', 'employee']);
            return response()->json($userWithRelations);
        } catch (\Exception $e) {
            // If relationships fail, return user without them
            return response()->json($user);
        }
    }

    /**
     * Log audit trail for authentication events.
     */
    private function logAuditTrail(Request $request, string $action, string $status, string $description)
    {
        AuditLog::create([
            'user_id' => Auth::id() ?: null,
            'company_id' => Auth::user()?->company_id,
            'action' => $action,
            'module' => 'authentication',
            'description' => $description,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now(),
            'risk_level' => $status === 'failed' ? 'medium' : 'low',
            'is_suspicious' => $status === 'failed',
        ]);
    }
}
