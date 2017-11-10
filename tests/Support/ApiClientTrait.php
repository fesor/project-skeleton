<?php

namespace Tests\Support;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

trait ApiClientTrait
{
    private $defaultHeaders = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];
    private $headers = [];

    abstract protected function getContainer(): ContainerInterface;

    abstract protected function getKernel(): KernelInterface;

    abstract protected function getFileFixturesPath(): string;

    protected function signedInAs(string $email)
    {
        $token = sha1($email); // fixme: just pseudo random string for example
        $this->headers['X-Authorization'] = "Bearer {$token}";
    }

    /**
     * @param string     $method
     * @param string     $uri
     * @param mixed|null $body
     *
     * @return Response
     */
    protected function request(string $method, string $uri, $body = null): Response
    {
        if (!in_array($method, ['GET', 'HEAD', 'OPTIONS'])) {
            $body = json_encode($body);
        } else {
            $body = null;
        }

        $request = Request::create($uri, $method, [], [], [], $this->headers(), $body);

        return $this->handleRequest($request);
    }

    protected function multipartRequest(string $uri, array $parameters = [], array $files = []): Response
    {
        $this->headers['Content-Type'] = null;
        $request = Request::create($uri, 'POST', $parameters, [], $this->processFiles($files), $this->headers());

        return $this->handleRequest($request);
    }

    private function headers()
    {
        $headers = array_filter(array_replace($this->defaultHeaders, $this->headers));
        $keys = array_map(function ($key) {
            if ($key === 'Content-Type') {
                return 'CONTENT_TYPE';
            }

            return 'HTTP_'.str_replace('-', '_', strtoupper($key));
        }, array_keys($headers));

        return array_combine($keys, array_values($headers));
    }

    private function processFiles(array $files = [])
    {
        return array_map(function (string $file) {
            $filePath = sprintf('%s/%s', $this->getFileFixturesPath(), $file);
            $temp = tmpfile();
            $tempFilePath = stream_get_meta_data($temp)['url'];
            stream_copy_to_stream(fopen($filePath, 'r'), $temp);

            return new UploadedFile(
                $tempFilePath,
                pathinfo($filePath, PATHINFO_BASENAME),
                $this->mimetypeByExt(pathinfo($filePath, PATHINFO_EXTENSION)),
                filesize($filePath),
                null,
                true
            );
        }, $files);
    }

    private function handleRequest(Request $request): Response
    {
        $kernel = $this->getKernel();

        return $kernel->handle($request);
    }

    private function mimetypeByExt($ext)
    {
        return [
            'txt' => 'text/plain',
            'html' => 'text/html',
            'json' => 'application/json',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'svg' => 'image/png',
            'bmp' => 'image/bmp',
            'mpeg' => 'video/mpeg',
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/wav',
            'zip' => 'application/zip',
        ][mb_strtolower($ext)] ?? 'application/octet-stream';
    }
}
