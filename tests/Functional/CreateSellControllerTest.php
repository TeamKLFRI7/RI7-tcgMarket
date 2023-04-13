<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateSellControllerTest extends WebTestCase
{
    public function testCreateSellSuccess(){

        $data = [
            'card' => 1,
            'fkIdUser' => 1,
            'fkIdGame' => 1,
            'cardSet' => 1,
            'name' => 'test',
            'price' => 123,
            'quality' => 'good',
        ];

        $tempImagePath = sys_get_temp_dir().'/test_sellCover.png';
        copy(__DIR__ . '/fixtures/test_sellCover.png', $tempImagePath);

        $uploadedFile = new UploadedFile(
            $tempImagePath,
            'test_sellCover.png'
        );

        $client = static::createClient();
        $client->request('POST', '/api/sellCard',$data,['file' => $uploadedFile],['CONTENT_TYPE' => 'multipart/form-data']);
        $this->assertResponseStatusCodeSame(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    public function testCreateSellNoFile(){

        $data = [
            'card' => 1,
            'fkIdUser' => 1,
            'fkIdGame' => 1,
            'cardSet' => 1,
            'name' => 'test',
            'price' => 123,
            'quality' => 'good',
        ];

        $client = static::createClient();
        $client->request('POST', '/api/sellCard',$data,[],['CONTENT_TYPE' => 'multipart/form-data']);
        $responseContent = $client->getResponse()->getContent();
        $this->assertStringContainsString( 'Une image est obligatoire (400 Bad Request)', $responseContent);
    }
}