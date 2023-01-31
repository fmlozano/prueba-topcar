<?php

namespace App\Http\Controllers;

use App\Services\ReportGeneratorService;
use Throwable;

class ReportGenerateController extends Controller
{
    public function __construct(private readonly ReportGeneratorService $reportGeneratorService)
    {
    }

    public function generateReport()
    {
        $initialDate = '02-01-2023';
        $endDate = '04-01-2023';
        try {
            $result = $this->reportGeneratorService->generate($initialDate, $endDate);
        } catch (Throwable $error) {
            return response($error->getMessage(), 400);
        }
        if (!$result) return response(status: 404);
        return response(status: 201);
    }
}
