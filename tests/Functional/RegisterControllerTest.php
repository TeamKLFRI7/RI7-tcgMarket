<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class RegisterControllerTest extends WebTestCase
{
    public function testRegisterSuccess(){
        $data = [
            'userName' => 'Test',
            'email' => 'testEmail@test.fr',
            'phoneNumber' => '0610101010',
            'password' => 'Azerty123!',
        ];
        $client = static::createClient();
        $client->request('POST', '/api/register',[],[],[], json_encode($data));
        $this->assertResponseStatusCodeSame(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    public function testPhoneIsNotValid(){
        $data = [
            'userName' => 'Test',
            'email' => 'testEmail@test.fr',
            'phoneNumber' => '06101010',
            'password' => 'Azerty123!',
        ];
        $client = static::createClient();
        $client->request('POST', '/api/register',[],[],[], json_encode($data));
        $responseContent = $client->getResponse()->getContent();
        $this->assertStringContainsString( '{"phoneNumber":"Format non valide commencez par 06 ou 07 suivis de de 8 chiffres"}', $responseContent);
    }

    public function testPasswordIsNotValid(){
        $data = [
            'userName' => 'Test',
            'email' => 'testEmail@test.fr',
            'phoneNumber' => '0610101010',
            'password' => 'Azerty123',
        ];
        $client = static::createClient();
        ($client->request('POST', '/api/register',[],[],[], json_encode($data)));
        $responseContent = $client->getResponse()->getContent();
        $this->assertStringContainsString( '{"plainPassword":"Mot de passe non valide"}', $responseContent);
    }

    public function testEmailIsNotValid(){
        $data = [
            'userName' => 'Test',
            'email' => 'testEmailtest.fr',
            'phoneNumber' => '0610101010',
            'password' => 'Azerty123!',
        ];
        $client = static::createClient();
        $client->request('POST', '/api/register',[],[],[], json_encode($data));
        $responseContent = $client->getResponse()->getContent();
        $this->assertStringContainsString( '{"email":"format non valide"}', $responseContent);
    }

}