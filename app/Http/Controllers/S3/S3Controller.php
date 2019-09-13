<?php

namespace App\Http\Controllers\S3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Aws\S3\S3Client;
use Aws\Sdk;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Illuminate\Contracts\Filesystem\Filesystem;

class S3Controller extends Controller
{
    /**
     * Uplaod S3
     *
     * @bodyParam file string required Base64
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function store_64(Request $request)
    {
        $s3Client = new S3Client([
            'region' => 'us-east-2',
            'version' => 'latest',
            'credentials' => [
                'key'    => 'AKIA5QDANSEOP4IS7GCP',
                'secret' => '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',
            ]
        ]);
        
        $input = $request->all();
        $type = substr($input['image'], 5, strpos($input['image'], ';')-5);
        $base64_str = substr($input['image'], strpos($input['image'], ",") + 1);
        $image = base64_decode($base64_str);
        $data = getimagesizefromstring($image);
        $imageFileName = time() . '' .image_type_to_extension($data[2]);
        
        $result = $s3Client->putObject([
            'Bucket' => 's3-galgun',
            'ContentType' => $type,
            'Key' => $imageFileName,
            'Body' => $image,
            'ACL' => 'public-read'
        ]);

        return response()->json([
            'data' => ['message' => 'Image uploaded succesfully',
                       'url' => 'https://s3-galgun.s3.us-east-2.amazonaws.com/'.$imageFileName
                      ]
        ], 200);
    }

    /**
     * Uplaod S3
     *
     * @bodyParam file file required File
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function store_file(Request $request)
    {
        $s3Client = new S3Client([
            'region' => 'us-east-2',
            'version' => 'latest',
            'credentials' => [
                'key'    => 'AKIA5QDANSEOP4IS7GCP',
                'secret' => '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',
            ]
        ]);
        
        $input = $request->all();
        $image = $input['image'];
        $extension = $image->getClientOriginalExtension();
        $type = $image->getMimeType();
        $imageFileName = time() . '.' .$extension;

        $image = file_get_contents($image);
        $result = $s3Client->putObject([
            'Bucket' => 's3-galgun',
            'ContentType' => $type,
            'Key' => $imageFileName,
            'Body' => $image,
            'ACL' => 'public-read'
        ]);

        return response()->json([
            'data' => ['message' => 'Image uploaded succesfully', 
                       'url' => 'https://s3-galgun.s3.us-east-2.amazonaws.com/'.$imageFileName
                      ]
        ], 200);
    }
}
