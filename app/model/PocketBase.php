<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PocketBase {
    private $client;
    private $baseUri;

    public function __construct($baseUri = 'http://127.0.0.1:8090') {
        $this->baseUri = rtrim($baseUri, '/');
        $this->client = new Client(['base_uri' => $this->baseUri]);
    }

    public function authWithPassword($identity, $password) {
        try {
            $response = $this->client->post('/api/collections/users/auth-with-password', [
                'json' => ['identity' => $identity, 'password' => $password],
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new Exception('Authentication failed: ' . $e->getMessage());
        }
    }

    public function addRecord($collection, $data, $filePath = null)
    {
        try {
            $multipart = [];

            foreach ($data as $key => $value) {
                $multipart[] = [
                    'name' => $key,
                    'contents' => $value,
                ];
            }

            if ($filePath && file_exists($filePath)) {
                $multipart[] = [
                    'name' => 'picture',
                    'contents' => fopen($filePath, 'r'),
                    'filename' => basename($filePath),
                ];
            }

            $response = $this->client->post("/api/collections/$collection/records", [
            'multipart' => $multipart,
            'headers' => [
                'Authorization' => 'Bearer ' . $_SESSION['token'],
            ],
            ]);
            

            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            throw new Exception('Ошибка при добавлении записи в коллекцию ' . $collection . ': ' . $e->getMessage());
        }
    }


    public function updateRecord($collection, $recordId, $data)
    {
        try {
            $response = $this->client->patch("/api/collections/$collection/records/$recordId", [
                'json' => $data,
                'headers' => [
                    'Authorization' => 'Bearer ' . $_SESSION['token'],
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            throw new Exception('Error updating record in collection ' . $collection . ': ' . $e->getMessage());
        }
    }

    public function getRecord($collection, $recordId = null)
    {
        try {
            if ($recordId !== null) {
                $response = $this->client->get("/api/collections/$collection/records/$recordId", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $_SESSION['token'],
                    ]
                ]);

                $data = json_decode($response->getBody()->getContents(), true);

                return $data;
            }

            $response = $this->client->get("/api/collections/$collection/records", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_SESSION['token'],
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['items'];
        } catch (Exception $e) {
            throw new Exception('Error fetching record(s) from collection ' . $collection . ': ' . $e->getMessage());
        }
    }

    
    public function getFilesURL($dataList)
    {
        foreach ($dataList as &$data) {   
            $collection = $data['collectionName'];
            $recordId = $data['id'];
            $fileName = $data['picture'];

            if (!empty($fileName)) {
                $baseUri = $this->baseUri;
                $data['picture'] = "$baseUri/api/files/$collection/$recordId/$fileName";
            }
        }

        return $dataList;
    }


    public function deleteRecord($collection, $recordId)
    {
        try {
            $response = $this->client->delete($this->baseUri . "/api/collections/$collection/records/$recordId", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_SESSION['token'],
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            throw new Exception('Error deleting record from collection ' . $collection . ': ' . $e->getMessage());
        }
    }
}
?>