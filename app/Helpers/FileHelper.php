<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{

    public function move_temporary_files_to_official_folder($fileNames, $temporaryFolder, $officialFolder)
    {
        $newFileNames = [];
        foreach ($fileNames as $key => $fileName) {

            $newFileName = $fileName;
            while (Storage::disk('public')->exists($officialFolder.'/'.$newFileName)) {
                $newFileName = $this->make_unique_file_name($officialFolder, $fileName);
            }

            $temporaryFile = 'temporary/'.$temporaryFolder.'/'.$fileName;
            $officialFile = $officialFolder.'/'.$newFileName;

            Storage::disk('public')->move($temporaryFile, $officialFile);

            $newFileNames[$key] = $newFileName;
        }

        return $newFileNames;
    }

    public function move_to_folder($file, $folderPath)
    {
        $fileName = $file->getClientOriginalName();
        if (Storage::disk('public')->exists($folderPath.'/'.$fileName)) {
            $fileName = $this->make_unique_file_name($folderPath, $fileName);
        }

        $path = Storage::disk('public')->putFileAs($folderPath, $file, $fileName);
        $url = Storage::disk('public')->url($path);

        return [
            'path' => $folderPath.'/'.$fileName,
            'name' => $fileName,
            'url' => $url
        ];
    }

    public function move_to_folder_random_name($folder, $file)
    {
        $fileName = $file->getClientOriginalName();
        $fileNames = explode(".", $fileName);
        $newFilename = time().'.'.$fileNames[1];

        Storage::disk('public')->putFileAs($folder, $file, $newFilename);

        return $newFilename;
    }

    public function upload_file_to_temporary_folder($folderPath, $file)
    {
        $folderPath = 'temporary/'.$folderPath;

        return $this->move_to_folder($file, $folderPath);
    }

    public function delete_file($filePath)
    {
        Storage::disk('public')->delete($filePath);
    }

    public function delete_temporary_folder($folderPath)
    {
        $folderPath = 'temporary/'.$folderPath;
        return Storage::disk('public')->deleteDirectory($folderPath);
    }

    private function make_unique_file_name($folder, $fileName)
    {
        $fileNames = explode(".", $fileName);
        $count = 2;
        $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
        while(Storage::disk('public')->exists($folder.'/'.$newFilename)) {
            $count += 1;
            $newFilename = $fileNames[0].' ('.$count.').'.$fileNames[1];
        }

        return $newFilename;
    }

    private function get_file_name($filePath)
    {
        $filePaths = explode('/', $filePath);
        return $filePath[count($filePaths-1)];
    }
}
