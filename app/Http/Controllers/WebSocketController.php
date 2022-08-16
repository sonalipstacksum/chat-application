<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use App\Models\User;
use App\Models\UserMessage;

class WebSocketController extends Controller implements MessageComponentInterface
{
    private $connections = [];
    protected $clients;
    private $users;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->users = [];        
    }

    function onOpen(ConnectionInterface $conn){
        $this->clients->attach($conn);
        $this->users[$conn->resourceId]['conn'] = $conn;        
    }

    function onClose(ConnectionInterface $conn){
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
        unset($this->users[$conn->resourceId]);
    }

    function onError(ConnectionInterface $conn, \Exception $e){
        echo "An error has occurred: {$e->getMessage()}\n";
        unset($this->users[$conn->resourceId]);
        $conn->close();
    }

    function onMessage(ConnectionInterface $conn, $msg){
        $data = json_decode($msg);
        
        if (isset($data->command)) {
            switch ($data->command) {
                case "open":
                    $this->users[$conn->resourceId]['userId'] = $data->userId;
                    $data_to_respond = [
                        'command' => 'open',
                        'userId' => $data->userId,
                        'message' => 'Just contented to line!',
                        'userName' => 'sonali'
                    ];
                break;
            
                case "close":
                    $data_to_respond = [
                        'command' => 'close', 
                        'userId' => 0,                       
                        'resourceId' => $conn->resourceId,
                        'message' => 'Connection Closed'
                    ];
                    $conn->send(json_encode($data_to_respond));
                break;
            
                case "message":
                    $data_to_respond = [
                        'command' => 'message',
                        'resourceId' => $conn->resourceId,
                        'message' => $data->message,
                        'senderId' => $data->senderId,
                        'receiverId' => $data->receiverId
                    ];
                    if(count($this->users) > 0){
                        $insert = true;
                        foreach ($this->users as $id => $value) {                            
                            $this->users[$id]['conn']->send(json_encode($data_to_respond));
                        }

                        if($insert == true){
                            UserMessage::insert([
                                'user_id' => $data->senderId,
                                'sender_id' => $data->senderId,
                                'receiver_id' => $data->receiverId,
                                'message' => $data->message
                            ]);
                        }
                    }                    
                break;

                default:
                    $data_to_respond = [
                        'command' => 'unknown',
                        'userId' => 0,
                        'resourceId' => $conn->resourceId,
                        'message' => '',
                    ];
                break;
            }
        }
    }
}
