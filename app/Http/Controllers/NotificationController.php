<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

/**
 * Handles notification management
 * 
 * This controller manages system notifications including:
 * - Retrieving notifications with their related appointments
 * - Grouping notifications by date (today/earlier)
 * - Marking notifications as read
 * - Bulk deletion of notifications
 */
class NotificationController extends Controller
{
    /**
     * Get all notifications grouped by date
     * 
     * Retrieves notifications and:
     * - Groups them by today/earlier
     * - Includes related appointment data
     * - Counts unread notifications
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $notifications = Notification::with('appointment')
            ->latest()
            ->get()
            ->groupBy(function($notification) {
                return $notification->created_at->isToday() ? 'today' : 'earlier';
            });

        $unreadCount = Notification::where('is_read', false)->count();

        return response()->json([
            'notifications' => $notifications,
            'count' => $unreadCount
        ]);
    }

    /**
     * Mark a notification as read
     * 
     * @param int $id Notification ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete all notifications
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteAll()
    {
        try {
            Notification::truncate();
            return response()->json([
                'success' => true,
                'message' => 'All notifications deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete notifications'
            ], 500);
        }
    }
}