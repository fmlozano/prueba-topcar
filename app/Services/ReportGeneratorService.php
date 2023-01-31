<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use Sabre\Xml\Service as XmlService;
use ZipArchive;

class ReportGeneratorService
{
    public function __construct(private readonly XmlService $xmlService)
    {
    }

    /**
     * Generate a compressed xml file, encoded in base64, with a list of contracts, vehicles and customer between two dates
     * and store the file in Reports table.
     */
    public function generate(string $initialDate, string $finalDate): bool
    {
        $contracts = $this->getContractsBetween($initialDate, $finalDate);
        $xmlReport = $this->generateXml($contracts);
        $compresedReport = $this->compressReport($xmlReport);
        $encodedReport = $this->encodeReport($compresedReport);
        return $this->saveReport($encodedReport, $initialDate, $finalDate);
    }

    private function getContractsBetween(string $initialDate, string $finalDate): Collection
    {
        $startDate = Carbon::createFromFormat('d-m-Y', $initialDate)->startOfDay();
        $endDate = Carbon::createFromFormat('d-m-Y', $finalDate)->endOfDay();
        return Contract::whereBetween('date_start', [$startDate, $endDate])->get();
    }

    private function generateXml(Collection $contracts): string
    {
        $toXmlFormat = function (Contract $contract) {
            $customer = $contract->customer->toArray();
            $vehicle = $contract->vehicle->makeHidden(['km'])->toArray();
            $contract = $contract->makeHidden(['customer_id', 'customer', 'vehicle', 'km_return'])->toArray();
            return ['communication' => [
                'customer' => $customer,
                'contract' => $contract,
                'vehicle' => $vehicle,
            ]];
        };
        $communications = $contracts->map($toXmlFormat)->toArray();
        $xmlTemplate = [
            'nombreApellidosCandidato' => 'Francisco Manuel Lozano Píriz',
            $communications
        ];
        $this->xmlService->namespaceMap = [
            'http://www.prueba-back-end.topcar.es' => 'alt',
        ];
        return $this->xmlService->write('alt:peticion', $xmlTemplate);
    }

    private function compressReport(string $report): string
    {
        $reportName = 'report.zip';
        $zip = new ZipArchive();
        $zip->open($reportName, ZipArchive::CREATE);
        $zip->addFromString('report.xml', $report);
        $zip->close();
        $compressedFile = File::get($reportName);
        File::delete($reportName);
        return $compressedFile;
    }

    private function encodeReport(string $file): string
    {
        return base64_encode($file);
    }

    private function saveReport(string $file, string $initialDate, string $finalDate): bool
    {
        $report = Report::create([
            'file' => $file,
            'date_start' => Carbon::createFromFormat('d-m-Y', $initialDate)->startOfDay(),
            'date_end' => Carbon::createFromFormat('d-m-Y', $finalDate)->endOfDay(),
        ]);
        return $report->save();
    }
}
