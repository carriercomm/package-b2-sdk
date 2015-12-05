<?php

/*
 * Class for interfacing with the backblaze b2 api.
 * https://www.backblaze.com/b2/docs/b2_create_bucket.html
 */


class B2
{
    private $m_accountId;
    private $m_applicationKey;
    
    public function __construct($accountId, $applicationKey)
    {
        $this->m_accountId = $accountId;
        $this->m_applicationKey = $applicationKey;
    }
    
    
    public function authorizeAccount()
    {
        $params = array(
            "action" => "b2_authorize_account",
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * https://www.backblaze.com/b2/docs/b2_create_bucket.html
     * @param string $bucketName - the name for the bucket
     * @param bool $isPrivate - specify true if should be private, false if public.
     */
    public function createBucket($bucketName, $isPrivate)
    {
        $bucketType = "allPublic";
        
        if ($isPrivate)
        {
            $bucketType = "allPrivate";
        }
        
        $params = array(
            "action" => "b2_create_bucket",
            "bucketName" => $bucketName,
            "bucketType" => $bucketType,
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * https://www.backblaze.com/b2/docs/b2_delete_bucket.html
     * @param type $bucketId - The ID of the bucket to delete.
     */
    public function deleteBucket($bucketId)
    {
        $params = array(
            "action" => "b2_delete_bucket",
            "bucketId" => $bucketId,
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * Deletes one version of a file from B2.
     * https://www.backblaze.com/b2/docs/b2_delete_file_version.html
     * @param string $fileName - The name of the file.
     * @param type $fileId - The ID of the file, as returned by b2_upload_file, 
     *                        b2_list_file_names, or b2_list_file_versions.
     */
    public function deleteFileVersion($fileName, $fileId)
    {
        $params = array(
            "action" => "b2_delete_file_version",
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * Downloads one file from B2.
     * https://www.backblaze.com/b2/docs/b2_download_file_by_id.html
     */
    public function downloadFileById($fileId)
    {        
        $params = array(
            "action" => "b2_download_file_by_id",
            "fileId" => $fileId,
        );
        
        $response = sendRequest($params);
    }
    
    
    public function downloadFileByName()
    {
        $params = array(
            "action" => "b2_download_file_by_name",
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * https://www.backblaze.com/b2/docs/b2_get_file_info.html
     * @param type $fileId
     */
    public function getFileInfo($fileId)
    {
        $params = array(
            "action" => "b2_get_file_info",
            "fileId" => $fileId
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * Gets a URL to use for uploading files.
     * When you upload a file to B2, you must call b2_get_upload_url first to get the URL 
     * for uploading directly to the place where the file will be stored.
     */
    public function getUploadUrl($bucketId)
    {
        $params = array(
            "action" => "b2_get_upload_url",
            "bucketId" => $bucketId
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * Hides a file so that downloading by name will not find the file, 
     * but previous versions of the file are still stored. See File Versions 
     * about what it means to hide a file.
     * @param type $bucketId
     * @param string $fileName - the name of the file to hide.
     */
    public function hideFile($bucketId, $fileName)
    {
        $params = array(
            "action" => "b2_hide_file",
            "bucketId" => $bucketId,
            "fileName" => $fileName
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * Lists buckets associated with an account, in alphabetical order by bucket ID.
     * https://www.backblaze.com/b2/docs/b2_list_buckets.html
     */
    public function listBuckets()
    {
        $params = array(
            "action" => "b2_list_buckets",
        );
        
        $response = sendRequest($params);
    }
    
    /**
     * Lists the names of all files in a bucket, starting at a given name.
     * https://www.backblaze.com/b2/docs/b2_list_file_names.html
     */
    public function listFileNames()
    {
        $params = array(
            "action" => "b2_list_file_names",
            "accountId" => $this->m_accountId
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * Lists all of the versions of all of the files contained in 
     * one bucket, in alphabetical order by file name, and by reverse 
     * of date/time uploaded for versions of files with the same name.
     * https://www.backblaze.com/b2/docs/b2_list_file_versions.html
     */
    public function listFileVersions($bucketId, $maxFileCount=100)
    {
        $params = array(
            "action" => "b2_list_file_versions",
            "bucketId" => $bucketId,
            "maxFileCount" => $maxFileCount
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * Update an existing bucket.
     * Modifies the bucketType of an existing bucket. Can be used to allow everyone to download 
     * the contents of the bucket without providing any authorization, or to prevent anyone from 
     * downloading the contents of the bucket without providing a bucket auth token.
     * https://www.backblaze.com/b2/docs/b2_update_bucket.html
     */
    public function updateBucket($bucketId, $isPrivate)
    {
        $bucketType = "allPublic";
        
        if ($isPrivate)
        {
            $bucketType = "allPrivate";
        }
        
        $params = array(
            "action" => "b2_update_bucket",
            "bucketId" => $bucketId,
            "bucketType" => $bucketType
        );
        
        $response = sendRequest($params);
    }
    
    
    /**
     * Uploads one file to B2, returning its unique file ID.
     * https://www.backblaze.com/b2/docs/b2_upload_file.html
     * @param type $uploadFileName
     * @param type $filepath
     * @param type $bucketId
     * @param type $contentType - the type of content the file is (e.g. "text/plain")
     * @param type $uploadAuthToken - // Provided by b2_get_upload_url
     */
    public function uploadFile($uploadFileName, $filepath, $bucketId, $contentType, $uploadAuthToken)
    {   
        $handle = fopen($filepath, 'r');
        $read_file = fread($handle,filesize($filepath));

        $upload_url = ""; // Provided by b2_get_upload_url
        $content_type = "text/plain";
        $sha1_of_file_data = sha1_file($filepath);

        $session = curl_init($upload_url);

        // Add read file as post field
        curl_setopt($session, CURLOPT_POSTFIELDS, $read_file); 

        // Add headers
        $headers = array();
        $headers[] = "Authorization: " . $uploadAuthToken;
        $headers[] = "X-Bz-File-Name: " . $uploadFileName;
        $headers[] = "Content-Type: " . $content_type;
        $headers[] = "X-Bz-Content-Sha1: " . $sha1_of_file_data;
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers); 

        curl_setopt($session, CURLOPT_POST, true); // HTTP POST
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);  // Receive server response
        $server_output = curl_exec($session); // Let's do this!
        curl_close ($session); // Clean up
        echo ($server_output); // Tell me about the rabbits, George!
    }
    
    
    /**
     * Helper function to send the request to Backblaze.
     * 
     */
    private function sendRequest(array $params)
    {
        $credentials = base64_encode(ACCOUNT_ID . ":" . APPLICATION_KEY);
        $url = "https://api.backblaze.com/b2api/v1/" . $params['action'];

        $session = curl_init($url);

        // Add headers
        $headers = array();
        $headers[] = "Accept: application/json";
        $headers[] = "Authorization: Basic " . $credentials;
        curl_setopt($session, CURLOPT_HTTPHEADER, $headers);  // Add headers

        curl_setopt($session, CURLOPT_HTTPGET, true);  // HTTP GET
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true); // Receive server response
        $server_output = curl_exec($session);
        curl_close ($session);
        return $server_output;
    }
}