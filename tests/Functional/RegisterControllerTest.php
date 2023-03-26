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
        $this->assertStringContainsString( '.phoneNumber:\n    This value is not valid.', $responseContent);
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
        $this->assertStringContainsString( '.plainPassword:\n    This value is not valid.', $responseContent);
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
        $this->assertStringContainsString( 'This value is not a valid email address.', $responseContent);
    }

}