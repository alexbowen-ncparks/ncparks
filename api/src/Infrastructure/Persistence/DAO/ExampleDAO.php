<?php
declare(strict_types=1);
namespace DPR\API\Infrastructure\Persistence\DAO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Jose\Component\Core\JWK;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Signature\Algorithm\HS256;
use Jose\Component\Signature\JWSBuilder;

use DPR\API\Domain\Models;

class ExampleDAO extends DAO {

  protected $BaseQuery = "SELECT * FROM find.map ";

  // Valid time of cookies in seconds.
  const COOKIE_TTL = 60 * 60 * 24;

  # Gets user role
  function getToken(Request $request, Response $response)
  {
    $requestBody = $request->getBody();
    $parsed_request = json_decode((string)$requestBody);
    $username = $parsed_request->username;
    $password = $parsed_request->password;
    $sql = "SELECT hash, role FROM dprcal_new.users where user='${username}'";
    $DBConn = $this->DBPool->request();
    $DBConn->query($sql);
    $result = $DBConn->getResult();

    // Check password against stored hash which includes hashed password, algorith, salt, and cost.
    if (count($result) > 0 && password_verify($password, $result["hash"])) {
      // Valid password

      // The algorithm manager with the HS256 algorithm.
      $algorithmManager = new AlgorithmManager([
        new HS256(),
      ]);

      // Our key.
      $jwk = JWK::createFromJson(file_get_contents("/run/secrets/jwt_key.json"));

      // The payload we want to sign. The payload MUST be a string hence we use our JSON Converter.
      $payload = json_encode([
        'sub' => $username,
        'role' => $result["role"]
      ]);

      // We instantiate our JWS Builder.
      $jwsBuilder = new JWSBuilder($algorithmManager);

      $jws = $jwsBuilder
        ->create()                               // We want to create a new JWS
        ->withPayload($payload)                  // We set the payload
        ->addSignature($jwk, ['alg' => 'HS256']) // We add a signature with a simple protected header
        ->build();                               // We build it

      $serializer = new CompactSerializer(); // The serializer
      $token = $serializer->serialize($jws, 0); // We serialize the signature at index 0 (we only have one signature).
      $tokenParts = explode(".", $token);
      $ttl = date(DATE_RFC7231, time() + self::COOKIE_TTL);
      $jwtHeaderCookie = "jwtHeader=${tokenParts[0]}; SameSite=Strict; Secure; Path=/; Expires=${ttl}";
      $jwtPayloadCookie = "jwtPayload=${tokenParts[1]}; SameSite=Strict; Secure; Path=/; Expires=${ttl}";
      $jwtSignatureCookie = "jwtSignature=${tokenParts[2]}; SameSite=Strict; Secure; HttpOnly; Path=/api/dprcal; Expires=${ttl}";
      $response->getBody()->write(json_encode(array("response" => "Logged in")));
      return $response->withHeader("content-type", "application/json")->withAddedHeader("Set-Cookie", $jwtHeaderCookie)
        ->withAddedHeader("Set-Cookie", $jwtPayloadCookie)->withAddedHeader("Set-Cookie", $jwtSignatureCookie);
    } else {
      // Invalid password;
      $response->getBody()->write(json_encode(array("response" => "Invalid username or password")));
      return $response->withStatus(401)->withHeader("content-type", "application/json");
    }
  }

  function getById($id) {
    $DBConn = $this->DBPool->request();
    $DBConn->query($this->BaseQuery." WHERE true OR 1 = ?",
      array(
        array("value" => $id, "type" => \PDO::PARAM_INT)
      ));
    $File = null;
    if($DBConn->nextRow()) {
      $File = new Models\File($DBConn->getRow());
    }
    $this->DBPool->release($DBConn);
    return $File;
  }



  function getFiles() {
    $DBConn = $this->DBPool->request();
    $DBConn->query($this->BaseQuery);
    $Files = [];
    while($DBConn->nextRow()) {
      $Files[] = new Models\File($DBConn->getRow());
    }
    $this->DBPool->release($DBConn);
    return $Files;
  }

}
