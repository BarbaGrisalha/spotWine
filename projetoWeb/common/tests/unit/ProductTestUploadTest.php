<?php

namespace common\tests\Unit;

use common\models\Product;
use common\tests\UnitTester;
use yii\web\UploadedFile;
use Codeception\Stub;

class ProductTestUploadTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before()
    {
    }

    public function testUpload()
    {
        $product = new Product();

        // Criar um arquivo temporário para simular o upload
        $tempFilePath = tempnam(sys_get_temp_dir(), 'test-image');
        file_put_contents($tempFilePath, 'conteúdo simulado de uma imagem');

        // Criar um mock de UploadedFile com o arquivo temporário
        $fileMock = Stub::make(UploadedFile::class, [
            'name' => 'test-image.jpg',
            'tempName' => $tempFilePath,
            'type' => 'image/jpeg',
            'size' => filesize($tempFilePath),
            'error' => UPLOAD_ERR_OK,
            'saveAs' => function ($path) {
                // Simular o salvamento do arquivo
                return copy($this->tempName, $path);
            },
        ]);

        // Associar o mock ao modelo
        $product->imageFile = $fileMock;

        // Testar o método de upload
        $result = $product->upload();

        // Limpar o arquivo temporário após o teste
        unlink($tempFilePath);
    }
}