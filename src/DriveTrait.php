<?php

namespace humaninitiative\graph;

use GuzzleHttp\Exception\ClientException;
use Microsoft\Graph\Model\Drive;
use Microsoft\Graph\Model\DriveItem;
use Microsoft\Graph\Model\Permission;

trait DriveTrait
{
    /**
     * Get Drives from a user by userId
     *
     * @param string $userId User ID
     * @param int $limit Search Limit, Default to 10
     * @return Drive[] List of Drives
     */
    public function getDrives($userId, $limit = 10)
    {
        try {
            $drives = $this->graph
                ->createRequest("GET", sprintf('/users/%s/drives?$top=%s', $userId, $limit))
                ->setReturnType(Drive::class)
                ->execute();
    
            return $drives;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Get File from a user by userId and path
     *
     * @param string $userId User ID
     * @param string $path File Path
     * @return DriveItem The File
     *
     * @throws ClientException
     */
    public function getFile($userId, $path)
    {
        try {
            $file = $this->graph
                ->createRequest("GET", sprintf('/users/%s/drive/root:/%s', $userId, $path))
                ->setReturnType(DriveItem::class)
                ->execute();
    
            return $file;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Get File from a user by userId and fileId
     *
     * @param string $userId User ID
     * @param string $fileId File ID
     * @return DriveItem The File
     *
     * @throws ClientException
     */
    public function getFileById($userId, $fileId)
    {
        try {
            $file = $this->graph
                ->createRequest("GET", sprintf('/users/%s/drive/items/%s', $userId, $fileId))
                ->setReturnType(DriveItem::class)
                ->execute();
            
            return $file;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Get Folder from a user by userId and fileId
     *
     * @param string $userId User ID
     * @param string $fileId Folder ID
     * @return DriveItem The Folder
     *
     * @throws ClientException
     */
    public function getFolderById($userId, $itemId)
    {
        try {
            $folder = $this->graph
                ->createRequest("GET", sprintf('/users/%s/drive/items/%s', $userId, $itemId))
                ->setReturnType(DriveItem::class)
                ->execute();
    
            return $folder;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Get Folder from a user by userId and path
     *
     * @param string $userId User ID
     * @param string $path Folder Path
     * @return DriveItem The Folder
     *
     * @throws ClientException
     */
    public function getFolderByPath($userId, $path)
    {
        try {
            $folder = $this->graph
                ->createRequest("GET", sprintf('/users/%s/drive/root:/%s', $userId, $path))
                ->setReturnType(DriveItem::class)
                ->execute();
    
            return $folder;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Get Root Folders from a user by userId
     *
     * @param string $userId User ID
     * @return DriveItem[] List of Root Folders
     *
     * @throws ClientException
     */
    public function getRootFolders($userId)
    {
        try {
            $folders = $this->graph
                ->createRequest("GET", sprintf('/users/%s/drive/root/children?filter=folder ne null', $userId))
                ->setReturnType(DriveItem::class)
                ->execute();
    
            return $folders;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Get List of Folders from a user by userId and itemId
     *
     * @param string $userId User ID
     * @param string $itemId Item ID
     * @return DriveItem[] List of Folders
     *
     * @throws ClientException
     */
    public function getListFoldersById($userId, $itemId)
    {
        try {
            $folders = $this->graph
                ->createRequest("GET", sprintf('/users/%s/drive/items/%s/children?filter=folder ne null', $userId, $itemId))
                ->setReturnType(DriveItem::class)
                ->execute();
            
            return $folders;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }
    
    /**
     * Get List of Folders from a user by userId and path
     *
     * @param string $userId User ID
     * @param string $path Folder Path
     * @return DriveItem[] List of Folders
     *
     * @throws ClientException
     */
    public function getListFoldersByPath($userId, $path)
    {
        try {
            $folders = $this->graph
                ->createRequest("GET", sprintf('/users/%s/drive/root:/%s:/children?filter=folder ne null', $userId, $path))
                ->setReturnType(DriveItem::class)
                ->execute();
            
            return $folders;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }
    
    /**
     * Get List of Files from a user by userId and fileId
     *
     * @param string $userId User ID
     * @param string $itemId Folder ID
     * @return DriveItem[] List of Files
     *
     * @throws ClientException
     */
    public function getListFiles($userId, $itemId)
    {
        try {
            $files = $this->graph
                ->createRequest("GET", sprintf('/users/%s/drive/items/%s/children', $userId, $itemId))
                ->setReturnType(DriveItem::class)
                ->execute();
            
            return $files;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Delete a file from a user by userId and fileId
     *
     * @param string $userId User ID
     * @param string $itemId File ID
     * @return DriveItem The deleted file
     *
     * @throws ClientException
     */
    public function deleteFile($userId, $itemId)
    {
        try {
            $file = $this->graph
                ->createRequest("DELETE", sprintf('/users/%s/drive/items/%s', $userId, $itemId))
                ->execute();
            
            return $file;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Download a file from a user by userId and fileId
     *
     * @param string $userId User ID
     * @param string $itemId File ID
     * @return DriveUrl The file download URL
     *
     * @throws ClientException
     */
    public function downloadFile($userId, $itemId)
    {
        try {
            $file = $this->graph
                ->createRequest("GET", sprintf('/users/%s/drive/items/%s?select=@microsoft.graph.downloadUrl', $userId, $itemId))
                ->setReturnType(DriveUrl::class)
                ->execute();
    
            return $file;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Get Permission from a user by userId, itemId and permId
     *
     * @param string $userId User ID
     * @param string $itemId Item ID
     * @param string|null $permId Permission ID
     * @return Permission The Permission
     *
     * @throws ClientException
     */
    public function getPermission($userId, $itemId, $permId)
    {
        try {
            if (!is_null($permId)) {
                $endpoint = sprintf('/users/%s/drive/items/%s/permissions/%s', $userId, $itemId, $permId);
            } else {
                $endpoint = sprintf('/users/%s/drive/items/%s/permissions', $userId, $itemId);
            }
    
            $permission = $this->graph
                ->createRequest("GET", $endpoint)
                ->setReturnType(Permission::class)
                ->execute();
    
            return $permission;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Invite users to a drive item
     *
     * @param string $userId User ID
     * @param string $itemId Item ID
     * @param array $recipients Recipient email addresses
     * @param array $options Additional options
     * @return Permission The created permission
     *
     * @throws ClientException
     */
    public function invite($userId, $itemId, $recipients, $options)
    {
        try {
            $recipients = array_map(function ($recipient) {
                return [
                    '@odata.type' => 'microsoft.graph.driveRecipient',
                    'email' => $recipient,
                ];
            }, $recipients);
    
            $recipient = [
                'recipients' => $recipients,
            ];
    
            $body = array_merge($recipient, $options);
    
            $permission = $this->graph
                ->createRequest("POST", sprintf('/users/%s/drive/items/%s/invite', $userId, $itemId))
                ->attachBody($body)
                ->setReturnType(Permission::class)
                ->execute();
    
            return $permission;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Create a permission link for a drive item
     *
     * @param string $userId User ID
     * @param string $itemId Item ID
     * @param array $options Additional options
     * @return Permission The created permission link
     *
     * @throws ClientException
     */
    public function createLink($userId, $itemId, $options)
    {
        try {
            $permission = $this->graph
                ->createRequest("POST", sprintf('/users/%s/drive/items/%s/createLink', $userId, $itemId))
                ->attachBody($options)
                ->setReturnType(Permission::class)
                ->execute();
    
            return $permission;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Update a permission for a drive item
     *
     * @param string $userId User ID
     * @param string $itemId Item ID
     * @param string $permId Permission ID
     * @return Permission The updated permission
     *
     * @throws ClientException
     */
    public function updatePermission($userId, $itemId, $permId)
    {
        try {
            $item = [
                "roles" => ["read"],
            ];
    
            $permission = $this->graph
                ->createRequest("PATCH", sprintf('/users/%s/drive/items/%s/permissions/%s', $userId, $itemId, $permId))
                ->attachBody($item)
                ->setReturnType(Permission::class)
                ->execute();
    
            return $permission;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }

    /**
     * Delete a permission from a drive item
     *
     * @param string $userId User ID
     * @param string $itemId Item ID
     * @param string $permId Permission ID
     * @return Permission The deleted permission
     *
     * @throws ClientException
     */
    public function deletePermission($userId, $itemId, $permId)
    {
        try {
            $permission = $this->graph
                ->createRequest("DELETE", sprintf('/users/%s/drive/items/%s/permissions/%s', $userId, $itemId, $permId))
                ->execute();
    
            return $permission;
        } catch (ClientException $exception) {
            throw $exception;
        }
    }
}