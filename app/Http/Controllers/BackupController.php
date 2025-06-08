<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class BackupController extends Controller
{
    /**
     * Lista todos los archivos (.sql o .zip) que existan en storage/app/backups
     */
    public function index()
    {
        // Esta variable apunta a la carpeta física storage/app/backups
        $backupDirectory = storage_path('app/backups');

        $backups = collect();

        // Si la carpeta storage/app/backups existe, obtengo sus archivos:
        if (is_dir($backupDirectory)) {
            // Busco archivos .sql o .zip (sin importar mayúsculas/minúsculas)
            $pattern = $backupDirectory . '/*.{sql,SQL,zip,ZIP}';
            $files = glob($pattern, GLOB_BRACE);

            foreach ($files as $fullPath) {
                if (is_file($fullPath)) {
                    $basename    = basename($fullPath);
                    $sizeBytes   = filesize($fullPath);
                    $lastModTime = filemtime($fullPath);

                    $backups->push([
                        'basename'      => $basename,
                        'size'          => $this->humanFilesize($sizeBytes),
                        'last_modified' => Carbon::createFromTimestamp($lastModTime)
                                                 ->translatedFormat('d/m/Y H:i:s'),
                        // aunque no se envíe a la vista, guardamos la ruta completa:
                        'full_path'     => $fullPath,
                    ]);
                }
            }

            // Ordeno por fecha descendente
            $backups = $backups->sortByDesc('last_modified')->values();
        }

        return view('backups.index', compact('backups'));
    }

    /**
     * Crea la carpeta (si no existe) y dispara el comando backup:run
     */
    public function run(Request $request)
    {
        $backupDirectory = storage_path('app/backups');

        // Si no existe la carpeta storage/app/backups, la creamos:
        if (! is_dir($backupDirectory)) {
            mkdir($backupDirectory, 0755, true);
        }

        // Llamamos al comando de Spatie para generar el dump en storage/app/backups
        Artisan::call('backup:run');

        return redirect()
            ->route('backups.index')
            ->with('success', 'Se creó el backup correctamente.');
    }

    /**
     * Descargar un backup específico.
     */
    public function download(string $filename)
    {
        $backupDirectory = storage_path('app/backups');
        $fullPath        = $backupDirectory . DIRECTORY_SEPARATOR . $filename;

        if (! file_exists($fullPath) || ! is_file($fullPath)) {
            abort(404, 'El archivo de backup no existe.');
        }

        return Response::download($fullPath, $filename);
    }

    /**
     * Eliminar un backup específico.
     */
    public function destroy(string $filename)
    {
        $backupDirectory = storage_path('app/backups');
        $fullPath        = $backupDirectory . DIRECTORY_SEPARATOR . $filename;

        if (file_exists($fullPath) && is_file($fullPath)) {
            unlink($fullPath);
        }

        return redirect()
            ->route('backups.index')
            ->with('success', 'Backup eliminado correctamente.');
    }

    /**
     * Convierte bytes a un formato legible (KB, MB, GB…).
     */
    private function humanFilesize(int $bytes, int $decimals = 2): string
    {
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        if ($bytes === 0) {
            return '0 B';
        }

        $i = (int) floor(log($bytes, 1024));
        $size = $bytes / pow(1024, $i);

        return round($size, $decimals) . ' ' . $sizes[$i];
    }
}
