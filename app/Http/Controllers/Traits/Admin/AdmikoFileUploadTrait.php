<?php
/** Helper for saving images and files. **/
/**
 * @author     Thank you for using Admiko.com
 * @copyright  2020-2022
 * @link       https://Admiko.com
 * @Help       We are always looking to improve our code. If you know better and more creative way don't hesitate to contact us. Thank you.
 */
namespace App\Http\Controllers\Traits\Admin;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Database\Eloquent\Model;

trait AdmikoFileUploadTrait
{
    public static function bootAdmikoFileUploadTrait()
    {
        static::deleting(function (Model $model) {
            if (!method_exists($model, 'runSoftDelete')) {
                $model->admikoSoftDeleteFilesCascade(get_class($model), [$model->id]);
                $model->admikoDeleteFiles($model, 'id', [$model->id]);
            }
        });
    }

    public function admikoSoftDeleteFilesCascade($modelPath, $deleteId)
    {
        if (property_exists(app($modelPath), 'admikoCascadeDelete')) {
            $cascade = $modelPath::$admikoCascadeDelete;
            foreach ($cascade as $key_id => $modelArray) {
                foreach ($modelArray as $model) {
                    $getModel = app($modelPath . '\\' . $model);
                    if (property_exists($getModel, 'admikoCascadeDelete')) {
                        $deleteIdArray = $getModel::whereIn($key_id, $deleteId)->pluck('id');
                        if (count($deleteIdArray) > 0) {
                            $this->admikoSoftDeleteFilesCascade($modelPath . '\\' . $model, $deleteIdArray);
                        }
                    }
                    $this->admikoDeleteFiles($getModel, $key_id, $deleteId);
                }
            }
        }

    }

    public function admikoDeleteFiles($getModel, $key_id, $deleteId)
    {
        if (property_exists($getModel, 'admiko_file_info')) {
            $deleteFilesAll = $getModel::whereIn($key_id, $deleteId)->get();
            foreach ($deleteFilesAll as $fileData) {
                foreach ($getModel::$admiko_file_info as $db_name => $files) {
                    if ($fileData[$db_name]) {
                        if (array_key_exists('original', $files) && array_key_exists('folder', $files['original'])) {
                            $this->deleteFile($files['original']['folder'] . $fileData[$db_name]);
                        }
                        if (array_key_exists('thumbnail', $files) && is_array($files['thumbnail'])) {
                            foreach ($files['thumbnail'] as $thumbnailInfo) {
                                if (array_key_exists('folder', $thumbnailInfo)) {
                                    $this->deleteFile($thumbnailInfo['folder'] . $thumbnailInfo['prefix'] . $fileData[$db_name]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function imageUpload($uploadedFile, $fileInfo, $currentFile = '', $deleteFile = 0)
    {
        $fileNameToStore = null;
        if ($currentFile != '' || $deleteFile == 1) {
            $this->deleteFile($fileInfo['original']['folder'] . $currentFile);
            if (isset($fileInfo['thumbnail']) && count($fileInfo['thumbnail']) > 0) {
                foreach ($fileInfo['thumbnail'] as $thumbnail) {
                    $this->deleteFile($thumbnail['folder'] . $thumbnail['prefix'] . $currentFile);
                }
            }
        }
        if ($uploadedFile) {
            $fileNameToStore = $this->fixFileName($uploadedFile->getClientOriginalName(), $fileInfo['original']['folder']);
            $resize_crop = $fileInfo['original']['action'];
            if ($resize_crop != 'noaction') {
                $newWidth = $fileInfo['original']['width'];
                $newHeight = $fileInfo['original']['height'];
                $this->imageResizeWork($uploadedFile, $fileInfo['original']['folder'], $fileNameToStore, $newWidth, $newHeight, $resize_crop);
            } else {
                $uploadedFile->storePubliclyAs($fileInfo['original']['folder'], $fileNameToStore, config("admiko_config.filesystem"));
            }
            if (isset($fileInfo['thumbnail']) && count($fileInfo["thumbnail"]) > 0) {
                foreach ($fileInfo["thumbnail"] as $thumbnail) {
                    $newWidth = $thumbnail['width'];
                    $newHeight = $thumbnail['height'];
                    $resize_crop = $thumbnail['action'];
                    $this->imageResizeWork($uploadedFile, $thumbnail['folder'], $thumbnail['prefix'] . $fileNameToStore, $newWidth, $newHeight, $resize_crop);
                }
            }
        }
        return $fileNameToStore;
    }

    public function imageResizeWork($uploadedFile, $folderToStore, $fileNameToStore, $newWidth, $newHeight, $resize_crop)
    {
        $imageMaker = new ImageManager();
        $image = $imageMaker->make($uploadedFile);
        $imageWidth = $image->width();
        $imageHeight = $image->height();
        if ($resize_crop == 'resize') {
            if ($imageWidth > $imageHeight) {
                $image->widen($newWidth, function ($constraint) {
                    $constraint->upsize();
                });
            } else {
                $image->heighten($newHeight, function ($constraint) {
                    $constraint->upsize();
                });
            }
        } else {
            $image->fit($newWidth, $newHeight, function ($constraint) {
                $constraint->upsize();
            });
        }
        $content = $image->stream()->detach();
        Storage::disk(config("admiko_config.filesystem"))->put($folderToStore . $fileNameToStore, $content, 'public');
    }

    public function fileUpload($uploadedFile, $fileInfo, $currentFile = '', $deleteFile = 0)
    {
        $fileNameToStore = '';
        if ($currentFile != '' || $deleteFile == 1) {
            $this->deleteFile($fileInfo['original']['folder'] . $currentFile);
        }
        if ($uploadedFile) {
            $fileNameToStore = $this->fixFileName($uploadedFile->getClientOriginalName(), $fileInfo['original']['folder']);
            $uploadedFile->storePubliclyAs($fileInfo['original']['folder'], $fileNameToStore, config("admiko_config.filesystem"));
            return $fileNameToStore;
        }
        return $fileNameToStore;
    }

    public function fixFileName($fileName, $folder, $defaultName = 'file', $addNum = 0)
    {
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (strlen($fileExtension) > 0) {
            $fileExtension = '.' . $fileExtension;
            $baseFileName = pathinfo($fileName, PATHINFO_FILENAME);
        } else {
            $fileExtension = '';
            $baseFileName = $fileName;
        }
        $baseFileName = str_replace(' ', '_', $baseFileName);
        $baseFileName = preg_replace('/[^A-Za-z0-9\-_]/', '', $baseFileName); // Removes special chars.
        if (strlen($baseFileName) == 0) {
            $baseFileName = $defaultName;
        }
        if ($addNum > 0) {
            $newFileName = strtolower($baseFileName) . '_' . $addNum . $fileExtension;
        } else {
            $newFileName = strtolower($baseFileName) . $fileExtension;
        }
        if (Storage::disk(config("admiko_config.filesystem"))->exists($folder . $newFileName)) {
            $addNum++;
            $newFileName = $this->fixFileName(strtolower($baseFileName) . $fileExtension, $folder, $defaultName, $addNum);
        }
        return $newFileName;
    }

    public function deleteMultipleFiles($filesArray)
    {
        Storage::disk(config("admiko_config.filesystem"))->delete($filesArray);
    }

    public function deleteFile($file)
    {
        if (Storage::disk(config("admiko_config.filesystem"))->exists($file)) {
            Storage::disk(config("admiko_config.filesystem"))->delete($file);
            return true;
        }
        return false;
    }
}

