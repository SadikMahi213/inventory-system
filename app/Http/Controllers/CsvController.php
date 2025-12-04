<?php

namespace App\Http\Controllers;

use App\Services\CsvService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CsvController extends Controller
{
    protected $csvService;

    public function __construct(CsvService $csvService)
    {
        $this->csvService = $csvService;
    }

    /**
     * Show the import/export page
     *
     * @return View
     */
    public function index(): View
    {
        return view('csv.index');
    }

    /**
     * Export products to CSV
     *
     * @return BinaryFileResponse|RedirectResponse
     */
    public function exportProducts()
    {
        try {
            $filePath = $this->csvService->exportProducts();
            
            return response()->download(storage_path('app/' . $filePath))->deleteFileAfterSend(false);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export products: ' . $e->getMessage());
        }
    }

    /**
     * Import products from CSV
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function importProducts(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240'
        ]);

        try {
            $file = $request->file('file');
            $importedCount = $this->csvService->importProducts($file);
            
            return redirect()->back()->with('success', "Successfully imported {$importedCount} products.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import products: ' . $e->getMessage());
        }
    }

    /**
     * Export purchase records to CSV
     *
     * @return BinaryFileResponse|RedirectResponse
     */
    public function exportPurchaseRecords()
    {
        try {
            $filePath = $this->csvService->exportPurchaseRecords();
            
            return response()->download(storage_path('app/' . $filePath))->deleteFileAfterSend(false);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export purchase records: ' . $e->getMessage());
        }
    }

    /**
     * Import purchase records from CSV
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function importPurchaseRecords(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240'
        ]);

        try {
            $file = $request->file('file');
            $importedCount = $this->csvService->importPurchaseRecords($file);
            
            return redirect()->back()->with('success', "Successfully imported {$importedCount} purchase records.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import purchase records: ' . $e->getMessage());
        }
    }

    /**
     * Export sales records to CSV
     *
     * @return BinaryFileResponse|RedirectResponse
     */
    public function exportSalesRecords()
    {
        try {
            $filePath = $this->csvService->exportSalesRecords();
            
            return response()->download(storage_path('app/' . $filePath))->deleteFileAfterSend(false);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export sales records: ' . $e->getMessage());
        }
    }

    /**
     * Import sales records from CSV
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function importSalesRecords(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:10240'
        ]);

        try {
            $file = $request->file('file');
            $importedCount = $this->csvService->importSalesRecords($file);
            
            return redirect()->back()->with('success', "Successfully imported {$importedCount} sales records.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import sales records: ' . $e->getMessage());
        }
    }

    /**
     * Export stock records to CSV
     *
     * @return BinaryFileResponse|RedirectResponse
     */
    public function exportStock()
    {
        try {
            $filePath = $this->csvService->exportStock();
            
            return response()->download(storage_path('app/' . $filePath))->deleteFileAfterSend(false);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export stock records: ' . $e->getMessage());
        }
    }

    /**
     * Export profit and loss records to CSV
     *
     * @return BinaryFileResponse|RedirectResponse
     */
    public function exportProfitLoss()
    {
        try {
            $filePath = $this->csvService->exportProfitLoss();
            
            return response()->download(storage_path('app/' . $filePath))->deleteFileAfterSend(false);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export profit and loss records: ' . $e->getMessage());
        }
    }

    /**
     * Export suppliers to CSV
     *
     * @return BinaryFileResponse|RedirectResponse
     */
    public function exportSuppliers()
    {
        try {
            $filePath = $this->csvService->exportSuppliers();
            
            return response()->download(storage_path('app/' . $filePath))->deleteFileAfterSend(false);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export suppliers: ' . $e->getMessage());
        }
    }

    /**
     * Export customers to CSV
     *
     * @return BinaryFileResponse|RedirectResponse
     */
    public function exportCustomers()
    {
        try {
            $filePath = $this->csvService->exportCustomers();
            
            return response()->download(storage_path('app/' . $filePath))->deleteFileAfterSend(false);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to export customers: ' . $e->getMessage());
        }
    }
}