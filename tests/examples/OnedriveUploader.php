<?php

namespace tests\examples;

use humaninitiative\graph\Uploader;

class OnedriveUploader
{
    protected $token;
    protected $userAccountId;
    protected $dataset;
    protected $filename;

    public function __construct(
        $token,
        $userAccountId,
        $dataset,
        $filename
    ) {
        $this->token = $token;
        $this->userAccountId = $userAccountId;
        $this->dataset = $dataset;
        $this->filename = $filename;
    }

    public function upload($location = '@web')
    {
        $result = false;
        $aTime = microtime(true); //time_start()

        // Connect to Ms Graph
        $uploader = new Uploader($this->token, getenv('CHUNK_LIMIT'));

        echo sprintf('-- Checking File %s ... %s', $this->filename, $this->getTimeSpent($aTime)) . PHP_EOL;
        $bTime = microtime(true); //time_start()

        // Check file in each folder
        $filename = sprintf('%s/%s/%s', $location, $this->dataset->path, $this->filename);
        if (!file_exists($filename)) {
            return;
        }

        // Create / Replace file
        echo sprintf('-- Begin Uploading File %s ... %s', basename($filename), $this->getTimeSpent($bTime)) . PHP_EOL;
        $cTime = microtime(true); //time_start()
        $session = $uploader->createSession($this->userAccountId, $this->dataset->id, basename($filename));
        if ($session && !empty($session['uploadUrl'])) {
            $result = $uploader->postFileByChunks($session['uploadUrl'], $filename);
        }
        echo sprintf('-- File Uploaded! ... %s', $this->getTimeSpent($cTime)) . PHP_EOL;

        return $result;
    }

    protected function getTimeSpent($prevTime)
    {
        $result = microtime(true) - $prevTime;
        return sprintf("%s sec", number_format($result, 4));
    }
}
