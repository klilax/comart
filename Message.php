<?php
    require('db.php');
    require('User.php');

    class Message {
        private $messageId;
        private $senderId;
        private $receiverId;
        private $messageBody;
        private $messageTitle;
        private $timeSent;
        private static PDO $conn;
        
        public function __construct($message) {
            $this->messageId = $message['messageId'];
            $this->senderId = $message['senderId'];
            $this->receiverId = $message['receiverId'];
            $this->messageBody = $message['messageBody'];
            $this->messageTitle = $message['messageTitle'];
            $this->timeSent = $message['timeSent'];
        }

        public static function sendMessage($sender, $receiver) {
            $sql = "INSERT INTO message (senderId, receiverId, messageBody, messageTitle) 
                    values (:senderId, :receiverId, :messageId, :messageTitle)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':senderId', $sender->getId());
            $stmt->bindParam(':receiverId', $receiver->getId());
            $stmt->bindParam(':messageBody', $this->messageBody);
            $stmt->bindParam(':messageTitle', $this->messageTitle);
            $stmt->execute();
        }

        public static function viewMessage($receiverId) {
            $sql = "SELECT messageId, senderId, receiverId, messageBody, messageTitle, timeSent 
                    FROM message where receiverId = :receiverId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':receiverId', $receiverId);
            $stmt->execute();

            if($stmt->rowCount() != 0) {
                $row = $stmt->fetch();
                return $row;
            } else {
                return -1;
            }
        }

        public static function deleteMessage($messageId) {
            $sql = "DELETE FROM message WHERE messageId = :messageId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':messageId', $messageId);
            $stmt->execute();
        }

        public static function setConnection($conn) {
            self::$conn = $conn;
        }
    }

    Message::setConnection(getConnection());
    
?>