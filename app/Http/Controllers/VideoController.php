<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
class VideoController extends Controller
{
  protected $sid;
  protected $token;
  protected $key;
  protected $secret;

  public function __construct()
  {
      $this->sid = config('services.twilio.sid');
      $this->token = config('services.twilio.token');
      $this->key = config('services.twilio.key');
      $this->secret = config('services.twilio.secret');
  }

  public function index()
  {
      $rooms = [];
      try {
          $client = new Client('AC1473240afa02f14da6110b8d43bf55ee', '1140dc7df4b6453301f6448c06c22a04');
          $allRooms = $client->video->rooms->read([]);

          $rooms = array_map(function ($room) {
              return $room->uniqueName;
          }, $allRooms);
      } catch (Exception $e) {
          echo "Error: " . $e->getMessage();
      }
      return view('rooms', ['rooms' => $rooms]);
  }


  public function createRoom(Request $request)
  {
      $client = new Client('AC1473240afa02f14da6110b8d43bf55ee', '1140dc7df4b6453301f6448c06c22a04');

      $exists = $client->video->rooms->read(['uniqueName' => $request->roomName]);

      if (empty($exists)) {
          $client->video->rooms->create([
              'uniqueName' => uniqid(),
              'type' => 'group',
              'recordParticipantsOnConnect' => false
          ]);

          Log::debug("created new room: " . $request->roomName);
      }

      return redirect()->action('VideoController@joinRoom', [
          'roomName' => $request->roomName,
      ]);
  }

public function adminJoinRoom($roomName)
{
    // A unique identifier for this user
    $identity = uniqid();
    // $identity = rand(3,1000);
    Log::debug("joined with identity: $identity");
    $token = new AccessToken('AC1473240afa02f14da6110b8d43bf55ee', 'SKb79647c79d3f28bf705a90f326004c53','UxqrRr1uF08mm8xPsr1mGjUoYO3Akg3N', 3600, $identity);

    $videoGrant = new VideoGrant();
    $videoGrant->setRoom($roomName);

    $token->addGrant($videoGrant);

    return view('room', ['accessToken' => $token->toJWT(), 'roomName' => $roomName,'auth'=>$identity,'page'=>'none','end_time'=>'9']);
}
  public function joinRoom($roomName)
  {
      // A unique identifier for this user
      $identity = uniqid();
      // $identity = rand(3,1000);
      Log::debug("joined with identity: $identity");
      $token = new AccessToken('AC1473240afa02f14da6110b8d43bf55ee', 'SKb79647c79d3f28bf705a90f326004c53','UxqrRr1uF08mm8xPsr1mGjUoYO3Akg3N', 3600, $identity);

      $videoGrant = new VideoGrant();
      $videoGrant->setRoom($roomName);

      $token->addGrant($videoGrant);

      return view('Match', ['accessToken' => $token->toJWT(), 'roomName' => $roomName,'auth'=>$identity,'page'=>'none','end_time'=>'9']);
  }
}
