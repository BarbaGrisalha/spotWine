<?php
namespace common\helpers;

use Yii;
use yii\web\UploadedFile;

class FileUploadHelper
{
    /**
     * Realiza o upload de um arquivo.
     *
     * @param UploadedFile $file Instância do arquivo enviado.
     * @param string $folder Caminho do diretório para salvar (relativo a `@webroot`).
     * @return string|null Retorna o caminho relativo do arquivo salvo ou null em caso de erro.
     */
    public static function upload(UploadedFile $file, $directory)
    {
        $uploadPath = Yii::getAlias('@webroot/uploads/' . $directory);
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $fileName = uniqid() . '.' . $file->extension;
        $filePath = $uploadPath . '/' . $fileName;

        if ($file->saveAs($filePath)) {
            // Retorna o caminho relativo para salvar no banco
            return '/uploads/' . $directory . '/' . $fileName;
        }

        return null; // Caso o upload falhe
    }

}
