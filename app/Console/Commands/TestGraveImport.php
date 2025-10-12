<?php

namespace App\Console\Commands;

use App\Imports\GravesImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class TestGraveImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:import-graves {file=mau_import_moi.xlsx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test import graves from Excel file';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $fileName = $this->argument('file');
        $filePath = base_path($fileName);

        if (!file_exists($filePath)) {
            $this->error("❌ File không tồn tại: {$filePath}");

            return self::FAILURE;
        }

        $this->info("📂 Đang đọc file: {$fileName}");
        $this->newLine();

        try {
            $import = new GravesImport;
            Excel::import($import, $filePath);

            $failures = $import->failures();
            $errors = $import->errors();

            if ($failures->count() > 0 || $errors->count() > 0) {
                $this->warn('⚠️  Import hoàn tất với một số lỗi:');
                $this->newLine();

                foreach ($failures as $failure) {
                    $this->error("  ❌ Dòng {$failure->row()}: " . implode(', ', $failure->errors()));
                }

                foreach ($errors as $error) {
                    $this->error("  ❌ {$error->getMessage()}");
                }

                return self::FAILURE;
            }

            $this->info('✅ Import thành công!');
            $this->info('Hãy kiểm tra dữ liệu trong admin panel.');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("❌ Import thất bại: {$e->getMessage()}");
            $this->error('Stack trace:');
            $this->line($e->getTraceAsString());

            return self::FAILURE;
        }
    }
}
