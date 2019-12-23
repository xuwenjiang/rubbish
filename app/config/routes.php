<?php

use Slim\App;
use Slim\Http\Response;
use App\Guitar\GuitarMapper;
use App\Guitar\GuitarEntity;

return function (App $app) {

    $app->get('/', function ($request, $response, $args) {
        $guitarMapper = new GuitarMapper($this->db);
        $guitars = $guitarMapper->getGuitars();
        $response = $this->view->render($response, "guitars.phtml", ["guitars" => $guitars, "router" => $this->router]);
        return $response;
    });

    //HTTP GET Guitars
    $app->get('/guitars', function ($request, Response $response, $args) {
        $guitarMapper = new GuitarMapper($this->db);
        $guitars = $guitarMapper->getGuitars();
        $result = [];
        foreach ($guitars as $_guitar) {
            $result[] = $_guitar->getData();
        }

        return $response->withJson($result);
    });

    //HTTP GET Guitar with ID
    $app->get('/guitars/{id}', function ($request, Response $response, $args) {
        $guitarId = (int)$args['id'];
        try {
            $guitarMapper = new GuitarMapper($this->db);
            $guitar = $guitarMapper->getGuitarById($guitarId);
            return $response->withJson($guitar->getData());
        } catch (Exception $e) {
            return $response->write($e->getMessage())->withStatus($e->getCode());
        }
    });

    //HTTP POST Guitars
    $app->post('/guitars', function ($request, Response $response, $args) {
        $data = $request->getParsedBody();
        if(empty($data)){
            return $response->withStatus(204);
        }
        $guitarData = [];
        $guitarData['name'] = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $guitarData['price'] = filter_var($data['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $guitarData['qty'] = filter_var($data['qty'], FILTER_SANITIZE_NUMBER_INT);

        $guitarMapper = new GuitarMapper($this->db);
        $guitar = new GuitarEntity($guitarData);
        $guitarMapper->save($guitar);

        $response = $response->withRedirect("/guitars");
        $response->withStatus(201);

        return $response;
    });

    //HTTP PUT Guitars
    $app->put('/guitars/{id}', function ($request, Response $response, $args) {
        try {
            $guitarId = (int)$args['id'];
            $guitarMapper = new GuitarMapper($this->db);
            $guitar = $guitarMapper->getGuitarById($guitarId);

            $newData = $request->getParsedBody();
            if(isset($newData['name'])){
                $guitar->setName(filter_var($newData['name'], FILTER_SANITIZE_STRING));
            }
            if(isset($newData['price'])){
                $guitar->setPrice(filter_var($newData['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
            }
            if(isset($newData['qty'])){
                $guitar->setQty(filter_var($newData['qty'], FILTER_SANITIZE_NUMBER_INT));
            }
            $updateGuitar = $guitarMapper->update($guitar);

            return $response->withJson($updateGuitar->getData());

        } catch (Exception $e) {
            return $response->write($e->getMessage())->withStatus($e->getCode());
        }
    });

    //HTTP DELETE Guitars
    $app->delete('/guitars/{id}', function ($request, Response $response, $args) {
        try {
            $guitarId = (int)$args['id'];
            $guitarMapper = new GuitarMapper($this->db);
            $guitarMapper->delete($guitarId);
            return $response->write('deleted')->withStatus(200);
        } catch (Exception $e) {
            return $response->write($e->getMessage())->withStatus($e->getCode());
        }
    });
};
