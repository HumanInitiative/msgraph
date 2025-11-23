<?php

namespace humaninitiative\graph;

use GuzzleHttp\Exception\ClientException;
use Microsoft\Graph\Model\Attachment;
use Microsoft\Graph\Model\FileAttachment;
use Microsoft\Graph\Model\Message;

trait MessagesTrait
{
    /**
     * Get Messages/Mails from a user by userId
     *
     * @param string $userId User ID
     * @param int $limit Search Limit, Default to 10
     * @return Message[] List of Messages
     */
    public function getMessages($userId, $limit = 10)
    {
        try {
            $messages = $this->graph
                ->createRequest("GET", sprintf('/users/%s/mailFolders/inbox/messages?$top=%s', $userId, $limit))
                ->setReturnType(Message::class)
                ->execute();

            return $messages;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Get Attachments from a message by msgId
     *
     * @param string $userId User ID
     * @param string $msgId Message ID
     * @return Attachment[] List of Attachments
     */
    public function getAttachments($userId, $msgId)
    {
        try {
            $attachments = $this->graph
                ->createRequest("GET", sprintf('/users/%s/messages/%s/attachments', $userId, $msgId))
                ->setReturnType(Attachment::class)
                ->execute();
            
            return $attachments;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Get FileAttachment from a message by attachmentId
     *
     * @param string $userId User ID
     * @param string $msgId Message ID
     * @param string $attachmentId Attachment ID
     * @return FileAttachment The Attachment File
     */
    public function getFileAttachment($userId, $msgId, $attachmentId)
    {
        try {
            $fileAttachment = $this->graph
                ->createRequest("GET", sprintf('/users/%s/messages/%s/attachments/%s', $userId, $msgId, $attachmentId))
                ->setReturnType(FileAttachment::class)
                ->execute();
            
                return $fileAttachment;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Remove a Message to Deleted Items folder
     *
     * @param string $userId User ID
     * @param string $msgId Message ID
     * @return Message The Deleted Message
     */
    public function deleteMessage($userId, $msgId)
    {
        try {
            $message = $this->graph
                ->createRequest("POST", sprintf('/users/%s/messages/%s/move', $userId, $msgId))
                ->attachBody(['destinationId' => 'deletedItems'])
                ->setReturnType(Message::class)
                ->execute();
            
            return $message;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }
}