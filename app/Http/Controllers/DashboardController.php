<?php

namespace App\Http\Controllers;

use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Unified Dashboard Controller delegating directly to AdminDashboard Cockpit.
     */
    public function index(): Response
    {
        return app(SuperAdminDashboardController::class)->index();
    }
}
