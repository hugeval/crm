<?php

namespace Oro\Bundle\UserBundle\Tests\Functional\API;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RestApiUsersTest extends WebTestCase
{

    protected $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @return array
     */
    public function testApiCreateUser()
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        $request = array(
            "user" => array (
                "username" => 'user_123',
                "email" => 'test@test.com',
                "enabled" => '1',
                "password" => '1231231q',
                "roles" => array (1)
            )
        );
        $this->client->request('POST', '/api/rest/latest/profile', $request);
        $result = $this->client->getResponse();
        $this->assertJsonResponse($result, 201);

        return $request;
    }

    /**
     * @depends testApiCreateUser
     * @param string $request
     * @return int
     */
    public function testApiUpdateUser($request)
    {
        $request['username'] .= '_Updated';
        //get user id
        $userId = self::$client->getUserByName($request['name']);
        $this->client->request('PUT', '/api/rest/latest/profiles' . '/' . $userId, $request);
        $result = $this->client->getResponse();
        $this->assertJsonResponse($result, 302);

        $this->client->request('GET', '/api/rest/latest/profiles' . '/' . $userId);
        $this->assertJsonResponse($result, 200);

        $result = json_decode($result->getContent(), true);
        //compare result
        $this->assertEqualsResponse($request, $result);

        return $userId;
    }

    /**
     * @depends testApiUpdateUser
     * @param int $userId
     */
    public function testApiDeleteUser($userId)
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        $this->client->request('DELETE', '/api/rest/latest/profiles' . '/' . $userId);
        $result = $this->client->getResponse();
        $this->assertJsonResponse($result, 204);
        $this->client->request('GET', '/api/rest/latest/profiles' . '/' . $userId);
        $result = $this->client->getResponse();
        $this->assertEmpty($result);
    }

    /**
     * Test API response status
     *
     * @param string $response
     * @param int $statusCode
     */
    protected function assertJsonResponse($response, $statusCode = 201)
    {
        $this->assertEquals(
            $statusCode,
            $response->getStatusCode(),
            $response->getContent()
        );
    }

    /**
     * Check created role
     *
     * @param array $result
     * @param array $request
     */
    protected function assertEqualsResponse($request, $result)
    {
        $flag = 1;
        foreach ($result as $key => $object) {
            foreach ($request as $role) {
                if ($role['username'] == $result[$key]['username']) {
                    $flag = 0;
                    break 2;
                }
            }
        }
        $this->assertEquals(0, $flag);
    }
}
