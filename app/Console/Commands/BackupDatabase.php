<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ZipArchive;

class BackupDatabase extends Command
{
    /**
     * El nombre y firma del comando Artisan.
     */
    protected $signature = 'backup:run 
                            {--includeFiles : Si se incluye, también comprimirá la carpeta storage/app/public en el ZIP}';

    /**
     * La descripción breve del comando.
     */
    protected $description = 'Genera un dump de la base de datos y lo guarda (opcionalmente) dentro de un ZIP junto con archivos.';

    /**
     * Ejecutar el comando.
     */
    public function handle()
    {
        // 1. Parámetros de conexión extraídos de .env/config
        $dbConnection = config('database.default'); // 'mysql'
        $host         = config("database.connections.$dbConnection.host");
        $port         = config("database.connections.$dbConnection.port");
        $database     = config("database.connections.$dbConnection.database");
        $username     = config("database.connections.$dbConnection.username");
        $password     = config("database.connections.$dbConnection.password");

        // 2. Ruta donde se guardará el dump temporario
        $timestamp = now()->format('Y_m_d-His');
        $dumpFileName = "db-backup-{$timestamp}.sql";
        $dumpFilePath = storage_path("app/backups/{$dumpFileName}");

        // 3. Construir el comando de mysqldump
        //    En Windows / XAMPP, asegúrate de que la ruta a mysqldump.exe esté en tu PATH de Windows.
        //    Si no, pon la ruta completa, por ejemplo "C:/xampp/mysql/bin/mysqldump.exe"
        // $mysqldump = 'mysqldump';
        // Si XAMPP no está en PATH, descomenta y ajusta esta línea:
        $mysqldump = '"C:/xampp/mysql/bin/mysqldump.exe"';

        $command = "{$mysqldump} --user={$username} --password=\"{$password}\" --host={$host} --port={$port} {$database} > \"{$dumpFilePath}\"";

        $this->info("⏳ Ejecutando mysqldump para la base de datos '{$database}' ...");

        // 4. Ejecutar mysqldump
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error("❌ Error al ejecutar mysqldump. Código de salida: {$returnVar}");
            return 1;
        }

        $this->info("✅ Se generó dump en: {$dumpFilePath}");

        // 5. (Opcional) Si la opción --includeFiles está presente, crear un ZIP que incluya:
        //    - El dump .sql recién creado
        //    - Y (por ejemplo) la carpeta storage/app/public
        if ($this->option('includeFiles')) {
            $zipFileName = "backup-full-{$timestamp}.zip";
            $zipFilePath = storage_path("app/backups/{$zipFileName}");

            $this->info("📦 Creando ZIP {$zipFileName} incluyendo el dump y /storage/app/public ...");
            $zip = new ZipArchive();
            if ($zip->open($zipFilePath, ZipArchive::CREATE) !== true) {
                $this->error("❌ No se pudo crear el archivo ZIP en {$zipFilePath}");
                return 1;
            }

            // a) Añadir el dump
            $zip->addFile($dumpFilePath, $dumpFileName);

            // b) Añadir recursivamente storage/app/public (si existe)
            $publicFolder = storage_path('app/public');
            if (File::exists($publicFolder)) {
                $files = File::allFiles($publicFolder);
                foreach ($files as $file) {
                    // La ruta dentro del ZIP debe conservar la estructura desde "public"
                    $relativePath = 'public/' . $file->getRelativePathName();
                    $zip->addFile($file->getRealPath(), $relativePath);
                }
            }

            $zip->close();
            $this->info("✅ ZIP creado en: {$zipFilePath}");
        }

        $this->info("🎉 Backup completado correctamente.");
        return 0;
    }
}
