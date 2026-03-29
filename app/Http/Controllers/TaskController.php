<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // 1. CREATE TASK
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
        ]);

        // Check duplicate title on same due_date
        $exists = Task::where('title', $request->title)
                      ->where('due_date', $request->due_date)
                      ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'A task with this title already exists for this due date.'
            ], 422);
        }

        $task = Task::create([
            'title'    => $request->title,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
            'status'   => 'pending',
        ]);

        return response()->json($task, 201);
    }

    // 2. LIST TASKS
    public function index(Request $request)
    {
        $query = Task::query();

        // Optional status filter
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Sort by priority (high→medium→low) then due_date ascending
        $tasks = $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
                       ->orderBy('due_date', 'asc')
                       ->get();

        if ($tasks->isEmpty()) {
            return response()->json([
                'message' => 'No tasks found.',
                'tasks'   => []
            ], 200);
        }

        return response()->json($tasks, 200);
    }

    // 3. UPDATE STATUS
    public function updateStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $transitions = [
            'pending'     => 'in_progress',
            'in_progress' => 'done',
        ];

        if (!isset($transitions[$task->status])) {
            return response()->json([
                'message' => 'This task is already done. Status cannot be changed.'
            ], 422);
        }

        $task->status = $transitions[$task->status];
        $task->save();

        return response()->json($task, 200);
    }

    // 4. DELETE TASK
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if ($task->status !== 'done') {
            return response()->json([
                'message' => 'Only done tasks can be deleted.'
            ], 403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully.'
        ], 200);
    }

    // 5. DAILY REPORT (BONUS)
    public function report(Request $request)
    {
        $date = $request->query('date', now()->toDateString());

        $tasks = Task::whereDate('due_date', $date)->get();

        $priorities = ['high', 'medium', 'low'];
        $statuses   = ['pending', 'in_progress', 'done'];

        $summary = [];

        foreach ($priorities as $priority) {
            foreach ($statuses as $status) {
                $summary[$priority][$status] = $tasks
                    ->where('priority', $priority)
                    ->where('status', $status)
                    ->count();
            }
        }

        return response()->json([
            'date'    => $date,
            'summary' => $summary,
        ], 200);
    }
}