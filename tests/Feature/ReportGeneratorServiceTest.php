<?php

namespace Tests\Feature;

use App\Services\ReportGeneratorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class ReportGeneratorServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_report()
    {
        $this->mock(ReportGeneratorService::class, function (MockInterface $mock) {
            $initialDate = '02-01-2023';
            $finalDate = '04-01-2023';
            $mock->shouldReceive('generate')
                ->with($initialDate, $finalDate)
                ->once()
                ->andReturn(true);
        });
    }
}
